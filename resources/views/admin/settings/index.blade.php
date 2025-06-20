<x-portal::layout.admin page="Settings" type="">
    <div class="row">
        <div class="col-sm-9">
            <section class="app-content shadow-sm pb-2">
                <h6><b>Application Settings</b></h6>

                @foreach($app_versions as $index => $version)
                    <form action="{{ route('admin.settings.app-version') }}" method="post" class="mb-4 border-bottom pb-3">
                        @csrf

                        <input type="hidden" name="app" value="{{ $version['app'] }}">

                        <h6 class="text-capitalize mt-3">{{ ucwords(str_replace('_', ' ', $version['app'])) }}</h6>

                        <x-portal::input type="text" name="android_version" label="Android Version" placeholder="1.1.1">
                            {{ $version['android_version'] ?? '' }}
                        </x-portal::input>

                        <x-portal::input type="text" name="ios_version" label="iOS Version" placeholder="1.1.1">
                            {{ $version['ios_version'] ?? '' }}
                        </x-portal::input>

                        <x-portal::input type="url" name="download_url" label="Download App Url" placeholder="https://drive.google.com/">
                            {{ $version['download_url'] ?? '' }}
                        </x-portal::input>

                        <x-portal::input type="popup_title" name="popup_title" label="Popup Title" placeholder="Isikan judul popup">
                            {{ $version['popup_title'] ?? '' }}
                        </x-portal::input>

                        <x-portal::input.textarea name="text_template" label="Popup Text Description" placeholder="Isikan deskripsi popup">
                            {{ $version['text_template'] ?? '' }}
                        </x-portal::input.textarea>

                        <x-portal::input type="button_text" name="button_text" label="Button Text" placeholder="Isikan teks">
                            {{ $version['button_text'] ?? '' }}
                        </x-portal::input>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                @endforeach
            </section>
        </div>

        <div class="col-sm-3">
            <section class="app-content shadow-sm pb-2">
                <h6><b>Account Setting</b></h6>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <x-portal::input type="number" name="min_active_day" label="Max Inactive Day" placeholder="90">
                        {{ $min_active_day }}
                    </x-portal::input>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </section>
        </div>
    </div>
</x-portal::layout.admin>
