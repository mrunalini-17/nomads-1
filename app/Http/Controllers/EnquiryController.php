<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\NewEnquiryMail;
use App\Models\Enquiry;
use App\Models\Service;
use App\Models\Source;
use App\Models\Notification;
use App\Models\UserEmployee;
use App\Models\EnquiryRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\WhatsAppService;


class EnquiryController extends Controller
{
    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index()
    {
        $enquiries = Enquiry::active()->orderBy('created_at', 'desc')->get();

        return view('homecontent.enquirie.index', compact('enquiries'));
    }

    public function new_index()    //for employee login
    {
        $emp_id = Auth::id();
        $employee = UserEmployee::findOrFail($emp_id);

        if ($employee->isAdmin() || $employee->isManager()) {
            $enquiries = Enquiry::active()
            ->where('is_accepted', false)
            ->orderBy('created_at', 'desc')
            ->get();
        }else{
            $enquiries = Enquiry::active()
            ->where('is_accepted', false)
            ->where(function($query) use ($emp_id) {
                $query->whereJsonContains('employees', $emp_id) // Enquiries assigned to the employee
                    ->orWhereJsonLength('employees', 0)    // Enquiries with no assigned employees
                    ->orWhere('added_by', $emp_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        }
        return view('homecontent.enquirie.new_index', compact('enquiries'));
    }
    public function accepted_index()
    {
        $emp_id = Auth::id();
        $employee = UserEmployee::findOrFail($emp_id);

        if ($employee->isAdmin() || $employee->isManager()) {
            $enquiries = Enquiry::active()->where('is_accepted',true)->orderBy('created_at', 'desc')->get();
        }else{
            $enquiries = Enquiry::active()->where('is_accepted',true)->where('accepted_by',$emp_id)->orderBy('created_at', 'desc')->get();
        }

        return view('homecontent.enquirie.accepted_index', compact('enquiries'));
    }

    public function create()
    {
        $services = Service::active()->get();
        $sources = Source::active()->get();
        $employees = UserEmployee::active()->where('is_active', true)
            ->whereHas('userRole', function ($query) {
                $query->where('name', '!=', 'Accounts'); // Exclude role name 'Accounts'
            })
            ->orderBy('first_name', 'asc')
            ->get();
        return view('homecontent.enquirie.create', compact('services','sources','employees'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'mobile' => [
                    'required', 'string', 'max:20',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^\+\d{10,15}$/', $value)) {
                            $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                        }
                    },
                ],
                'whatsapp' => [
                    'nullable', 'string', 'max:20',
                    function ($attribute, $value, $fail) {
                        if ($value && !preg_match('/^\+\d{10,15}$/', $value)) {
                            $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                        }
                    },
                ],
                'email' => 'nullable|email',
                'address' => 'nullable|string|max:255',
                'services' => 'required|array',
                'services.*' => 'exists:services,id',
                'employees' => 'nullable|array',
                'employees.*' => 'nullable|exists:employees,id',
                'priority' => 'required|string|max:50',
                'source_id' => 'required|exists:sources,id',
                'status' => 'nullable|in:New,Active,Converted,Dead',
                'note' => 'nullable|string|max:500',
            ]);

            // Extract the date in desired format from current timestamp
            $date = Carbon::now()->format('Ymd');

            // Count enquiries created on the same date
            $countForToday = Enquiry::whereDate('created_at', Carbon::now()->toDateString())->count() + 1;

            // Generate unique code in the format: ENYYYYMMDD-XXX
            $uniqueCode = 'NHE' . $date . '-' . str_pad($countForToday, 3, '0', STR_PAD_LEFT);

            // Prepare data for insertion
            $data = $request->except(['services', 'employees']);
            $data['unique_code'] = $uniqueCode;
            $data['added_by'] = auth()->id();
            $data['services'] = json_encode(array_map('intval', $request->input('services', [])));
            $data['employees'] = json_encode(array_map('intval', $request->input('employees', [])));

            $enquiry = Enquiry::create($data);

            $rawEmployees = $enquiry->getAttributes()['employees'];
            $employeeIds = json_decode($rawEmployees, true) ?: [];

            $priority = $request->priority;

            $notificationData = [
                'type' => 'enquiry',
                'type_id' => $enquiry->id,
                'employees' => $data['employees'],
                'message' => "New enquiry with Priority : {$priority} .",
                'is_read' => false, // unread
                'read_by' => json_encode([]),
            ];

            // Create the notification
            Notification::create($notificationData);

            if (!empty($employeeIds)) {
                // Check if $assignedEmployeeIds is valid and flatten the array
                $assignedEmployeeIds = is_array($employeeIds)
                    ? array_filter($employeeIds, fn($id) => is_numeric($id))
                    : [];

                $mailRecipients = UserEmployee::whereIn('id', $assignedEmployeeIds)
                                    ->where('is_active', true)
                                    ->get(['email', 'first_name', 'last_name']);

                $msgRecipients = UserEmployee::whereIn('id', $assignedEmployeeIds)
                                    ->where('is_active', true)
                                    ->get(['whatsapp', 'first_name', 'last_name','countrycode']);
            } else {
                // Fetch emails of employees with role = admin, manager, or operations
                $mailRecipients = UserEmployee::where('id', 28)
                                ->where('is_active', true)
                                ->get(['email', 'first_name', 'last_name']);

                $msgRecipients = UserEmployee::where('id', 28)
                                ->where('is_active', true)
                                ->get(['whatsapp', 'first_name', 'last_name','countrycode']);
            }

            foreach ($mailRecipients as $recipient) {
                $recipientName = "{$recipient->first_name} {$recipient->last_name}";
                $subject = "New Enquiry ID: {$enquiry->unique_code} for {$enquiry->fname} {$enquiry->lname} assigned to {$recipientName}.";

                try {
                    Mail::to($recipient->email)->send(new NewEnquiryMail($enquiry, $subject, $recipientName));
                } catch (\Exception $mailException) {
                    \Log::error('Failed to send email to ' . $recipient->email . ': ' . $mailException->getMessage());
                    // Optionally, you can store a message to notify the user
                    $emailFailure[] = $recipient->email;
                }
            }

            // Prepare WhatsApp message details
            $addedBy = $enquiry->addedBy->first_name.' '.$enquiry->addedBy->last_name;
            $guestname = $enquiry->fname.' '.$enquiry->lname;
            $callbackData = 'new enquiry';


                foreach ($msgRecipients as $recipient) {
                    $recipientName = "{$recipient->first_name} {$recipient->last_name}";
                    $bodyValues = [$recipientName, $addedBy, $guestname, $enquiry->unique_code, $enquiry->note, $enquiry->source->title, $enquiry->priority];
                    try {
                        $this->whatsappService->sendNewEnquiryMessage(
                            $recipient->countrycode,
                            $recipient->whatsapp,
                            $callbackData,
                            $bodyValues
                        );
                    } catch (\Exception $e) {
                        \Log::error("Error sending WhatsApp message: " . $e->getMessage());
                    }
                }



            $successMessage = 'Enquiry created successfully.';
            if (!empty($emailFailure)) {
                $failedEmails = implode(', ', $emailFailure);
                $successMessage .= " However, the email could not be sent to the following recipients: {$failedEmails}.";
            }

            if (auth()->user()->isOperations()) {
                return redirect()->route('new_enquiries.index')->with('success', $successMessage);
            }

            return redirect()->route('enquiries.index')->with('success', $successMessage);

        } catch (\Exception $e) {
            \Log::error('Enquiry creation failed: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'Failed to create enquiry: ' . $e->getMessage());
        }
    }

    public function show($id)   //for View Modal for accepting new enquiry by 'operations'
    {
        $enquiry = Enquiry::active()->with(['addedBy', 'acceptedBy'])->findOrFail($id);
        return response()->json($enquiry);
    }

    public function show_enquiry($id) //for show view page
    {
        $enquiry = Enquiry::active()->with(['addedBy', 'acceptedBy'])->findOrFail($id);
        $employees = $enquiry->employees;
        // dd($employees);

        return view('homecontent.enquirie.show', compact('enquiry', 'employees'));
    }

    public function edit($id)
    {
        $enquiry = Enquiry::with('acceptedBy')->findOrFail($id);
        $services = Service::active()->get();

        $employees = UserEmployee::active()->where('is_active', true)
            ->whereHas('userRole', function ($query) {
                $query->where('name', '!=', 'Accounts'); // Exclude role name 'Accounts'
            })
            ->orderBy('first_name', 'asc')
            ->get();

        return view('homecontent.enquirie.edit', compact('enquiry', 'services', 'employees'));
    }

    public function edit_accepted($id)
    {
        $enquiry = Enquiry::with('acceptedBy')->findOrFail($id);
        $assignedemployees = $enquiry->employees;

        $employees = UserEmployee::active()
        ->where('is_active', true)
        ->whereHas('userRole', function ($query) {
            $query->where('name', '!=', 'Accounts'); // Exclude role name 'Accounts'
        })
        ->orderBy('first_name', 'asc')
        ->get();

        return view('homecontent.enquirie.update_accepted', compact('enquiry','employees','assignedemployees'));
    }

    public function edit_followups($id)
    {
        $enquiry = Enquiry::with('acceptedBy')->findOrFail($id);

        $employees = UserEmployee::active()
        ->where('is_active', true)
        ->whereHas('userRole', function ($query) {
            $query->where('name', '!=', 'Accounts');
        })
        ->orderBy('first_name', 'asc')
        ->get();

        return view('homecontent.enquirie.follow_up', compact('enquiry','employees'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $rules = [
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'whatsapp' => 'nullable|string|max:15',
                'email' => 'nullable|email',
                'address' => 'nullable|string|max:255',
                'services' => 'required|array',
                'services.*' => 'exists:services,id',
                // 'priority' => 'required|string|max:50',
                'status' => 'nullable|in:New,Active,Converted,Dead',
                'note' => 'nullable|string|max:500',
            ];


            if ($request->has('employees') && !is_null($request->employees)) {
                $rules['employees'] = 'nullable|array';
                $rules['employees.*'] = 'exists:employees,id';
            }

            if ($request->has('remark_type') && $request->has('remark')) {
                $rules['remark_type.*'] = 'required|string';
                $rules['remark.*'] = 'required|string';
            }

            $request->validate($rules);

            $enquiry = Enquiry::findOrFail($id);

            $updateData = $request->except(['employees', 'services']);

            $updateData['services'] = json_encode(array_map('intval', $request->input('services')));

            if ($request->has('employees') && !is_null($request->employees)) {
                $updateData['employees'] = json_encode(array_map('intval', $request->input('employees')));
            }

            $enquiry->update($updateData);

            if ($request->has('remark_type') && $request->has('remark')) {
                foreach ($request->remark_type as $index => $remarkType) {
                    EnquiryRemark::create([
                        'enquiry_id' => $id,
                        'remark_type' => $remarkType,
                        'description' => $request->remark[$index],
                        'added_by' => auth()->id(),
                        'is_deleted' => false,
                    ]);
                }
            }


            return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update enquiry: ' . $e->getMessage());
        }
    }


    public function accept_enquiry(Request $request, $id)
    {
        // dd($request->all());
        try {
            if ($request->has('remark_type') && $request->has('remark')) {
                $rules['remark_type.*'] = 'required|string';
                $rules['remark.*'] = 'required|string';
                $request->validate($rules);
            }

            $enquiry = Enquiry::findOrFail($id);

            if($request->input('update')==="0"){
                $enquiry->update([
                    'is_accepted' => true,
                    'status' => 'Active',
                    'accepted_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                    'accepted_at' => now(),
                ]);
            }else{
                $enquiry->update([
                    'status' => $request->status,
                    'updated_by' => auth()->id(),
                ]);
            }

            // Store remarks only if they are present in the request
            if ($request->has('remark_type') && $request->has('remark')) {
                foreach ($request->remark_type as $index => $remarkType) {
                    EnquiryRemark::create([
                        'enquiry_id' => $id,
                        'remark_type' => $remarkType,
                        'description' => $request->remark[$index],
                        'added_by' => auth()->id(),
                        'is_deleted' => false,
                    ]);
                }
            }



            return redirect()->back()->with('success', 'Enquiry updated successfully.');
        } catch (\Exception $e) {
            // Handle the error and redirect with an error message
            return redirect()->back()->with('error', 'Failed to update enquiry: ' . $e->getMessage());
        }
    }

    public function transfer_enquiry(Request $request, $id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $emp_id = auth()->id();

        try {
            if ($request->has('remark_type_tranfer') && $request->has('remark_transfer')) {
                $rules['remark_type_tranfer.*'] = 'required|string';
                $rules['remark_transfer'] = 'required|string';
                // $rules['employee'] = 'required|int';
                $request->validate($rules);
            }

            // Get the employee the enquiry is currently assigned to (before the transfer)
            $transferredFromEmployee = $enquiry->acceptedBy;

            if ($transferredFromEmployee) {
                $transferredFromName = $transferredFromEmployee->first_name . ' ' . $transferredFromEmployee->last_name;
            } else {
                $transferredFromName = "Unassigned";
            }

            // $transferredToEmployee = UserEmployee::findOrFail($request->employee);
            // $transferredToName = $transferredToEmployee->first_name . ' ' . $transferredToEmployee->last_name;

            // Update enquiry to reflect the transfer
            $data['is_transferred'] = true;
            $data['is_accepted'] = false;
            $data['accepted_by'] = null;
            $data['accepted_at'] = null;
            $data['status'] = 'New';

            // $data['accepted_by'] = $request->employee;
            $enquiry->update($data);

            // Create a remark noting the transfer
            EnquiryRemark::create([
                'enquiry_id' => $id,
                'remark_type' => 'transfer',
                'description' => "Enquiry transferred from " . $transferredFromName,
                'added_by' => auth()->id(),
                'is_deleted' => false,
            ]);

            // Create a remark with the user's input remark
            EnquiryRemark::create([
                'enquiry_id' => $id,
                'remark_type' => $request->remark_type_tranfer,
                'description' => $request->remark_transfer,
                'added_by' => $emp_id,
                'is_deleted' => false,
            ]);

            return redirect()->route('accepted_enquiries.index')->with('success', 'Enquiry transferred successfully.');
        } catch (\Exception $e) {
            // Handle the error and redirect with an error message
            return redirect()->back()->with('error', 'Failed to update enquiry: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $enquiry->softDelete();

        return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully.');
    }
}
