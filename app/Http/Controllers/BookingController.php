<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
//use App\Mail\BookingHoldNotification;
use App\Mail\BookingConfirmationClient;
use App\Models\Booking;
use App\Models\BookingRemark;
use App\Models\BookingService;
use App\Models\BookingCancellation;
use App\Models\BookingConfirmation;
use App\Models\Card;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\Customer;
//use App\Models\CustomerManager;
use App\Models\PassengerCount;
use App\Models\PersonCount;
use App\Models\Reference;
use App\Models\Service;
use App\Models\Enquiry;
use App\Models\ServiceDetail;
use App\Models\State;
use App\Models\Supplier;
use App\Models\User;
use App\Models\UserEmployee;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Services\WhatsAppService;

class BookingController extends Controller
{

    protected $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->get('search', '');
            $bookings = Booking::active()
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where('unique_code', 'like', "%{$searchTerm}%")
                        ->orWhereHas('customer', function ($query) use ($searchTerm) {
                            $query->where('fname', 'like', "%{$searchTerm}%")
                                  ->orWhere('lname', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('service', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('bookingServices', function ($query) use ($searchTerm) {
                            $query->where('confirmation_number', 'LIKE', "%{$searchTerm}%");
                        })
                        ->orWhereHas('bookingServices', function ($query) use ($searchTerm) {
                            $query->where('service_details', 'LIKE', "%{$searchTerm}%");
                        })
                        ;
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return response()->json([
                'bookings' => $bookings,
                'view' => view('homecontent.booking.partials.booking_table', compact('bookings'))->render(),
            ]);
        }

        $bookings = Booking::active()->orderByDesc('created_at')->paginate(10);
        return view('homecontent.booking.index', compact('bookings'));
    }

    public function operations_index(Request $request)
    {
        $employee_id = Auth::id();
        if ($request->ajax()) {
            $searchTerm = $request->get('search', '');
            $bookings = Booking::active()
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where('unique_code', 'like', "%{$searchTerm}%")
                        ->orWhereHas('customer', function ($query) use ($searchTerm) {
                            $query->where('fname', 'like', "%{$searchTerm}%")
                                  ->orWhere('lname', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('service', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('bookingServices', function ($query) use ($searchTerm) {
                            $query->where('confirmation_number', 'LIKE', "%{$searchTerm}%");
                        })
                        ->orWhereHas('bookingServices', function ($query) use ($searchTerm) {
                            $query->where('service_details', 'LIKE', "%{$searchTerm}%");
                        })
                        ;
                })
                ->where('added_by',$employee_id)
                ->orderByDesc('created_at')
                ->paginate(10);

            return response()->json([
                'bookings' => $bookings,
                'view' => view('homecontent.booking.partials.booking_table', compact('bookings'))->render(),
            ]);
        }

        $user_role = UserEmployee::where('id',$employee_id)->value('user_role_id');
        $bookings = Booking::active()->where('added_by',$employee_id)->orderByDesc('created_at')->paginate(10);
        return view('homecontent.booking.operations_index', compact('bookings','employee_id','user_role'));
    }

    public function pending_index(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->get('search', '');
            $bookings = Booking::active()
                ->where('is_approved', false) // Ensure only pending bookings are retrieved
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where('unique_code', 'like', "%{$searchTerm}%")
                        ->orWhereHas('customer', function ($query) use ($searchTerm) {
                            $query->where('fname', 'like', "%{$searchTerm}%")
                                  ->orWhere('lname', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('service', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('bookingServices', function ($query) use ($searchTerm) {
                            $query->where(function ($query) use ($searchTerm) {
                                $query->where('confirmation_number', 'LIKE', "%{$searchTerm}%")
                                      ->orWhere('service_details', 'LIKE', "%{$searchTerm}%");
                            });
                        });
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return response()->json([
                'bookings' => $bookings,
                'view' => view('homecontent.booking.partials.pending_booking_table', compact('bookings'))->render(),
            ]);
        }

        $employee_id = Auth::id();
        $bookings = Booking::active()
            ->where('is_approved', false)
            ->orderByDesc('created_at')
            ->paginate(10);

        $user_role = UserEmployee::where('id', $employee_id)->value('user_role_id');
        return view('homecontent.booking.pending_index', compact('bookings', 'employee_id', 'user_role'));
    }

    public function approved_index(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->get('search', '');
            $bookings = Booking::active()
                ->where('is_approved', true) // Ensure only approved bookings are retrieved
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where('unique_code', 'like', "%{$searchTerm}%")
                        ->orWhereHas('customer', function ($query) use ($searchTerm) {
                            $query->where('fname', 'like', "%{$searchTerm}%")
                                  ->orWhere('lname', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('service', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', "%{$searchTerm}%");
                        })
                        ->orWhereHas('bookingServices', function ($query) use ($searchTerm) {
                            $query->where(function ($query) use ($searchTerm) {
                                $query->where('confirmation_number', 'LIKE', "%{$searchTerm}%")
                                      ->orWhere('service_details', 'LIKE', "%{$searchTerm}%");
                            });
                        });
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return response()->json([
                'bookings' => $bookings,
                'view' => view('homecontent.booking.partials.approved_booking_table', compact('bookings'))->render(),
            ]);
        }

        $employee_id = Auth::id();
        $bookings = Booking::active()
            ->where('is_approved', true)
            ->orderByDesc('created_at')
            ->paginate(10);

        $user_role = UserEmployee::where('id', $employee_id)->value('user_role_id');
        return view('homecontent.booking.approved_index', compact('bookings', 'employee_id', 'user_role'));
    }

    public function create()
    {
        // $users = UserEmployee::active()->get();
        // $customers = Customer::active()->get();
        // $managers = CustomerManager::active()->get();
        $references = Reference::active()->get();
        $services = Service::active()->get();
        // $enquiries = Enquiry::active()->get();
        $suppliers = Supplier::active()->get();
        $cards = Card::active()->get();
        $countries = Country::all();
        $cities = City::all();
        $states = State::all();
        // return view('homecontent.booking.create', compact('suppliers', 'references', 'users', 'customers', 'managers', 'services', 'enquiries', 'cards', 'countries', 'cities', 'states'));
        return view('homecontent.booking.create', compact('suppliers', 'references', 'services',  'cards', 'countries', 'cities', 'states'));
    }

    public function store(Request $request)
    {

        // dd($request->all());
        try {
            DB::beginTransaction();

            // Unique code
            $today = now();
            $date = Carbon::parse($today)->format('Ymd');
            $countForToday = Booking::whereDate('created_at', $today->toDateString())->count() + 1;
            $uniqueCode = 'NHB' . $date . '-' . str_pad($countForToday, 3, '0', STR_PAD_LEFT);

            $mmShareable = filter_var($request->input('mm_shareable'), FILTER_VALIDATE_BOOLEAN);
            $amountShareable = filter_var($request->input('amount_shareable'), FILTER_VALIDATE_BOOLEAN);
            $remarkShareable = filter_var($request->input('client_remark_shareable'), FILTER_VALIDATE_BOOLEAN);


            $booking = new Booking();
            $booking->unique_code = $uniqueCode;
            $booking->customer_id = $request->input('customer_id');
            $booking->customer_manager_id = $request->input('customer_manager_id');
            $booking->user_id = Auth::id();
            $booking->booking_date = $request->input('booking_date');
            $booking->passenger_count = $request->input('passenger_count');
            $booking->service_id = $request->input('service_id');
            $booking->status = $request->input('status');
            $booking->pan_number = $request->input('pan_number');
            $booking->invoice_number = $request->input('invoice_number');
            $booking->payment_status = $request->input('payment_status');
            $booking->payment_received_remark = $request->input('payment_received_remark');
            $booking->office_reminder = $request->input('office_reminder');
            $booking->is_cancelled = false;
            $booking->mm_shareable = $mmShareable;
            $booking->amount_shareable = $amountShareable;
            $booking->added_by = Auth::id();
            $booking->save();

            if($request->filled('customer_manager_id')){
                //Sync manager with customer in pivot table
                $actualCustomer = Customer::find($request->customer_id);

                $actualCustomer->update([
                    'have_manager' => 1,
                    'updated_by' => Auth::id(),
                ]);

                $manager = [$request->input('customer_manager_id')];
                $actualCustomer->managers()->syncwithoutDetaching($manager);
            }



            $serviceDetails = $request->input('service_details', []);
            $travelDates1 = $request->input('travel_date1', []);
            $travelDates2 = $request->input('travel_date2', []);
            $confirmationNumbers = $request->input('confirmation_number', []);
            $nets = $request->input('net', []);
            $serviceFees = $request->input('service_fees', []);
            $maskFees = $request->input('mask_fees', []);
            // $bills = $request->input('bill', []);
            $bill_to = $request->input('bill_to',[]);
            $bill_to_remark = $request->input('bill_to_remark',[]);
            $tcsValues = $request->input('tcs', []);
            $cardIds = $request->input('card_id', []);
            $supplierIds = $request->input('supplier_id', []);

            $count = count($serviceDetails);
            for ($i = 0; $i < $count; $i++) {
                if (!empty($serviceDetails[$i]) || !empty($travelDates1[$i]) || !empty($travelDates2[$i]) || !empty($confirmationNumbers[$i]) || !empty($nets[$i]) || !empty($serviceFees[$i]) || !empty($maskFees[$i]) || !empty($bills[$i]) || !empty($tcsValues[$i]) || !empty($cardIds[$i]) || !empty($supplierIds[$i])) {
                    $bookingService = new BookingService();
                    $bookingService->booking_id = $booking->id;
                    $bookingService->service_details = $serviceDetails[$i] ?? null;
                    $bookingService->travel_date1 = $travelDates1[$i] ?? null;
                    $bookingService->travel_date2 = $travelDates2[$i] ?? null;
                    $bookingService->confirmation_number = $confirmationNumbers[$i] ?? null;
                    $bookingService->net = $nets[$i] ?? null;
                    $bookingService->service_fees = $serviceFees[$i] ?? null;
                    $bookingService->mask_fees = $maskFees[$i] ?? null;
                    // $bookingService->bill = $bills[$i] ?? null;
                    $bookingService->bill_to = $bill_to[$i] ?? null;
                    $bookingService->bill_to_remark = $bill_to_remark[$i] ?? null;
                    $bookingService->tcs = $tcsValues[$i] ?? null;
                    $bookingService->card_id = $cardIds[$i] ?? null;
                    $bookingService->gross_amount = $request->input('gross_amount')[$i] ?? null;
                    $bookingService->supplier_id = $supplierIds[$i] ?? null;
                    $bookingService->added_by = Auth::id();
                    $bookingService->save();

                    if (!empty($travelDates1[$i])) {
                        BookingConfirmation::create([
                            'booking_id' => $booking->id,
                            'booking_service_id' => $bookingService->id,
                            'is_delivered' => false,
                            'note' => null,
                            'updated_by' => null,
                            'date' => $travelDates1[$i],
                        ]);
                    }

                    if (!empty($travelDates2[$i])) {
                        BookingConfirmation::create([
                            'booking_id' => $booking->id,
                            'booking_service_id' => $bookingService->id,
                            'is_delivered' => false,
                            'note' => null,
                            'updated_by' => null,
                            'date' => $travelDates2[$i],
                        ]);
                    }
                }
            }

            // Store remarks
            $remarkTypes = ['client_remark' => 'client', 'account_remark' => 'account', 'office_remark' => 'office'];
            foreach ($remarkTypes as $inputName => $remarkType) {
                // Check if the input exists and is not null or empty
                $description = $request->input($inputName);
                if ($request->has($inputName) && !is_null($description) && trim($description) !== '') {
                    $remark = new BookingRemark();
                    $remark->booking_id = $booking->id;
                    $remark->description = $description;
                    $remark->remark_type = $remarkType;
                    $remark->is_active = true;
                    $remark->is_acknowledged = false;
                    if($remarkType == 'client'){
                        $remark->is_shareable = $remarkShareable;
                    }else{
                        $remark->is_shareable = true;
                    }
                    $remark->acknowledged_by = null;
                    $remark->added_by = Auth::id();
                    $remark->save();
                }
            }


            $passengers = $request->input('passengers', []);
            foreach ($passengers as $passengerData) {
                $passenger = new PassengerCount();
                $passenger->booking_id = $booking->id;
                $passenger->name = $passengerData['name'];
                // $passenger->age = $passengerData['age'];
                $passenger->gender = $passengerData['gender'];
                $passenger->updated_by = Auth::id();
                $passenger->added_by = Auth::id();
                $passenger->save();
            }

            // Commit transaction
            DB::commit();

            $employees = UserEmployee::whereIn('user_role_id', [1, 2, 3])->pluck('id')->toArray();

            $loggedInUserId = Auth::id();
            if (!in_array($loggedInUserId, $employees)) {
                $employees[] = $loggedInUserId;
            }

            $employees = array_map('intval', $employees);

            $serviceName = $booking->service->name;

            $notificationData = [
                'type' => 'booking',
                'type_id' => $booking->id,
                'employees' => json_encode($employees),
                'message' => 'New booking for the service: ' . $serviceName . '.',
                'is_read' => false,
                'read_by' => json_encode([]),
            ];

            // Create the notification
            Notification::create($notificationData);

            // Send reminder to office team if status is 'Hold' -- Pending
            $emailSent = true;

            if($mmShareable){

                $msgrecipients = [];

                    // Add Customer WhatsApp details
                    if (!empty($booking->customer->whatsapp)) {
                        $msgrecipients[] = $this->extractWhatsAppDetails($booking->customer);
                    }

                    // Add Manager WhatsApp details (if applicable)
                    if ($request->filled('customer_manager_id') && !empty($booking->customerManager->whatsapp)) {
                        $msgrecipients[] = $this->extractWhatsAppDetails($booking->customerManager);
                    }


                // Prepare WhatsApp message details
                if ($count === 1) {
                    if (!empty($msgrecipients)) {
                        foreach ($msgrecipients as $recipient) {
                            $this->sendWhatsAppMessage($recipient, $booking, $amountShareable, $remarkShareable);
                        }
                    }
                }
                else if($count > 1){
                    //genrate PDF and store in S3 Bucket, update URL in booking
                    $pdfURL = "";
                    //**Uncomment following line for generating the PDF for sending with whatsapp msg and the mail
                    //$pdfURL = $this->generateAndStoreBookingPdf($booking->id);

                    if ($pdfURL) {
                        $booking->update(['url' => $pdfURL]);
                        \Log::info("Booking ID {$booking->id} updated with PDF URL: {$booking->url}");

                        if (!empty($msgrecipients)) {
                            //Uncomment following lines for sending wahtsapp msg
                            // foreach ($msgrecipients as $recipient) {
                            //     $this->sendWhatsAppWithPDFMessage($recipient, $booking);
                            // }
                        }
                    } else {
                        \Log::warning("PDF upload failed and {$booking->unique_code}");
                    }

                }
                $emailSent = $this->sendBookingConfirmationEmail($booking);
            }


            $user = UserEmployee::find(Auth::id());
            $successMessage = 'Booking created successfully.';
            if (!$emailSent) {
                $successMessage .= ' However, the email could not be sent.';
            }

            // Check user roles and redirect accordingly
            if ($user->isAdmin() || $user->isManager()) {
                return redirect()->route('bookings.index')->with('success', $successMessage);
            } elseif ($user->isOperations()) {
                return redirect()->route('bookings.operations_index')->with('success', $successMessage);
            } else {
                return redirect()->route('bookings.index')->with('success', $successMessage);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ]);
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'An error occurred: ' . $e->getMessage());
            }
        }
    }

    public function edit($id)
    {
        $booking = Booking::with([
            'passengerCounts',
            'bookingRemarks',
            'serviceDetails' => function ($query) {
                $query->orderBy('is_approved', 'desc');
            },
        ])->findOrFail($id);

        $service_id = $booking->service_id;

        // Fetch the suppliers that provide the service associated with this booking
        $suppliers = Supplier::whereHas('services', function ($query) use ($service_id) {
                        $query->where('service_id', $service_id);
                        })->active()->get();


        // $customers = Customer::active()->get();
        // $customerManagers = CustomerManager::active()->get();
        // $employees = UserEmployee::active()->get();
        // $companies = Company::active()->get();
        $countries = Country::all();
        $cities = City::all();
        $states = State::all();
        $cards = Card::active()->get();
        // $references = Reference::active()->get();

        // Pass data to the view
        return view('homecontent.booking.edit', [
            'countries' => $countries,
            'cities' => $cities,
            'states' => $states,
            'booking' => $booking,
            // 'customers' => $customers,
            // 'customerManagers' => $customerManagers,
            // 'employees' => $employees,
            // 'services' => $services,
            // 'companies' => $companies,
            // 'references' => $references,
            'suppliers' => $suppliers,
            'remarks' => $booking->bookingRemarks,
            'cards' => $cards,
            'serviceDetails' => $booking->serviceDetails,
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        try {
            $booking = Booking::findOrFail($id);

            //$booking_date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->input('booking_date'))->format('Y-m-d');
            $office_reminder = \Carbon\Carbon::parse($request->input('office_reminder'))->format('Y-m-d H:i:s');
            // $is_approved = $request->has('is_approved') ? 1 : 0;

            $booking->update([
                'passenger_count' => $request->input('passenger_count'),
                'status' => $request->input('status'),
                // 'invoice_number' => $request->input('invoice_number'),
                'office_reminder' => $office_reminder,
                // 'is_approved' => $is_approved,
                'updated_by' => Auth::id(),
            ]);


            $user = UserEmployee::find(Auth::id());

            // Check user roles and redirect accordingly
            if ($user->isAdmin() || $user->isManager()) {
                return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
            } elseif ($user->isOperations()) {
                return redirect()->route('bookings.operations_index')->with('success', 'Booking updated successfully.');
            } elseif ($user->isAccounts()){
                return redirect()->route('bookings.approved_index')->with('success', 'Booking updated successfully.');
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to update booking: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->softDelete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    public function show($id)
    {

        $user = UserEmployee::find(Auth::id());
        $booking = Booking::findOrFail($id);

        if ($user->isAccounts() && !$booking->is_accepted){
            $booking->update([
                'is_accepted' => true,
                'accepted_by' => $user->id,
            ]);
        }

        $cancellation = null;

        if ($booking->is_cancelled) {
            // Fetch cancellation details from the BookingCancellation model
            $cancellation = BookingCancellation::where('booking_id', $booking->id)
                                            ->active()
                                            ->first();
        }

        return view('homecontent.booking.show', compact('booking', 'cancellation'));
    }

    public function cancel(Request $request, $id)
    {
        // dd($request->all());
        try {
            $booking = Booking::findOrFail($id);

            $booking->update([
                'status' => "Cancelled",
                'is_cancelled' => true,
                'updated_by' => Auth::id(),
            ]);

            $booking_cancelled = new BookingCancellation();
            $booking_cancelled->booking_id = $id;
            $booking_cancelled->reason = $request->input('reason');
            $booking_cancelled->details = $request->input('details');
            $booking_cancelled->charges = $request->input('charges');
            $booking_cancelled->charges_received = $request->input('charges_received');
            $booking_cancelled->added_by = Auth::id();
            $booking_cancelled->save();

            $notificationData = [
                'type' => 'booking-cancel',
                'type_id' => $id,
                'employees' => json_encode([1, 2]),
                'message' => 'Booking Canceled for ID : '.$booking->unique_code,
                'is_read' => false,
                'read_by' => json_encode([]),
            ];
            Notification::create($notificationData);



            return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to cancel booking: ' . $e->getMessage());
        }
    }


    public function update_service_delievered(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'service_id' => 'required|exists:booking_services,id',
                'confirmation_id' => 'required|exists:booking_confirmations,id',
                'note' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $confirmation = BookingConfirmation::findOrFail($request->confirmation_id);

            $confirmation->update([
                'is_delivered' => true,
                'note' => $request->input('note'),
                'updated_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update service: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function approval($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $booking = Booking::findOrFail($id);

            $booking->update([
                'is_approved' => true,
                'invoice_number' => $request->input('invoice_number'),
                'updated_by' => auth()->id(),
            ]);

            BookingService::where('booking_id', $id)
                ->update([
                    'is_approved' => true,
                ]);

            BookingRemark::where('booking_id', $id)
            ->where('remark_type', 'account')
            ->update([
                'is_acknowledged' => true,
                'acknowledged_by' => Auth::id(),
            ]);

            DB::commit();

            // return response()->json(['success' => true, 'message' => 'Booking approved successfully']);

            return redirect()->back()
                ->with('success', 'Invoice no updated successfully.');

        } catch (\Exception $e) {
             DB::rollBack();

            return redirect()->back()
                ->with('error', 'There was an error updating the booking invoice no. Please try again.'. $e->getMessage());

            // return response()->json(['success' => false, 'message' => 'There was an error processing the booking. Please try again.'. $e->getMessage()]);
        }
    }


    private function extractWhatsAppDetails($user)
    {
        $whatsappNumber = ltrim($user->whatsapp, '+'); // Remove '+' sign
        $whatsappNumber = substr($whatsappNumber, strlen($user->countrycode));

        return [
            'recipient_name' => $user->fname . ' ' . $user->lname,
            'countrycode'    => $user->countrycode,
            'whatsapp'       => $whatsappNumber,
        ];
    }

    private function sendWhatsAppMessage($recipient, $booking, $amountShareable, $remarkShareable)
    {
        $guestname = $booking->customer->fname . ' ' . $booking->customer->lname;
        $serviceDetails = $booking->bookingServices->first()->service_details;

        $travel_date1 = $booking->bookingServices->first()->travel_date1
            ? \Carbon\Carbon::parse($booking->bookingServices->first()->travel_date1)->format('d-m-Y')
            : 'N/A';

        $travel_date2 = $booking->bookingServices->first()->travel_date2
            ? \Carbon\Carbon::parse($booking->bookingServices->first()->travel_date2)->format('d-m-Y')
            : null;

        $travel_date = $travel_date2 ? $travel_date1 . ' / ' . $travel_date2 : $travel_date1;
        $confirmation_number = $booking->bookingServices->first()->confirmation_number;
        $grossAmount = $amountShareable ? $booking->bookingServices->sum('gross_amount') : '--';
        $specialRequest = $remarkShareable
            ? (optional($booking->bookingRemarks->where('remark_type', 'client')->first())->description ?? '--')
            : '--';

        $processedBy = $booking->addedBy->first_name . ' ' . $booking->addedBy->last_name;
        $processedByMobile = $booking->addedBy->mobile;

        $bodyValues = [
            $recipient['recipient_name'], $guestname, $serviceDetails, $travel_date,
            $confirmation_number, $grossAmount, $specialRequest, $processedBy, $processedByMobile
        ];

        $callbackData = 'new booking';

        if (!empty($recipient['countrycode']) && !empty($recipient['whatsapp'])) {
            $this->whatsappService->sendNewBookingGuestUpdateMessage(
                $recipient['countrycode'],
                $recipient['whatsapp'],
                $callbackData,
                $bodyValues
            );
        } else {
            \Log::error('Missing countrycode or whatsapp in recipient', $recipient);
        }
    }

    private function sendWhatsAppWithPDFMessage($recipient, $booking)
    {
        $pdfUrl = $booking->url;

        $bodyValues = []; // Make body values array as per the whatsapp template

        $callbackData = 'new booking';

        if (!empty($recipient['countrycode']) && !empty($recipient['whatsapp'])) {
            $this->whatsappService->sendNewBookingGuestUpdateMessage(
                $recipient['countrycode'],
                $recipient['whatsapp'],
                $callbackData,
                $pdfUrl,
                $bodyValues
            );
        } else {
            \Log::error('Missing countrycode or whatsapp in recipient', $recipient);
        }
    }

    private function getEmailRecipients($booking)
    {
        $recipients = [];

        // Add Customer email if available
        if (!empty($booking->customer) && !empty($booking->customer->email)) {
            $recipients[] = [
                'email' => $booking->customer->email,
                'name'  => $booking->customer->fname . ' ' . $booking->customer->lname
            ];
        } else {
            \Log::info('Customer email is not saved in the database.');
        }

        // Add Customer Manager email if available
        if (!empty($booking->customer_manager_id) && !empty($booking->customerManager) && !empty($booking->customerManager->email)) {
            $recipients[] = [
                'email' => $booking->customerManager->email,
                'name'  => $booking->customerManager->fname . ' ' . $booking->customerManager->lname
            ];
        } else {
            \Log::info('Customer Manager email is not saved in the database.');
        }

        // Add Authenticated User's email if available
        if (auth()->check() && !empty(auth()->user()->email)) {
            $recipients[] = [
                'email' => auth()->user()->email,
                'name'  => auth()->user()->name ?? 'Team Member' // Use 'name' instead of 'first_name' for compatibility
            ];
        }

        return $recipients;
    }

    private function sendBookingConfirmationEmail($booking)
    {
        $recipients = $this->getEmailRecipients($booking);
        $subject = 'Nomads Holidays : Booking Confirmation';
        $emailSent = true;

        if (!empty($recipients)) {
            foreach ($recipients as $recipient) {
                if (!empty($recipient['email']) && !empty($recipient['name'])) {
                    try {
                        Mail::to($recipient['email'])->send(new BookingConfirmationClient($booking, $subject, $recipient['name']));
                        $emailSent = true;
                    } catch (\Exception $e) {
                        \Log::error("Failed to send booking confirmation email to {$recipient['name']}: " . $e->getMessage());
                        $emailSent = false;
                    }
                }
            }
        }else{
            \Log::info('No valid recipients found for booking confirmation email.');
            $emailSent = false;
        }

        return $emailSent;
    }

    public function generateAndStoreBookingPdf($bookingId)
    {
        try {
            $booking = Booking::with(['customer', 'bookingServices', 'bookingRemarks', 'addedBy'])->findOrFail($bookingId);

            $pdf = Pdf::loadView('homecontent.booking.pdf.booking-details', compact('booking'));
            $pdf->setPaper('A4', 'portrait');
            $filename = $booking->id . '_' . time() . '.pdf';
            $filePath = "booking_documents/{$filename}";

            // Upload PDF to S3 (PUBLIC visibility)
            $uploaded = Storage::disk('s3')->put($filePath, $pdf->output(), 'public');

            if ($uploaded) {
                $url = Storage::disk('s3')->url($filePath);
                \Log::info("File uploaded successfully: {$url}");
                return $url;
            } else {
                \Log::error("Failed to upload PDF to S3 for Booking ID: {$bookingId}");
                return null;
            }
        } catch (\Exception $e) {
            \Log::error("Error generating and uploading PDF: " . $e->getMessage());
            return null;
        }
    }




}
