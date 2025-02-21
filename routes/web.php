<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingRemarkController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerManagerController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\FollowupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IntensiveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceDetailController;
use App\Http\Controllers\SubDepartmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\SourcesController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PassengerCountController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;

Route::get('/send-whatsapp-message', [WhatsAppController::class, 'sendWhatsAppMessage']);

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login-store');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

//Handle registration form submission
Route::post('/register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/contact-admin', function () {
    return view('contact-admin');
})->name('contact-admin');

Route::middleware('auth')->group(function () {
    Route::get('intensive/{intensive}/edit', [IntensiveController::class, 'edit'])->name('intensive.edit');
    Route::put('intensive/{intensive}', [IntensiveController::class, 'update'])->name('intensive.update');

    Route::get('penalties/create', [PenaltyController::class, 'create'])->name('penalties.create');
    Route::post('penalties', [PenaltyController::class, 'store'])->name('penalties.store');
    Route::get('penalties/{penalties}/edit', [PenaltyController::class, 'edit'])->name('penalties.edit');
    Route::put('penalties/{penalties}', [PenaltyController::class, 'update'])->name('penalties.update');

    Route::get('notifications/{notifications}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::put('notifications/{notifications}', [NotificationController::class, 'update'])->name('notifications.update');

    Route::get('reminders/{reminders}/edit', [ReminderController::class, 'edit'])->name('reminders.edit');
    Route::put('reminders/{reminders}', [ReminderController::class, 'update'])->name('reminders.update');

    Route::get('reminders/create', [ReminderController::class, 'create'])->name('reminders.create');
    Route::post('reminders', [ReminderController::class, 'store'])->name('reminders.store');

    Route::get('followups/create', [FollowupController::class, 'create'])->name('followups.create');
    Route::post('followups', [FollowupController::class, 'store'])->name('followups.store');

    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');

    // =============employee management
    Route::resource('employees', EmployeeController::class)->middleware('can:admin-manager');
    Route::patch('/employees/{id}/update-password', [EmployeeController::class, 'updatePassword'])->name('employees.updatePassword');

    // =============
    Route::get('/api/notifications', [NotificationController::class, 'fetchNotifications'])->name('api.notifications');

    Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('api.notifications.read');

    Route::get('/api/reminders', [ReminderController::class, 'fetchReminders'])->name('api.reminders');

    Route::get('/customers/search', [CustomerController::class, 'searchCustomers'])->name('customers.search');
    Route::get('/companies/search', [CompanyController::class, 'searchCompanies'])->name('companies.search');
    Route::get('/managers/search', [CustomerController::class, 'searchManagersForBooking'])->name('managers.search');
    Route::get('/company/search', [CompanyController::class, 'searchCompany'])->name('company.search');
    Route::get('/get-states/{country}', [CustomerController::class, 'getStates'])->name('get-states');
    Route::get('/get-cities/{state}', [CustomerController::class, 'getCities'])->name('get-cities');

    Route::get('/get-suppliers/{serviceId}', [SupplierController::class, 'getSuppliers']);


});


    // =====================view operations
    Route::group(['middleware' => ['auth', 'permission:view',]], function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('index');
        Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile.show');
        Route::get('/user/manage', [UserController::class, 'index'])->name('user.index');
        Route::get('user/{id}/details', [UserController::class, 'show'])->name('user.show');
        Route::get('roles', [UserRoleController::class, 'index'])->name('roles.index')->middleware('can:admin-manager');
        Route::get('cards', [CardsController::class, 'index'])->name('cards.index')->middleware('can:admin-manager');
        Route::get('/department/manage', [DepartmentController::class, 'index'])->name('departments.index');
        Route::get('/subdepartment/manage', [SubDepartmentController::class, 'index'])->name('subdepartments.index');
        Route::get('/designation/manage', [DesignationController::class, 'index'])->name('designations.index');
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index')->middleware('can:admin-manager');
        Route::get('customers', [CustomerController::class, 'index'])->name('customers.index')->middleware('can:admin-manager');
        Route::get('customers/show/{customer}/data', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('customer-managers', [CustomerManagerController::class, 'index'])->name('customer-managers.index');
        Route::get('customer-managers/store/data', [CustomerManagerController::class, 'store'])->name('customer-managers.index');
        Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index')->middleware('can:admin-manager');
        Route::get('new_enquiries', [EnquiryController::class, 'new_index'])->name('new_enquiries.index');
        Route::get('enquiries/show/{id}', [EnquiryController::class, 'show_enquiry'])->name('show_enquiries.index');
        Route::get('accepted_enquiries', [EnquiryController::class, 'accepted_index'])->name('accepted_enquiries.index');
        Route::get('penalties', [PenaltyController::class, 'index'])->name('penalties.index');
        Route::get('bookings/index', [BookingController::class, 'index'])->name('bookings.index')->middleware('can:admin-manager');
        Route::get('bookings/operations', [BookingController::class, 'operations_index'])->name('bookings.operations_index');
        Route::get('bookings/pending', [BookingController::class, 'pending_index'])->name('bookings.pending_index');
        Route::get('bookings/approved', [BookingController::class, 'approved_index'])->name('bookings.approved_index');
        Route::get('bookings/show/{id}', [BookingController::class, 'show'])->name('bookings.show');
        Route::get('sources', [SourcesController::class, 'index'])->name('sources.index')->middleware('can:admin-manager');
        Route::get('references', [ReferenceController::class, 'index'])->name('references.index')->middleware('can:admin-manager');
        Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('can:admin-manager');
        Route::get('intensive', [IntensiveController::class, 'index'])->name('intensive.index');
        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('reminders', [ReminderController::class, 'index'])->name('reminders.index');
        Route::get('followups', [FollowupController::class, 'index'])->name('followups.index');
        Route::get('/booking-remarks/{id}', [BookingRemarkController::class, 'show']);
        Route::get('/booking-remarks/{bookingId}', [BookingRemarkController::class, 'index'])->name('booking-remarks.index');
        //Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');

        //Route::get('/enquiries/{id}', [FollowupController::class, 'show'])->name('enquiries.show');

    });

        // =====================add (create and store) operations
    Route::group(['middleware' => ['auth', 'permission:add',]], function () {
        Route::post('suppliers/store', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::post('sources', [SourcesController::class, 'store'])->name('sources.store');

        Route::get('intensive/create', [IntensiveController::class, 'create'])->name('intensive.create');
        Route::post('intensive', [IntensiveController::class, 'store'])->name('intensive.store');

        Route::get('roles/create', [UserRoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [UserRoleController::class, 'store'])->name('roles.store');
        //Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        //Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create')->middleware('can:admin-manager');
        Route::post('/department/store', [DepartmentController::class, 'store'])->name('department.store')->middleware('can:admin-manager');

        Route::get('/cards/create', [CardsController::class, 'create'])->name('cards.create');
        Route::post('/cards/store', [CardsController::class, 'store'])->name('cards.store');

        Route::post('references', [ReferenceController::class, 'store'])->name('references.store')->middleware('can:admin-manager');

        Route::get('/designation/create', [DesignationController::class, 'create'])->name('designation.create');
        Route::post('/designation/store', [DesignationController::class, 'store'])->name('designation.store');

        Route::get('/subdepartment/create', [SubdepartmentController::class, 'create'])->name('subdepartment.create');
        Route::post('/subdepartment/store', [SubdepartmentController::class, 'store'])->name('subdepartment.store');

        Route::get('/services/create', [ServiceController::class, 'create'])->name('services.create');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

        Route::get('/customers/form/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('customers', [CustomerController::class, 'store'])->name('customers.store');

        Route::get('/customers/{customer}/managers/create', [CustomerManagerController::class, 'create'])->name('customer-managers.create');
        Route::post('customer-managers', [CustomerManagerController::class, 'store'])->name('customer-managers.store');
        Route::post('customer-managers/booking', [CustomerController::class, 'managerstoreforbooking'])->name('customer-managers.storeforbooking');

        Route::get('enquiries/create', [EnquiryController::class, 'create'])->name('enquiries.create');
        Route::post('enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');

        Route::post('customers/storeforbooking', [CustomerController::class, 'storeforbooking'])->name('customers.storeforbooking');

        Route::post('/save-company', [CompanyController::class, 'store'])->name('company.store');
        Route::post('save-bookingcompany', [CompanyController::class, 'storeforbooking'])->name('company.storeforbooking');

        Route::get('bookings/create', [BookingController::class, 'create'])->name('bookings.create');
        Route::post('bookings/data/store', [BookingController::class, 'store'])->name('bookings.store');

    });


    // =====================edit, update operations
    Route::group(['middleware' => ['auth', 'permission:edit','permission:update']], function () {
        Route::get('roles/{userRole}/edit', [UserRoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{id}', [UserRoleController::class, 'update'])->name('roles.update');
        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}/update', [UserController::class, 'update'])->name('user.update');
        Route::put('/user/{user}/permissions', [UserController::class, 'updatePermissions'])->name('user.updatePermissions');
        Route::get('user/{id}/details', [UserController::class, 'show'])->name('user.show');
        Route::put('customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');

        Route::get('/department/{department}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::put('/department/{department}/update', [DepartmentController::class, 'update'])->name('department.update');

        Route::get('/cards/{card}/edit', [CardsController::class, 'edit'])->name('cards.edit');
        Route::put('/cards/{card}/update', [CardsController::class, 'update'])->name('cards.update');
        Route::get('/designation/{designation}/edit', [DesignationController::class, 'edit'])->name('designation.edit');
        Route::put('/designation/{designation}/update', [DesignationController::class, 'update'])->name('designation.update');

        Route::get('/subdepartment/{subdepartment}/edit', [SubdepartmentController::class, 'edit'])->name('subdepartment.edit');
        Route::put('/subdepartment/{subdepartment}/update', [SubdepartmentController::class, 'update'])->name('subdepartment.update');

        Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');

        Route::get('customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::get('customer-managers/{customerManager}/edit', [CustomerManagerController::class, 'edit'])->name('customer-managers.edit');
        Route::put('customer-managers/{customerManager}', [CustomerManagerController::class, 'update'])->name('customer-managers.update');

        Route::get('enquiries/{enquiry}/edit', [EnquiryController::class, 'edit'])->name('enquiries.edit');
        Route::patch('enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');
        Route::get('update_accepted/{enquiry}', [EnquiryController::class, 'edit_accepted'])->name('update_accepted');
        Route::get('followup/{enquiry}', [EnquiryController::class, 'edit_followups'])->name('followups');

        Route::get('bookings/{booking}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
        Route::put('bookings/{booking}/update', [BookingController::class, 'update'])->name('bookings.update');
        Route::post('bookings/update_service', [BookingController::class, 'update_service_delievered'])->name('bookings.updateservice');
        Route::post('bookings/accept/{id}', [BookingController::class, 'accept_acknowledge'])->name('bookings.accept');
        Route::post('/bookings/cancel/{id}', [BookingController::class, 'cancel'])->name('bookings.cancel');
        Route::post('/bookings/approve/{id}', [BookingController::class, 'approval'])->name('booking.approve');
        Route::get('followups/{followups}/edit', [FollowupController::class, 'edit'])->name('followups.edit');
        Route::put('followups/{followups}', [FollowupController::class, 'update'])->name('followups.update');
        Route::post('followups-update', [FollowupController::class, 'followups_update'])->name('followups.updatestatus');


        Route::get('/sources/edit/{id}', [SourcesController::class, 'edit'])->name('sources.edit');
        Route::post('/sources/update', [SourcesController::class, 'update'])->name('sources.update');

        Route::get('suppliers//edit/{id}', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::post('suppliers/update', [SupplierController::class, 'update'])->name('suppliers.update');

        Route::get('references/edit/{id}', [ReferenceController::class, 'edit'])->name('references.edit');
        Route::get('/edit_enquiry/{id}', [EnquiryController::class, 'show'])->name('new_enquiry.edit');
        Route::post('/accept_enquiry/{id}', [EnquiryController::class, 'accept_enquiry'])->name('new_enquiry.accept');
        Route::post('/transfer_enquiry/{id}', [EnquiryController::class, 'transfer_enquiry'])->name('transfer_enquiry');
        // Route::get('/update_enquiry_status/{id}', [EnquiryController::class, 'update_accept_enquiry'])->name('update_enquiry.status');
        Route::post('references/update', [ReferenceController::class, 'update'])->name('references.update');

        Route::get('/booking-remarks/{id}/edit', [BookingRemarkController::class, 'edit'])->name('booking-remarks.edit');
        Route::put('/booking-remarks/{id}', [BookingRemarkController::class, 'update']);
        Route::delete('/booking-remarks/{id}', [BookingRemarkController::class, 'destroy']);
        Route::post('/booking-remarks', [BookingRemarkController::class, 'store'])->name('booking-remarks.store');

        Route::resource('passenger-counts', PassengerCountController::class)->only(['store', 'update', 'destroy', 'edit']);
        Route::resource('service-details', ServiceDetailController::class);
        Route::patch('/company_update/{id}', [CompanyController::class, 'update'])->name('company.update');

        Route::get('e-reportsindex', [ReportsController::class, 'enquiry_index'])->name('enquiryreports.index')->middleware('can:admin-manager');
        Route::get('o-e-reportsindex', [ReportsController::class, 'operations_enquiry_index'])->name('operations_enquiryreports.index')->middleware('can:operations');
        Route::get('b-reportsindex', [ReportsController::class, 'booking_index'])->name('bookingreports.index')->middleware('can:admin-manager');
        Route::get('o-b-reportsindex', [ReportsController::class, 'operations_booking_index'])->name('operations_bookingreports.index')->middleware('can:operations');
        Route::post('/enquiryreport', [ReportsController::class, 'enquiry_reports'])->name('enquiryreport');
        Route::post('/operationsenquiryreport', [ReportsController::class, 'operations_enquiry_reports'])->name('operationsenquiryreport');
        Route::post('/bookingreport', [ReportsController::class, 'booking_reports'])->name('bookingreport');
        Route::post('/operationsbookingreport', [ReportsController::class, 'operations_booking_reports'])->name('operationsbookingreport');

    });

    // =====================delete operations
    Route::group(['middleware' => ['auth', 'permission:delete']], function () {

        Route::delete('/user-roles/{userRole}', [UserRoleController::class, 'destroy'])->name('roles.destroy');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::delete('/department/{department}', [DepartmentController::class, 'destroy'])->name('department.destroy');
        Route::delete('/cards/{card}', [CardsController::class, 'destroy'])->name('cards.destroy');
        Route::delete('/designation/{designation}', [DesignationController::class, 'destroy'])->name('designation.destroy');
        Route::delete('/subdepartment/{subdepartment}', [SubdepartmentController::class, 'destroy'])->name('subdepartment.destroy');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::delete('customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
        Route::delete('customer-managers/{customerId}/{managerId}', [CustomerManagerController::class, 'destroy'])->name('customer-managers.destroy');
        Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
        Route::delete('delete-bookings/{booking}', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::delete('intensive/{intensive}', [IntensiveController::class, 'destroy'])->name('intensive.destroy');
        Route::delete('penalties/{penalties}', [PenaltyController::class, 'destroy'])->name('penalties.destroy');
        Route::delete('notifications/{notifications}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('reminders/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
        Route::delete('followups/{followups}', [FollowupController::class, 'destroy'])->name('followups.destroy');
        Route::delete('sources/{source}', [SourcesController::class, 'destroy'])->name('sources.destroy');
        Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
        Route::delete('references/{reference}', [ReferenceController::class, 'destroy'])->name('references.destroy');
        Route::delete('company/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');


    });
