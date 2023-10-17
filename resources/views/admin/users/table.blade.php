@foreach ($data as $row)
    <tr>
        <td>{{ $row->workforce }}</td>
        <td>{{ $row->email }}</td>
        <td>{{ $row->identify_provider }}</td>
        <td>{{ $row->pts_id }}</td>
        <td>{{ $row->last_login }}</td>
        @if ($row->last_login)
            @php
                $daysSinceLogin = diffDays($row->last_login);
            @endphp
            <td>{{ $daysSinceLogin > 90 ? '> 90 days' : $daysSinceLogin . ' days' }}</td>
        @else
            <td>N/A</td>
        @endif
        <td>
            @if ($row->status->value === 'active')
                <span class="badge bg-success" style="font-weight: normal;font-size: 12px">Active</span>
            @else
                <span class="badge bg-danger" style="font-weight: normal;font-size: 12px">Inactive</span>
            @endif
        </td>

        <td class="text-end">
            @if (itcan('edit admin.users'))
                <div class="btn-group">
                    <a href="{{ adminRoute('admin.users.edit', $row->uuid) }}" class="btn btn-secondary btn-action">
                        Edit
                    </a>
                </div>
            @endif
        </td>

    </tr>
@endforeach
