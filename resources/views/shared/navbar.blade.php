<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3 text-secondary">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span id="notificationCount" class="badge badge-danger badge-counter"></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div id="notificationDropdown"
                class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown" style="width: 350px;">
                <h6 class="dropdown-header bg-primary text-white">
                    Today's Notifications
                </h6>
                <!-- Notifications will be inserted here -->
                <div id="notificationDetails" class="list-group list-group-flush overflow-auto"
                    style="max-height: 300px;">
                    <!-- Dynamic content will be injected here -->
                </div>
                <a class="dropdown-item text-center btn btn-sm btn-secondary text-gray-500"
                    href="{{ route('notifications.index') }}">Show All</a>
            </div>
        </li>
        @include('homecontent.reminderdata')
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <!-- Display User Details -->
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                   Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                </span>

                <!-- Display Profile Image -->
                <img class="img-profile rounded-circle"
                    src="{{ Auth::user()->profile_image ? asset(Auth::user()->profile_image) : asset('assets/img/undraw_profile.svg') }}"
                    alt="Profile Image">

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile.show') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                </span>
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item" type="submit">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
@include('shared.success-message')
@include('shared.error-message')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        // Function to fetch notifications
        function fetchNotifications() {
            $.ajax({
                url: '{{ route('api.notifications') }}',
                method: 'GET',
                success: function(data) {
                    // console.log(data);
                    var notificationCount = data.length;
                    $('#notificationCount').text(notificationCount);

                    $('#notificationDetails').empty();

                    // Append new notifications
                    data.forEach(function(notification) {
                        // var iconClass = notification.type === 'enquiry' ?
                        //     'fas fa-info-circle text-info' :
                        //     'fas fa-exclamation-circle text-warning';  // Warning icon for others
                        var iconClass = 'fas fa-info-circle text-info';
                        var hrefroute = '#'; // Default href

                    if (notification.type === 'enquiry') {
                        hrefroute = '{{ route('enquiries.index') }}';
                    } else if (notification.type === 'booking') {
                        hrefroute = '{{ route('bookings.show', ':id') }}';
                        hrefroute = hrefroute.replace(':id', notification.type_id);
                    } else if (notification.type === 'booking_cancellation') {
                        hrefroute = '{{ url("booking_cancellations") }}/' + notification.type_id;
                    }

                        var notificationItem = `
                            <div href="#" class="list-group-item list-group-item-action d-flex align-items-center notification-item" data-id="${notification.id}">

                                <div class="flex-grow-1 mt-4">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="${iconClass}"></i>
                                            <a href="${hrefroute}" class="font-weight-bold">${notification.message}</a>
                                        </div>

                                    </div>
                                    <div class="small text-gray-500">${moment(notification.created_at).fromNow()}</div>
                                </div>


                                 <div class="ml-4">
                                    <input type="checkbox" class="form-check-input border border-2 border-secondary mark-as-read" data-id="${notification.id}">
                                </div>
                            </div>
                        `;
                        $('#notificationDetails').append(notificationItem);
                    });
                }
            });
        }

        // Function to mark notification as read
        function markAsRead(notificationId) {
            $.ajax({
                url: '{{ url('/api/notifications') }}/' + notificationId + '/read',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        // Optionally, you can remove the notification or update the UI
                        $(`.notification-item[data-id="${notificationId}"]`).remove();
                    }
                }
            });
        }

        // Fetch notifications on page load
        fetchNotifications();

        setInterval(fetchNotifications, 60000); // Refresh every 60 seconds

        $('#notificationDropdown').on('change', '.mark-as-read', function() {
            var notificationId = $(this).data('id');
            if (this.checked) {
                markAsRead(notificationId);
            }
        });
    });
</script>
