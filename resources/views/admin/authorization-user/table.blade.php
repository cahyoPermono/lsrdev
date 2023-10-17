@foreach ($data as $row)
    <tr>
        @itcan('delete admin.authorization-user')
            <td>
                <div class="form-checkbox">
                    <input type="checkbox" class="table-checkbox" value="{{ $row->email }}" name="selected_ids[]">
                </div>
            </td>
        @enditcan
        <td>{{ $row->email }}</td>
        <td>
            @foreach ($row->modules as $row)
                <span class="badge bg-primary" style="margin: 0;font-size: 13px;font-weight: normal">{{ $row->name }}</span>
            @endforeach
        </td>
        <td class="text-end">
            @if (itcan('edit admin.authorization-user') || itcan('delete admin.authorization-user'))
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle btn-action"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-action">
                        @itcan('edit admin.authorization-user')
                            <li>
                                <a href="{{ adminRoute('admin.authorization-user.edit', $row->email) }}"
                                    class="dropdown-item">Edit</a>
                            </li>
                        @enditcan
                        @itcan('delete admin.authorization-user')
                            <li>
                                <a href="javascript:;" data-toggle="confirmation"
                                    data-message="{{ __('adminportal.delete_confirmation') }}"
                                    data-action="{{ adminRoute('admin.authorization-user.destroy', $row->email) }}"
                                    data-method="DELETE" class="dropdown-item">Delete</a>
                            </li>
                        @enditcan
                    </ul>
                </div>
            @endif
        </td>
    </tr>
@endforeach
