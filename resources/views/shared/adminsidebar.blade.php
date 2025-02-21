<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion bg-gradient-primary" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('index') }}">
        <div class="sidebar-brand-text mx-3"><small></small><img src="{{asset('assets/img/nomadlogo.png')}}" width="100"> </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link " href="{{ route('index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Nav Item - Employee Management (Admin and Manager) -->
    @canany(['admin'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#employeeManagement" aria-expanded="true" aria-controls="employeeManagement">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Employee Management</span>
        </a>
        <div id="employeeManagement" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('employees.index') }}">Employee</a>
            </div>
        </div>
    </li>
    @endcanany

    <!-- Nav Item - Customer Management (Admin, Manager, and Operations) -->
    @canany(['admin'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customerManagement" aria-expanded="true" aria-controls="customerManagement">
            <i class="fas fa-fw fa-users"></i>
            <span>Customer Management</span>
        </a>
        <div id="customerManagement" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('customers.index') }}">Customer</a>
            </div>
        </div>
    </li>
    @endcanany


        <!-- Nav Item - Enquiry Management (Admin and Manager) -->
        @canany(['admin','manager','operations'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#enquiryManagement" aria-expanded="true" aria-controls="enquiryManagement">
                <i class="fas fa-question-circle"></i>
                <span>Enquiry Management</span>
            </a>
            <div id="enquiryManagement" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @canany(['admin','manager'])
                        <a class="collapse-item" href="{{ route('enquiries.index') }}">All Enquiries</a>
                    @endcanany

                        <a class="collapse-item" href="{{ route('new_enquiries.index') }}">New Enquiries</a>
                        <a class="collapse-item" href="{{ route('accepted_enquiries.index') }}">Accepted Enquiries</a>
                        <a class="collapse-item" href="{{ route('followups.index') }}">Followups</a>
                        <a class="collapse-item" href="{{ route('enquiries.create') }}">Create Enquiry</a>
                </div>
            </div>
        </li>
        @endcanany

    <!-- Nav Item - Booking Management (All roles) -->
    @canany(['admin','manager', 'accounts', 'operations'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bookingManagement" aria-expanded="true" aria-controls="bookingManagement">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Booking Management</span>
        </a>
        <div id="bookingManagement" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @canany(['admin','manager'])
                    <a class="collapse-item" href="{{ route('bookings.index') }}">Bookings</a>
                    {{-- <a class="collapse-item" href="{{ route('intensive.index') }}">Incentive</a>
                    <a class="collapse-item" href="{{ route('penalties.index') }}">Penalty</a> --}}
                    <a class="collapse-item" href="{{ route('bookings.create') }}">Create Booking</a>
                @endcanany
                @can('operations')
                    <a class="collapse-item" href="{{ route('bookings.operations_index') }}">Bookings</a>
                    <a class="collapse-item" href="{{ route('bookings.create') }}">Create Booking</a>
                @endcan
                @can('accounts')
                    <a class="collapse-item" href="{{ route('bookings.pending_index') }}">Pending Bookings</a>
                    <a class="collapse-item" href="{{ route('bookings.approved_index') }}">Approved Bookings</a>
                @endcan


            </div>
        </div>
    </li>
    @endcanany

    <!-- Nav Item - Master (Admin only) -->
    @canany(['admin'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Master</span>
        </a>
        <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('cards.index') }}">Cards</a>
                <a class="collapse-item" href="{{ route('departments.index') }}">Department</a>
                <a class="collapse-item" href="{{ route('designations.index') }}">Designation</a>
                <a class="collapse-item" href="{{ route('subdepartments.index') }}">Sub Department</a>
                <a class="collapse-item" href="{{ route('references.index') }}">References</a>
                <a class="collapse-item" href="{{ route('roles.index') }}">Role</a>
                <a class="collapse-item" href="{{ route('services.index') }}">Services</a>
                <a class="collapse-item" href="{{ route('suppliers.index') }}">Suppliers</a>
                <a class="collapse-item" href="{{ route('sources.index') }}">Sources</a>
            </div>
        </div>
    </li>
    @endcan

    <!-- Nav Item - Notifications and Reminders (Admin only) -->
    @canany(['admin'])
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-bell"></i>
            <span>Notification & Reminder</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('notifications.index') }}">Notification</a>
                <a class="collapse-item" href="{{ route('reminders.index') }}">Reminder</a>

            </div>
        </div>
    </li>
    @endcan


    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
            <i class="fas fa-fw fa-table"></i>
            <span>Reports</span>
        </a>
        <div id="collapseReports" class="collapse" aria-labelledby="headingReports" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @canany(['admin','manager'])
                <a class="collapse-item" href="{{ route('enquiryreports.index') }}">Enquiry Reports</a>
                <a class="collapse-item" href="{{ route('bookingreports.index') }}">Booking Reports</a>
                @endcan
                @can('operations')
                <a class="collapse-item" href="{{ route('operations_enquiryreports.index') }}">Enquiry Reports</a>
                <a class="collapse-item" href="{{ route('operations_bookingreports.index') }}">Booking Reports</a>
                @endcan
            </div>
        </div>
    </li>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
