
<x-portal::layout.admin page="Settings" type="">
        <section class="app-content shadow-sm pb-2">
            <form action="{{ route('admin.settings.store') }}" method="post">
                @csrf
                <x-portal::input type="number" name="min_active_day" label="Max in Active Day" placeholder="90" horizontal>
                    {{$min_active_day->value}}
                </x-portal::input>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </section>
    </x-portal::layout.admin>