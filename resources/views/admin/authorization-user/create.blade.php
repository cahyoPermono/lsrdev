<x-portal::input type="text" name="email" label="Email" placeholder="Email" horizontal>{{old('email')}}</x-portal::input>
<div class="form-group row" style="align-items: baseline;">
    <label for="" class="label col-sm-2">
        Permissions
        <span class="required">*</span>
    </label>
    <div class="col-sm-6">
        <div class="d-flex mb-3">
            <button type="button" class="btn btn-light btn-select-all btn-sm me-3">SELECT ALL</button>
            <button type="button" class="btn btn-light btn-unselect btn-sm">UNSELECT ALL</button>
        </div>
        <div class="row" id="list-module-permission">
                <ul class="list-permission list-group">
            @foreach ($appModules as $module)
                    <li class="list-group-item p-0 ps-3">
                        <div class="custom-checkbox">
                            <x-portal::input.checkbox.option
                                required="false"
                                name="permissions[{{ $module->id }}]"
                                value="{{ $module->id }}"
                                label="{{ $module->name }}"
                            ></x-portal::input.checkbox.option>
                        </div>
                    </li>
                    @if (count($module->sub))
                    <ul class="list-group">
                        @foreach ($module->sub as $sub)
                            <li class="list-group-item p-0 ps-3" style="margin-left: 24px;">
                                <div class="custom-checkbox">
                                    <x-portal::input.checkbox.option
                                        required="false"
                                        name="permissions[{{ $sub->id }}]"
                                        value="{{ $sub->id }}"
                                        label="{{ $sub->name }}"
                                    ></x-portal::input.checkbox.option>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
                </ul>
        </div>
    </div>
</div>

@push('js')
<script>
document.querySelector('.btn-select-all').addEventListener('click', function () {
    document.querySelectorAll('.module-checkbox input[type="checkbox"]').forEach((item) => {
        item.checked = true;
    });
});

document.querySelector('.btn-unselect').addEventListener('click', function () {
    document.querySelectorAll('.module-checkbox input[type="checkbox"]').forEach((item) => {
        item.checked = false;
    });
});
</script>
@endpush