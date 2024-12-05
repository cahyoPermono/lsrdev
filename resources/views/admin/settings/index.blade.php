<x-portal::layout.admin page="Settings" type="">
    <div class="row">
        <div class="col-sm-6">
            <section class="app-content shadow-sm pb-2">
                <h6>
                    <b>Application Setting</b>
                </h6>
                <form action="{{ route('admin.settings.app-version') }}" method="post">
                    @csrf
                    <x-portal::input type="text" name="android_version" label="Android Version" placeholder="1.1.1">
                        {{$app_version?->android_version}}
                    </x-portal::input>
                    
                    <x-portal::input type="text" name="ios_version" label="IOS Version" placeholder="1.1.1">
                        {{$app_version?->ios_version}}
                    </x-portal::input>
                    <x-portal::input type="url" name="download_url" label="Download App Url" placeholder="https://drive.google.com/">
                    {{$app_version?->download_url}}
                    </x-portal::input>
                    <x-portal::input.textarea name="text_template" label="Popup Text Description" placeholder="Isikan deskripsi popup">
                        {{$app_version?->text_template}}
                    </x-portal::input.textarea>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </section>
        </div>
        <div class="col-sm-3">
            <section class="app-content shadow-sm pb-2">
                <h6>
                    <b>Account Setting</b>
                </h6>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <x-portal::input type="number" name="min_active_day" label="Max in Active Day" placeholder="90">
                        {{ $min_active_day }}
                    </x-portal::input>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </section>
        </div>
    </div>
</x-portal::layout.admin>
