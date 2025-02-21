@foreach ($customers as $customer)
    @php
        $address = implode(', ', array_filter([
            $customer->locality,
            optional($customer->city)->name,
            optional($customer->state)->name,
            optional($customer->country)->name,
            $customer->pincode,
        ]));
    @endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $customer->fname }} {{$customer->lname}}</td>
        <td>{{ $customer->mobile }}</td>
        <td>{{ $customer->whatsapp }}</td>
        <td>{{ $customer->email }}</td>
        <td>{{ $address }}</td>
        <td>{{ $customer->reference->name ?? 'N.A.' }}</td>
        <td>{{ $customer->have_manager ? 'Yes' : 'No' }}</td>
        <td>
            <div class="text-center">
                <div class="dropdown">
                    <button class="text-info border-0 bg-transparent dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item text-success" href="{{ route('customers.show', $customer->id) }}">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-primary" href="{{ route('customers.edit', $customer->id) }}">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="dropdown-item text-danger" onclick="return confirm('Are you sure?');">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </td>
    </tr>
@endforeach
