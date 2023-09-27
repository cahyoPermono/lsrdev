@foreach ($data as $row)
<tr>
    @itcan('delete admin.users')
    <td>
        <div class="form-checkbox">
            <input type="checkbox" class="table-checkbox" value="{{$row->uuid}}" name="selected_ids[]">
        </div>
    </td>
    @enditcan
    <td>{{$row->workforce}}</td>
    <td>{{$row->email}}</td>
    <td>{{$row->identify_provider}}</td>
    <td>{{$row->pts_id}}</td>
    <td>{{$row->last_login}}</td>
    @if ($row->last_login)
        @php
            $lastLoginDate = \Carbon\Carbon::parse($row->last_login);
            $currentDate = \Carbon\Carbon::now();
            $daysSinceLogin = $currentDate->diffInDays($lastLoginDate);
        @endphp

        <td>{{ $daysSinceLogin > 90 ? "> 90 days" : $daysSinceLogin . " days" }}</td>
    @else
        <td>N/A</td>
    @endif

    <td>
        @php
            $minActiveDaySetting = \App\Models\Settings::where('key', 'min_active_day')->value('value');
            $status = $daysSinceLogin > $minActiveDaySetting ? 'Inactive' : 'Active';
        @endphp
        {{$status}}
    </td>

    
    <td class="text-end">
        @if(itcan('edit admin.users') || itcan('delete admin.users'))
        <div class="btn-group">
            <button type="button" class="btn btn-secondary dropdown-toggle btn-action" data-bs-toggle="dropdown" aria-expanded="false">
                Action
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-action">
                @itcan('edit admin.users')
                <li>
                    <a href="{{adminRoute('admin.users.edit',$row->uuid)}}" class="dropdown-item">Edit</a>
                </li>
                @enditcan
            </ul>
        </div>
        @endif
    </td>
    
</tr>
@endforeach