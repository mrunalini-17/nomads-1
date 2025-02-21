<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\Designation;
use App\Models\UserEmployee;
use App\Models\Permission;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = UserEmployee::active()->with('departments', 'subDepartment', 'designation', 'userRole')->orderBy('id', 'desc')->get();
        return view('homecontent.employee.index', compact('employees'));
    }

    public function updatePassword(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            // Find the employee
            $employee = UserEmployee::findOrFail($id);

            // Update password
            $employee->password = Hash::make($request->password);
            $employee->save();

            // Redirect with success message
            return back()->with('success', 'Password updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle model not found exception
            return back()->withErrors(['error' => 'Employee not found.']);
        } catch (\Exception $e) {
            // Handle any other exceptions and log the error message
            \Log::error('Password update failed: ' . $e->getMessage());
            // Show the exact error message to the user
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        $departments = Department::active()->get();
        $subDepartments = SubDepartment::active()->get();
        $designations = Designation::active()->get();
        $userRoles = UserRole::active()->get();
        return view('homecontent.employee.create', compact('departments', 'subDepartments', 'designations', 'userRoles'));
    }

    public function show(UserEmployee $employee)
    {
        return view('homecontent.employee.show', compact('employee'));
    }

    public function profile()
    {
        // Get the currently logged-in employee
        $employee = Auth::user(); // This assumes that `Auth::user()` returns an instance of `UserEmployee`

        return view('homecontent.employee.profile', compact('employee'));
    }


    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|string|max:15|unique:employees,mobile',
                'whatsapp' => 'required|string|max:15|unique:employees,whatsapp',
                'email' => 'nullable|string|email|max:255',
                'password' => 'nullable|string|min:6',
                'departments' => 'required|array',
                'departments.*' => 'integer|exists:departments,id',
                'designation_id' => 'required|integer',
                'user_role_id' => 'required|integer',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'miscellaneous' => 'nullable|string',
                'permissions' => 'array',
                'permissions.*' => 'in:add,view,edit,update,delete',
             ]);

             if ($validator->fails()) {
                 return redirect()->back()->withInput()->withErrors($validator);
             }

            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|string|max:15|unique:employees,mobile',
                'whatsapp' => 'required|string|max:15|unique:employees,whatsapp',
                'email' => 'nullable|string|email|max:255',
                'password' => 'nullable|string|min:6',
                'departments' => 'required|array',
                'departments.*' => 'integer|exists:departments,id',
                'designation_id' => 'required|integer',
                'user_role_id' => 'required|integer',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'miscellaneous' => 'nullable|string',
                'permissions' => 'array',
                'permissions.*' => 'in:add,view,edit,update,delete',
            ]);

            // Store profile image if uploaded
            if ($request->hasFile('profile_image')) {
                $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->move(public_path('images'), $imageName);
                $validatedData['profile_image'] = 'images/' . $imageName;
            }

            // Hash the password before saving
            if ($request->filled('password')) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            }


            // Create a new employee
            $employee = UserEmployee::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'countrycode' => '91',
                'mobile' => $validatedData['mobile'],
                'whatsapp' => $validatedData['whatsapp'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'] ?? null,
                'designation_id' => $validatedData['designation_id'],
                'user_role_id' => $validatedData['user_role_id'],
                'profile_image' => $validatedData['profile_image'] ?? null,
                'is_active' => true,
                'miscellaneous' => $validatedData['miscellaneous'],
                'added_by' => auth()->user()->id,
            ]);

            // Attach selected departments to the employee
            $employee->departments()->sync($validatedData['departments']);

            // Save permissions
        if (isset($validatedData['permissions'])) {
            $permissions = [
                'employee_id' => $employee->id,
                'add' => in_array('add', $validatedData['permissions']),
                'view' => in_array('view', $validatedData['permissions']),
                'edit' => in_array('edit', $validatedData['permissions']),
                'update' => in_array('update', $validatedData['permissions']),
                'delete' => in_array('delete', $validatedData['permissions']),
            ];
            Permission::create($permissions);
        }


        // Send email to the new employee with login details
        // if ($employee->email) {
        //     Mail::to($employee->email)->send(new NewEmployeeLoginDetailsMail($employee, $request->password));
        // }

        // Send email to admin and managers about the new employee
        // $adminManagers = UserEmployee::whereIn('user_role_id', [1, 2]) // Assuming role_id 1 = Admin, 2 = Manager
        //     ->pluck('email')
        //     ->filter()
        //     ->toArray();

        // if (!empty($adminManagers)) {
        //     Mail::to($adminManagers)->send(new NewEmployeeNotificationMail($employee));
        // }

            // Redirect with success message
            return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation exceptions
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle any other exceptions
            return redirect()->back()->with('error', 'An error occurred while creating the employee. Please try again.')->withInput();
        }
    }

    public function edit(UserEmployee $employee)
    {
        // Retrieve necessary data
        $departments = Department::active()->get();
        $subDepartments = SubDepartment::active()->get();
        $designations = Designation::active()->get();
        $userRoles = UserRole::active()->get();

        $permissions = $employee->permission()->first();

        return view('homecontent.employee.edit', compact('employee', 'departments', 'subDepartments', 'designations', 'userRoles', 'permissions'));
    }


    public function update(Request $request, $id)
    {
        // Find the employee by ID
        $employee = UserEmployee::findOrFail($id);
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'mobile' => 'required|string|max:15|unique:customers,mobile,' . $employee->id . ',id,is_deleted,0',
                'whatsapp' => 'required|string|max:15|unique:customers,whatsapp,' . $employee->id . ',id,is_deleted,0',
                'email' => 'nullable|email|max:255',
                'password' => 'nullable|string|min:6',
                'departments' => 'required|array',
                'departments.*' => 'integer|exists:departments,id',
                'designation_id' => 'required|integer',
                'user_role_id' => 'required|integer',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'miscellaneous' => 'nullable|string',
                'permissions' => 'array',
                'permissions.*' => 'in:add,view,edit,update,delete',
                'is_active' => 'nullable|boolean',
            ]);

            // Store new profile image if uploaded
            if ($request->hasFile('profile_image')) {
                // Delete the old image if exists
                if ($employee->profile_image && file_exists(public_path($employee->profile_image))) {
                    unlink(public_path($employee->profile_image));
                }

                // Store the new image
                $imageName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
                $request->file('profile_image')->move(public_path('images'), $imageName);
                $validatedData['profile_image'] = 'images/' . $imageName;
            } else {
                // If no new image is uploaded, retain the old image
                $validatedData['profile_image'] = $employee->profile_image;
            }

            // Hash the password if it's being updated
            if ($request->filled('password')) {
                $validatedData['password'] = bcrypt($validatedData['password']);
            } else {
                // Keep the existing password if not provided
                $validatedData['password'] = $employee->password;
            }

            // Update the employee with the validated data
            $employee->update([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'mobile' => $validatedData['mobile'],
                'whatsapp' => $validatedData['whatsapp'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'designation_id' => $validatedData['designation_id'],
                'user_role_id' => $validatedData['user_role_id'],
                'profile_image' => $validatedData['profile_image'],
                'miscellaneous' => $validatedData['miscellaneous'],
                'is_active' => $validatedData['is_active'],
                'updated_by' => auth()->user()->id,
            ]);

            // Sync the departments
            $employee->departments()->sync($validatedData['departments']);

             // Update permissions
        if ($employee->permission) {
            $permissions = [
                'add' => in_array('add', $validatedData['permissions']),
                'view' => in_array('view', $validatedData['permissions']),
                'edit' => in_array('edit', $validatedData['permissions']),
                'update' => in_array('update', $validatedData['permissions']),
                'delete' => in_array('delete', $validatedData['permissions']),
            ];

            $employee->permission()->update($permissions);
        } else {
            // If no permissions exist for the employee, create a new record
            $employee->permission()->create([
                'employee_id' => $employee->id,
                'add' => in_array('add', $validatedData['permissions']),
                'view' => in_array('view', $validatedData['permissions']),
                'edit' => in_array('edit', $validatedData['permissions']),
                'update' => in_array('update', $validatedData['permissions']),
                'delete' => in_array('delete', $validatedData['permissions']),
            ]);
        }


            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Handle any other exceptions
            return redirect()->back()->with('error', 'An error occurred while updating the employee. Please try again.'. $e->getMessage())->withInput();
        }
    }


    public function destroy(UserEmployee $employee)
    {
        $employee->softDelete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
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
            return [null, $phone]; // Return original number if parsing fails
        }
    }

}
