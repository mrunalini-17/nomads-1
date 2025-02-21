<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Designation;
use App\Models\SubDepartment;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Booking;
use App\Models\UserEmployee;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = UserEmployee::active()->orderByDesc('created_at')->get();
        return view('homecontent.user.index', compact('users'));
    }

    public function dashboard()
    {
        $user = UserEmployee::find(Auth::id());
        $today = Carbon::today()->toDateString();
        $tomorrow = Carbon::tomorrow()->toDateString();
        $dayAfterTomorrow = Carbon::tomorrow()->addDay()->toDateString();

        $data['bookings'] = Booking::active()->count();
        $data['employees'] = UserEmployee::where('is_active', 1)->count();
        $data['enquiries'] = Enquiry::active()->count();
        $data['customers'] = Customer::active()->count();

        // Helper function to filter bookings by travel date
        $getBookingsForDate = function ($date) use ($user) {
            $query = Booking::active()
                ->whereHas('bookingServices', function ($query) use ($date) {
                    $query->where('travel_date1', $date)
                          ->orWhere('travel_date2', $date);
                })
                ->where('is_cancelled', false);

            if ($user->isOperations()) {
                $query->where('added_by', $user->id);
            }

            return $query->with([
                'bookingServices' => function ($query) use ($date) {
                    $query->where('travel_date1', $date)
                          ->orWhere('travel_date2', $date);
                },
                'bookingServices.bookingConfirmations' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ])->get();
        };

        // Get filtered bookings for each date
        $data['todaysBookings'] = $getBookingsForDate($today);
        $data['tomorrowsBookings'] = $getBookingsForDate($tomorrow);
        $data['dayAfterTomorrowsBookings'] = $getBookingsForDate($dayAfterTomorrow);

        return view('index', $data);
    }


    public function show($id)
    {
        $user = UserEmployee::findOrFail($id);
        return view('homecontent.user.show', compact('user'));
    }

    public function create()
    {
        $departments = Department::active()->get();
        $sub_departments = SubDepartment::active()->get();
        $designations = Designation::active()->get();
        $user_roles = UserRole::active()->get();

        return view('homecontent.user.create', compact('departments', 'sub_departments', 'designations', 'user_roles'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'mobile' => 'required|string|max:15',
                'whatsapp' => 'nullable|string|max:15',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'sub_department_id' => 'nullable|integer|exists:sub_departments,id',
                'designation_id' => 'nullable|integer|exists:designations,id',
                'user_role_id' => 'nullable|integer|exists:user_roles,id',
                'permissions' => 'nullable|array',
                'permissions.*' => 'string',
                'miscellaneous' => 'nullable|string',
                'departments' => 'required|array',
                'departments.*' => 'integer|exists:departments,id',
            ]);

            // Create the user
            $user = UserEmployee::create([
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'mobile' => $validatedData['mobile'],
                'whatsapp' => $validatedData['whatsapp'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'sub_department_id' => $validatedData['sub_department_id'],
                'designation_id' => $validatedData['designation_id'],
                'user_role_id' => $validatedData['user_role_id'],
                'permissions' => json_encode($validatedData['permissions']),
                'miscellaneous' => $validatedData['miscellaneous'],
            ]);

            // Attach departments to the user
            $user->departments()->sync($validatedData['departments']);

            // Redirect with a success message
            return redirect()->route('user.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        $sub_departments = SubDepartment::all();
        $designations = Designation::all();
        $user_roles = UserRole::all();

        return view('homecontent.user.edit', compact('departments', 'sub_departments', 'designations', 'user_roles', 'user'));
    }

    public function update(Request $request, UserEmployee $user)
    {
        // Validate and update the user
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'department_id' => 'nullable|exists:departments,id',
            'sub_department_id' => 'nullable|exists:sub_departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'user_role_id' => 'nullable|exists:user_roles,id',
            // 'permissions' => 'nullable|array',
            // 'permissions.*' => 'string',
            'miscellaneous' => 'nullable|string',
        ]);

        // if ($request->filled('password')) {
        //     $data['password'] = bcrypt($data['password']);
        // } else {
        //     unset($data['password']);
        // }

        // $data['permissions'] = json_encode($data['permissions']);

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Updated sucessfully');
    }

    public function destroy(UserEmployee $user)
    {
        $user->softDelete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
