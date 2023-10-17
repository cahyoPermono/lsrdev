<x-portal::input type="text" name="email" label="Email" placeholder="Email" horizontal>
    {{ @$email ?: old('email') }}
</x-portal::input>
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
            <ul class="list-permission list-group" style="margin-left: 10px">
                @foreach ($appModules as $module)
                    <li class="list-group-item p-0 ps-3" style="padding:5px !important">
                        <div class="custom-checkbox">
                            <x-portal::input.checkbox.option required="false"
                                selected="{{in_array($module->id,$authorization)}}"
                                name="permissions[{{ $module->id }}]" value="{{ $module->id }}"
                                label="{{ $module->name }}">
                            </x-portal::input.checkbox.option>
                        </div>
                    </li>
                    @if (count($module->sub))
                        <ul class="list-group">
                            @foreach ($module->sub as $sub)
                                <li class="list-group-item p-0 ps-3" style="margin-left: 24px;padding:5px !important">
                                    <div class="custom-checkbox">
                                        <x-portal::input.checkbox.option required="false"
                                            selected="{{in_array($sub->id,$authorization)}}"
                                            name="permissions[{{ $sub->id }}]" value="{{ $sub->id }}"
                                            label="{{ $sub->name }}">
                                        </x-portal::input.checkbox.option>
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
        document.querySelector('.btn-select-all').addEventListener('click', function() {
            document.querySelectorAll('.list-permission input[type="checkbox"]').forEach((item) => {
                item.checked = true;
            });
        });

        document.querySelector('.btn-unselect').addEventListener('click', function() {
            document.querySelectorAll('.list-permission input[type="checkbox"]').forEach((item) => {
                item.checked = false;
            });
        });
    </script>
    <style>
        .list-permission.list-group .form-checkbox label {
            font-size: 16px !important;
        }

        .form-checkbox input:checked::before,
        .form-checkbox input[checked=true]::before {
            margin-top: 2px;
        }
    </style>
@endpush
