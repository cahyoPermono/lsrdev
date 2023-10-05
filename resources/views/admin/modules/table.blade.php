@push('js')
    <style>
        .nested-sort {
            padding: 0;
        }

        .nested-sort li {
            list-style: none;
            margin: 0 0 5px;
            padding: 15px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 15px;
            font-size: 16px;
            font-weight: bold;
            cursor: grab
        }

        .nested-sort li ul {
            padding: 0;
            margin-top: 10px;
            margin-bottom: -5px;
        }

        .nested-sort .ns-dragged {
            outline: 1px solid red;
        }

        .nested-sort .ns-targeted {
            outline: 1px solid green;
            border-radius: 15px
        }

        .container {
            margin: 150px auto;
            max-width: 960px;
        }

        .nested-sort .modul-icon {
            font-size: 20px;
            margin-right: 15px;
        }

        .nested-sort a {
            text-decoration: none;
            font-size: 14px;
            color: #000;
            margin-left: 15px;
        }
    </style>
    {{-- https://www.hesamurai.com/nested-sort/latest/ --}}
    <script src="{{ asset('adminportal/js/Sortable.js?') }}"></script>
    <script>
        new NestedSort({
            actions: {
                onDrop: function(data) {
                    let formData = new FormData();
                    formData.set('_token', "{{ csrf_token() }}")
                    formData.set('data', JSON.stringify(data))
                    fetch("{{ route('admin.modules.sorting-menu') }}", {
                        method: "POST",
                        body: formData,
                    }).then(async (res) => {
                        if (res.status == 200) {} else {}
                    });
                }
            },
            el: '#application-module',
            listClassNames: ['nested-sort'],
            nestingLevels: 1
        });

        const btnCancel = document.querySelector('.btn-cancel')
        const titleForm = document.getElementById('title-form')
        const formMenu = document.getElementById('form-menu');
        const menuName = document.getElementById('name')
        const menuIcon = document.getElementById('icon')
        const menuKey = document.getElementById('key')
        
        document.querySelectorAll('.btn-edit').forEach((item) => {
            item.addEventListener('click', function() {
                console.log(menuIcon)
                const id = item.getAttribute('data-id');
                const name = item.getAttribute('data-name');
                const icon = item.getAttribute('data-icon').replace('isax', '');
                const key = item.getAttribute('data-key');
                menuIcon.removeAttribute('required');
                menuName.value = name;
                menuIcon.value = '';
                menuKey.value = key;
                btnCancel.classList.remove('d-none')
                titleForm.innerHTML = 'Update Static Menu';
                formMenu.querySelector('input[name="id"]')?.remove()
                formMenu.insertAdjacentHTML("beforeend", `<input type="hidden" name="id" value="${id}"/>`)
            })
        })

        btnCancel.addEventListener('click', function() {
            const niceIcon = menuIcon.parentElement.querySelector('.nice-select2 .ts-control .item')
            menuIcon.setAttribute('required', 'required');
            menuName.value = ''
            menuIcon.value = ''
            menuKey.value = ''
            window['select_menu_icon'].setValue('')
            btnCancel.classList.add('d-none')
            titleForm.innerHTML = 'Create Static Menu';
            formMenu.querySelector('input[name="id"]')?.remove()
        })
    </script>
@endpush
<x-portal::layout.admin page="Application Module" type="List">
    <div class="row">
        <div class="col-sm-7">
            <section class="app-content shadow-sm pb-2">
                <div class="header-form d-flex justify-content-between">
                    <div class="left-side d-flex align-items-center">
                        <h5 class="form-title">@lang('adminportal.order_application_module')</h5>
                    </div>
                </div>
                <ul id="application-module">
                    @foreach ($data as $row)
                        <li data-id="{{ $row->id }}">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex align-items-center">
                                    
                                    <i class="modul-icon"><img src="{{ asset($row->icon) }}" alt="{{ $row->name }} Icon" class="rounded-circle" style="height: 40px; width: 40px;"></i>
                                    {{ $row->name }}
                                </div>
                                <div class="d-flex">
                                    <a href="javascript:;" class="btn-edit" data-id="{{ $row->id }}"
                                        data-name="{{ $row->name }}" data-key="{{ $row->key }}"
                                        data-icon="{{  asset($row->icon) }}">Edit</a>
                                    <a href="javascript:;" data-toggle="confirmation"
                                        data-message="{{ __('adminportal.delete_confirmation') }}"
                                        data-action="{{ adminRoute('admin.modules.destroy', $row->uuid) }}"
                                        data-method="DELETE">Delete</a>
                                </div>
                            </div>
                            @if (count($row->sub))
                                <ul data-id="{{ $row->id }}">
                                    @foreach ($row->sub as $sub)
                                        <li data-id="{{ $sub->id }}">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i class="modul-icon {{ $sub->icon }}"><img src="{{ asset($row->icon) }}" alt="{{ $row->name }} Icon" class="rounded-circle" style="height: 40px; width: 40px;"></i>
                                                    {{ $sub->name }}
                                                </div>
                                                <div class="d-flex">
                                                    <a href="javascript:;" class="btn-edit"
                                                        data-id="{{ $sub->id }}" data-name="{{ $sub->name }}"
                                                        data-key="{{ $sub->key }}"
                                                        data-icon="{{ $sub->icon }}">Edit</a>
                                                    <a href="javascript:;" data-toggle="confirmation"
                                                        data-message="{{ __('adminportal.delete_confirmation') }}"
                                                        data-action="{{ adminRoute('admin.cms-modules.delete', $sub->id) }}"
                                                        data-method="DELETE">Delete</a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
        <div class="col-sm-5">
            <section class="app-content shadow-sm">
                <form action="{{ route('admin.modules.store') }}" method="post" id="form-menu" enctype="multipart/form-data">
                    @csrf
                    <div class="header-form d-flex justify-content-between">
                        <div class="left-side d-flex align-items-center">
                            <h5 class="form-title" id="title-form">@lang('adminportal.create_app_module')</h5>
                        </div>
                        <div class="right-side d-flex">
                            <a href="javascript:;" class="btn btn-light btn-cancel d-none text-upper">
                                @lang('adminportal.cancel')
                            </a>
                            <button type="submit" class="btn btn-dark text-upper ms-3">
                                @lang('adminportal.save')
                            </button>
                        </div>
                    </div>
                    <x-portal::input type="text" name="name" label="Name" placeholder="Name" style="width: 325px;" horizontal>{{old('name')}}</x-portal::input>
                    <x-portal::input type="file" name="icon" label="Icon" placeholder="Icon" style="width: 325px;" required horizontal>{{old('icon')}}</x-portal::inpu>
                        <span style="font-size: 10px;margin-left: 80px;">Biarkan kosong jika tidak ingin mengedit</span>
                        <label for="fileInput" style="font-size: 12px; margin-left: 80px;">Klik <a href="#" id="fileLabel">disini</a> untuk melihat <fieldset></fieldset></label>
                    <x-portal::input type="text" name="key" id="key" label="Key" placeholder="Key" style="width: 325px;" horizontal>{{old('key')}}</x-portal::input>
                      @push('js')
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                var nameInput = document.getElementById('name');
                                var keyInput = document.getElementById('key');

                                nameInput.addEventListener('input', function () {
                                    var nameValue = this.value;
                                    var key = generateKeyFromName(nameValue);
                                    keyInput.value = key;
                                });

                                function generateKeyFromName(name) {
                                    var key = name.replace(/[^a-za-z0-9]/g, '-');
                                    return key;
                                }
                            });
                        </script>
                        @endpush                  
                </form>
            </section>
        </div>
    </div>

    <x-portal::input.select.asset />
    </x-portal::layout.admin>