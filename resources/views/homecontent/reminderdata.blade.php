<li class="nav-item dropdown no-arrow mx-1">
    <a class="nav-link dropdown-toggle" href="#" id="reminderDropdownToggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-envelope fa-fw"></i>
        <!-- Counter - Reminders -->
        <span id="reminderCount" class="badge badge-danger badge-counter"></span>
    </a>
    <!-- Dropdown - Reminders -->
    <div id="reminderDropdown" class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="reminderDropdownToggle" style="width: 350px;">
        <h6 class="dropdown-header bg-primary text-white">
            Unread Messages
        </h6>
        <!-- Reminders will be inserted here -->
        <div class="list-group list-group-flush overflow-auto" style="max-height: 300px;">
            <!-- Dynamic content will be injected here -->
        </div>
        <a class="dropdown-item text-center small text-gray-500 dropdown-footer" href="#">Show All Messages</a>
    </div>
</li>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to fetch reminders
        function fetchReminders() {
            $.ajax({
                url: '{{ route('api.reminders') }}',
                method: 'GET',
                success: function(data) {
                    var reminderCount = data.length;
                    $('#reminderCount').text(reminderCount);

                    // Clear existing reminders
                    $('#reminderDropdown').find('.list-group').empty();

                    // Append new reminders
                    data.forEach(function(reminder) {
                        var reminderItem = `
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-start reminder-item" data-id="${reminder.id}" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <div class="me-2">
                                    <input type="checkbox" class="form-check-input border border-2 border-secondary mark-as-read" data-id="${reminder.id}">
                                </div>
                                <div class="me-2">
                                    <i class="bi bi-chat-dots text-primary"></i>
                                </div>
                                <div class="flex-grow-1" style="min-width: 0;">
                                    <div class="d-flex justify-content-between">
                                        <div style="flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <span class="font-weight-bold">${reminder.message}</span>
                                        </div>
                                        <div class="small text-gray-500 text-right">${moment(reminder.created_at).fromNow()}</div>
                                    </div>
                                </div>
                            </a>
                        `;
                        $('#reminderDropdown').find('.dropdown-footer').before(reminderItem);
                    });
                }
            });
        }

        // Function to mark reminder as read
        function markAsRead(reminderId) {
            $.ajax({
                url: '{{ url('/api/reminders') }}/' + reminderId + '/read',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Remove the reminder from the dropdown
                        $(`.reminder-item[data-id="${reminderId}"]`).remove();
                    }
                }
            });
        }

        // Fetch reminders on page load
        //fetchReminders();

        // Optionally, fetch reminders periodically
        //setInterval(fetchReminders, 60000); // Refresh every 60 seconds

        // Handle change event on checkboxes
        $('#reminderDropdown').on('change', '.mark-as-read', function() {
            var reminderId = $(this).data('id');
            if (this.checked) {
                markAsRead(reminderId);
            }
        });
    });
</script>
