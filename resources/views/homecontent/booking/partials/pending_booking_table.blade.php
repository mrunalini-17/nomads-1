@forelse ($bookings as $booking)
    <tr>
        <td>{{ $booking->unique_code }}</td>
        <td>{{ $booking->customer->fname ?? 'N/A' }} {{ $booking->customer->lname ?? 'N/A' }}</td>
        <td>{{ $booking->service->name ?? 'N/A' }}</td>
        <td>{{ $booking->status ?? 'N/A' }}</td>
        {{-- <td class="{{ $booking->is_approved ? 'text-success' : '' }}">{{ $booking->is_approved ? 'Yes' : 'No' }}</td> --}}
        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d-m-Y') }}</td>
        <td>{{ $booking->addedBy->first_name ?? '--' }} {{ $booking->addedBy->last_name ?? '--' }}</td>
        <td>{{ $booking->acceptedBy->first_name ?? '--' }} {{ $booking->acceptedBy->last_name ?? '--' }}</td>
        <td>{{ $booking->updatedBy->first_name ?? '--' }} {{ $booking->updatedBy->last_name ?? '--' }}</td>
        <td>
            <!-- Actions dropdown -->
            <div class="dropdown">
                <button class="text-info border-0 bg-transparent dropdown-toggle" type="button"
                    id="dropdownMenuButton{{ $booking->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $booking->id }}">
                    <li><a class="dropdown-item text-success" href="{{ route('bookings.show', $booking->id) }}">
                        <i class="fa-solid fa-eye"></i> View
                    </a></li>

                        <li><a class="dropdown-item text-primary" href="{{ route('bookings.edit', $booking->id) }}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a></li>
                        @if ($booking->is_approved != 1)
                        <li>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item text-danger" onclick="return confirm('Are you sure?');">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="10" class="text-center">No bookings available</td>
    </tr>
@endforelse
