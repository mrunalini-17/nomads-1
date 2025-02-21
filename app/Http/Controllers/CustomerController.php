<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Company;
use App\Models\CustomerManager;
use App\Models\Service;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;


class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->get('search', '');
            $customers = Customer::active()
                ->with(['country', 'state', 'city', 'reference'])
                ->when($searchTerm, function ($query) use ($searchTerm) {
                    $query->where('fname', 'like', "%{$searchTerm}%")
                          ->orWhere('lname', 'like', "%{$searchTerm}%")
                          ->orWhere('mobile', 'like', "%{$searchTerm}%")
                          ->orWhere('whatsapp', 'like', "%{$searchTerm}%")
                          ->orWhere('email', 'like', "%{$searchTerm}%");
                })
                ->orderByDesc('created_at')
                ->paginate(10);

            return response()->json([
                'view' => view('homecontent.customer.partials.table', compact('customers'))->render(),
                'pagination' => (string) $customers->links('pagination::bootstrap-5'),
            ]);
        }

        $customers = Customer::active()
            ->with(['country', 'state', 'city', 'reference'])
            ->orderByDesc('id')
            ->paginate(10);

        return view('homecontent.customer.index', compact('customers'));
    }


    public function create()
    {
        try {
            $data['customers'] = Customer::all();
            $data['services'] = Service::all();
            $data['countries'] = Country::all();
            // $data['states'] = State::all();
            // $data['cities'] = City::all();
            $data['references'] = Reference::all();

            return view('homecontent.customer.create', $data);
        } catch (\Exception $e) {

            \Log::error('Error retrieving data for customer creation: ' . $e->getMessage());


            return redirect()->back()->with('error', 'An error occurred while retrieving the data. Please try again.');
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $rules = [
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:customers,email',
                'gender' => 'required|in:Male,Female,Other',
                'mobile' => [
                    'required', 'string', 'max:20', 'unique:customers,mobile',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^\+\d{10,15}$/', $value)) {
                            $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                        }
                    },
                ],
                'whatsapp' => [
                    'nullable', 'string', 'max:20', 'unique:customers,whatsapp',
                    function ($attribute, $value, $fail) {
                        if ($value && !preg_match('/^\+\d{10,15}$/', $value)) {
                            $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                        }
                    },
                ],
                'locality' => 'nullable|string|max:500',
                'pincode' => 'nullable',
                'country_id' => 'nullable|int|exists:countries,id',
                'state_id' => 'nullable|int|exists:states,id',
                'city_id' => 'nullable|int|exists:cities,id',
                'reference_id' => 'nullable|int|exists:references,id',
                'have_manager' => 'required|boolean',
                'have_company' => 'required|boolean',
            ];

            // Additional rules based on conditionals
            if ($request->input('have_manager') == 1) {
                $rules = array_merge($rules, [
                    'manager_fname' => 'required|string|max:255',
                    'manager_lname' => 'required|string|max:255',
                    'manager_mobile' => [
                        'required', 'string', 'max:20',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^\+\d{10,15}$/', $value)) {
                                $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                            }
                        },
                    ],
                    'manager_whatsapp' => [
                        'nullable', 'string', 'max:20',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^\+\d{10,15}$/', $value)) {
                                $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                            }
                        },
                    ],
                    'manager_email' => 'nullable|string|email|max:255',
                    'manager_position' => 'nullable|string|max:255',
                ]);
            }

            if ($request->input('have_company') == 1) {
                $rules = array_merge($rules, [
                    'company_name' => 'required|string|max:255',
                    'company_mobile' => [
                        'nullable', 'string', 'max:20',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^\+\d{10,15}$/', $value)) {
                                $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                            }
                        },
                    ],
                    'company_gst' => 'nullable|string|max:15',
                    'company_address' => 'nullable|string|max:500',
                ]);
            }

            // Validation
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            // Process the validated data here
            $validatedData = $validator->validated();

            list($whatsapp_code, $whatsapp_number) = $this->splitPhoneNumber($validatedData['whatsapp']);

            $data = [
                'fname' => $validatedData['fname'],
                'lname' => $validatedData['lname'],
                'countrycode' => $whatsapp_code,
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'mobile' => $validatedData['mobile'],
                'whatsapp' => $validatedData['whatsapp'],
                'locality' => $validatedData['locality'],
                'pincode' => $validatedData['pincode'],
                'country_id' => $validatedData['country_id'],
                'state_id' => $validatedData['state_id'],
                'city_id' => $validatedData['city_id'],
                'reference_id' => $validatedData['reference_id'],
                'have_manager' => $validatedData['have_manager'],
                'have_company' => $validatedData['have_company'],
                'added_by' => Auth::id(),
            ];

            $customer = Customer::create($data);

            if ($request->input('have_manager')) {
                CustomerManager::create([
                    'customer_id' => $customer->id,
                    'fname' => $validatedData['manager_fname'],
                    'lname' => $validatedData['manager_lname'],
                    'mobile' => $validatedData['manager_mobile'],
                    'whatsapp' => $validatedData['manager_whatsapp'],
                    'email' => $validatedData['manager_email'],
                    'relation' => $validatedData['manager_position'],
                    'added_by' => Auth::id(),
                ]);
            }

            if ($request->input('have_company')) {
                Company::create([
                    'customer_id' => $customer->id,
                    'name' => $validatedData['company_name'],
                    'mobile' => $validatedData['company_mobile'],
                    'gst' => $validatedData['company_gst'],
                    'address' => $validatedData['company_address'],
                    'added_by' => Auth::id(),
                ]);
            }

            return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
        } catch (\Exception $e) {
            \Log::error('Error creating customer: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while creating the customer. Please try again.'.$e->getMessage());
        }
    }

    public function update(Request $request, Customer $customer)
    {

        try {
            $validatedData = $request->validate([
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'email' => 'nullable|email|max:255|unique:customers,email,' . $customer->id . ',id,is_deleted,0',
                'gender' => 'nullable|in:Male,Female,Other',
                'mobile' => 'required|string|max:15|unique:customers,mobile,' . $customer->id . ',id,is_deleted,0',
                'whatsapp' => 'required|string|max:15|unique:customers,whatsapp,' . $customer->id . ',id,is_deleted,0',
                'locality' => 'nullable|string|max:500',
                'pincode' => 'nullable',
                'country_id' => 'nullable|int|exists:countries,id',
                'state_id'   => 'nullable|int|exists:states,id',
                'city_id'    => 'nullable|int|exists:cities,id',
                'reference_id'  => 'nullable|int|exists:references,id',
                'have_manager' => 'nullable|boolean',
            ]);


            $data = [
                'fname' => $validatedData['fname'],
                'lname' => $validatedData['lname'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'mobile' => $validatedData['mobile'],
                'whatsapp' => $validatedData['whatsapp'],
                'locality' => $validatedData['locality'],
                'pincode' => $validatedData['pincode'],
                'country_id' => $validatedData['country_id'],
                'state_id' => $validatedData['state_id'],
                'city_id' => $validatedData['city_id'],
                'reference_id' => $validatedData['reference_id'],
                'have_manager' => $validatedData['have_manager'] ?? 0,
                'updated_by' => Auth::id(),
            ];

            $customer->update($data);

            if (!empty($request->input('manager_fname'))) {
                $managerValidatedData = $request->validate([
                    'manager_fname' => 'required|string|max:255',
                    'manager_lname' => 'required|string|max:255',
                    'manager_mobile' => 'required|string|max:15',
                    'manager_whatsapp' => 'nullable|string|max:15',
                    'manager_email' => 'nullable|string|email|max:255|unique:customer_managers,email',
                    'manager_position' => 'nullable|string|max:255',
                ]);

                $managerData = [
                    'customer_id' => $customer->id,
                    'fname' => $managerValidatedData['manager_fname'] ,
                    'lname' => $managerValidatedData['manager_lname'],
                    'mobile' => $managerValidatedData['manager_mobile'],
                    'whatsapp' => $managerValidatedData['manager_whatsapp'],
                    'email' => $managerValidatedData['manager_email'],
                    'relation' => $managerValidatedData['manager_position'],
                ];

                CustomerManager::create($managerData);
                $customer->update(['have_manager' => true]);
            }
            // else {
            //     // If 'have_manager' is not checked, delete the associated manager record if it exists
            //     if ($customer->managers()->count() > 0) {
            //         $customer->managers()->delete();
            //     }
            // }

            return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Customer Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the customer. Please try again.'. $e->getMessage());
        }
    }

    public function show(Customer $customer)
    {

        // $services = Service::active()->get();

        return view('homecontent.customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        $data['customer'] = $customer;
        $data['services'] = Service::all();
        $data['countries'] = Country::all();
        // $data['states'] = State::all();
        // $data['cities'] = City::all();
        $data['references'] = Reference::all();
        return view('homecontent.customer.edit', $data);
    }

    public function destroy(Customer $customer)
    {
        try {

            DB::beginTransaction();

            $customer->softDelete();

            // if ($customer->have_manager) {

            //     $manager = $customer->manager;
            //     if ($manager) {
            //         $manager->softDelete();
            //     }
            // }

            // if ($customer->have_company) {

            //     $company = $customer->company;
            //     if ($company) {
            //         $company->softDelete();
            //     }
            // }

            DB::commit();

            return redirect()->route('customers.index')->with('success', 'Customer and related entities deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('customers.index')->with('error', 'An error occurred while deleting the customer. Please try again.');
        }
    }

    public function storeForBooking(Request $request)
    {
        // dd($request->all());
        try {
            $messages = [
                'mobile.required' => 'Mobile number is required.',
                'gender.required' => 'Gender is required.',
                'mobile.unique' => 'This mobile number is already registered.',
                'whatsapp.unique' => 'This WhatsApp number is already registered.',
                'email.email' => 'Please provide a valid email address.',
                'email.unique' => 'This email address is already registered.',
            ];

            if($request->have_manager){
                $validatedData = $request->validate([
                    'fname' => 'required|string|max:255',
                    'lname' => 'required|string|max:255',
                    'gender' => 'required|in:Male,Female,Other',
                    'locality' => 'nullable|string|max:500',
                    'pincode' => 'nullable|digits:6',
                    'country_id' => 'nullable|int|exists:countries,id',
                    'state_id' => 'nullable|int|exists:states,id',
                    'city_id' => 'nullable|int|exists:cities,id',
                    'reference_id' => 'nullable|int|exists:references,id',
                    'have_manager' => 'required|boolean',
                    'have_company' => 'required|boolean',
                ], $messages);

            }else{
                $validatedData = $request->validate([
                    'fname' => 'required|string|max:255',
                    'lname' => 'required|string|max:255',
                    'email' => 'nullable|email|max:255|unique:customers,email',
                    'gender' => 'nullable|in:Male,Female,Other',
                    'mobile' => [
                        'required', 'string', 'max:20', 'unique:customers,mobile',
                        function ($attribute, $value, $fail) {
                            if (!preg_match('/^\+\d{10,15}$/', $value)) {
                                $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                            }
                        },
                    ],
                    'whatsapp' => [
                        'nullable', 'string', 'max:20', 'unique:customers,whatsapp',
                        function ($attribute, $value, $fail) {
                            if ($value && !preg_match('/^\+\d{10,15}$/', $value)) {
                                $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                            }
                        },
                    ],
                    'locality' => 'nullable|string|max:500',
                    'pincode' => 'nullable|digits:6',
                    'country_id' => 'nullable|int|exists:countries,id',
                    'state_id' => 'nullable|int|exists:states,id',
                    'city_id' => 'nullable|int|exists:cities,id',
                    'reference_id' => 'nullable|int|exists:references,id',
                    'have_company' => 'required|boolean',
                ], $messages);

                list($whatsapp_code, $whatsapp_number) = $this->splitPhoneNumber($validatedData['whatsapp']);
                $validatedData['countrycode'] = $whatsapp_code;
            }

            $validatedData['added_by'] = Auth::id();

            $customer = Customer::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Customer saved successfully.',
                'customer_id' => $customer->id,
                'customer_name' => $customer->fname . ' ' . $customer->lname,
                'customer_gender' => $customer->gender,
                'have_manager' => $customer->have_manager,
            ], 200);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter valid customer details.',
                'errors' => $e->errors()
            ], 422);
        }
        catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Customer Store Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while saving the customer. Please try again later.'
            ], 500);
        }
    }

    public function managerstoreforbooking(Request $request)
    {

        try {
            $messages = [
                'manager_mobile.required' => 'Mobile number is required.',
                'manager_whatsapp.required' => 'Mobile number is required.',
                'manager_gender.required' => 'Select a gender.',
                'manager_mobile.unique' => 'This mobile number is already registered.',
                'manager_whatsapp.unique' => 'This WhatsApp number is already registered.',
                'manager_email.email' => 'Please provide a valid email address.',
                'manager_email.unique' => 'This email address is already registered.',
            ];


            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'manager_fname' => 'required|string|max:255',
                'manager_lname' => 'required|string|max:255',
                'manager_email' => 'nullable|email|max:255|unique:customers,email',
                'manager_gender' => 'required|in:Male,Female,Other',
                'manager_mobile' => [
                    'required', 'string', 'max:20', 'unique:customers,mobile',
                    function ($attribute, $value, $fail) {
                        if (!preg_match('/^\+\d{10,15}$/', $value)) {
                            $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                        }
                    },
                ],
                'manager_whatsapp' => [
                    'required', 'string', 'max:20', 'unique:customers,whatsapp',
                    function ($attribute, $value, $fail) {
                        if ($value && !preg_match('/^\+\d{10,15}$/', $value)) {
                            $fail('The ' . $attribute . ' field must be a valid international phone number in E.164 format.');
                        }
                    },
                ],
                'manager_locality' => 'nullable|string|max:500',
                'manager_pincode' => 'nullable|int',
                'manager_country_id' => 'nullable|int|exists:countries,id',
                'manager_state_id' => 'nullable|int|exists:states,id',
                'manager_city_id' => 'nullable|int|exists:cities,id',
            ], $messages);

            list($whatsapp_code, $whatsapp_number) = $this->splitPhoneNumber($validatedData['manager_whatsapp']);


            $managerData = [
                'fname' => $validatedData['manager_fname'],
                'lname' => $validatedData['manager_lname'],
                'countrycode' => $whatsapp_code,
                'mobile' => $validatedData['manager_mobile'],
                'whatsapp' => $validatedData['manager_whatsapp'],
                'email' => $validatedData['manager_email'],
                'locality' => $validatedData['manager_locality'],
                'pincode' => $validatedData['manager_pincode'],
                'country_id' => $validatedData['manager_country_id'],
                'state_id' => $validatedData['manager_state_id'],
                'city_id' => $validatedData['manager_city_id'],
                'have_manager' => 0,
                'have_company' => 0,
                'added_by' => Auth::id(),
            ];

            $customer = Customer::create($managerData);

            //Sync manager with customer
            $actualCustomer = Customer::find($request->customer_id);
            $manager = [$customer->id];
            $actualCustomer->managers()->syncwithoutDetaching($manager);

            return response()->json([
                'success' => true,
                'message' => 'Manager added successfully.',
                'manager_id' => $customer->id,
                'manager_name' => $customer->fname . ' ' . $customer->lname,
            ], 200);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => "Please enter valid manager information.",
                'errors' => $e->errors()
            ], 422);
        }
        catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Manager Store Error: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while saving the manager. Please try again later.'
            ], 500);
        }
    }

    public function searchCustomers(Request $request)
    {
        $query = $request->input('query');
        $customers = Customer::active()
            ->whereRaw('LOWER(fname) LIKE ?', ["%".strtolower($query)."%"])
            ->orWhereRaw('LOWER(lname) LIKE ?', ["%".strtolower($query)."%"])
            ->get();

        return response()->json(['customers' => $customers]);
    }

    public function searchManagersForBooking(Request $request)
    {
        $customerId = $request->input('customer_id');
        $query = $request->input('query');

        // Step 1: Get the manager IDs from the pivot table
        $managerIds = Customer::where('id', $customerId)
                                ->first()?->managers()
                                ->pluck('customers.id')
                                ->toArray(); // Convert to array

        // Initialise query
        $managersQuery = Customer::query();

        // Step 2: Apply manager IDs filter if they exist
        if ($managerIds && !empty($managerIds)) {
            $managersQuery->whereIn('id', $managerIds);
        }

        if ($query) {
            $managersQuery->orWhere(function ($q) use ($query) {
                // Ensure that the query string is properly wrapped with '%' for LIKE matching
                $q->whereRaw('LOWER(fname) LIKE ?', ["%" . strtolower($query) . "%"])
                  ->orWhereRaw('LOWER(lname) LIKE ?', ["%" . strtolower($query) . "%"]);
            });
        }

        $managers = $managersQuery
            ->whereNotNull('mobile')
            ->whereNotNull('whatsapp')
            ->where('is_deleted', 0)
            ->get();

        // Return the response
        return response()->json(['managers' => $managers]);
    }

    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();

        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();

        return response()->json($cities);
    }

    private function splitPhoneNumber($phone)
{
    $phoneUtil = PhoneNumberUtil::getInstance();

    try {
        // Parse the phone number (assuming it's in E.164 format with a + sign)
        $numberProto = $phoneUtil->parse($phone, null);

        // Extract country code and national number
        $countryCode = $numberProto->getCountryCode();
        $nationalNumber = $numberProto->getNationalNumber();

        return [$countryCode, $nationalNumber];
    } catch (\libphonenumber\NumberParseException $e) {
        \Log::error('Phone number parsing failed: ' . $e->getMessage());
        return [null, $phone];
    }

}

}
