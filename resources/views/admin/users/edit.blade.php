<x-portal::input type="text" name="email" label="Account" placeholder="Account" horizontal disabled>
    {{ $row->email }}
</x-portal::input>
<x-portal::input type="text" name="workforce" label="Workforce" placeholder="Workforce" horizontal disabled>
    {{ $row->workforce }}
</x-portal::input>
<x-portal::input type="text" name="identify_provider" label="Identify Provider" placeholder="Identify Provider"
    horizontal disabled>
    {{ $row->identify_provider }}
</x-portal::input>
<x-portal::input type="text" name="pts_id" label="Pts Id" placeholder="Pts Id" horizontal disabled>
    {{ $row->pts_id }}
</x-portal::input>
<x-portal::input type="datetime-local" name="last_login" label="Last Login" placeholder="Last Login" horizontal>
    {{ $row->last_login }}
</x-portal::input>
<x-portal::input.select name="status" label="Status" placeholder="Status" horizontal>
    <option value="">Select Status</option>
    <option {{$row->status->value==='active' ? 'selected' : ''}} value="active">Active</option>
    <option {{$row->status->value==='in_active' ? 'selected' : ''}} value="in_active">Inactive</option>
</x-portal::input.select>
<x-portal::input.select.asset />
