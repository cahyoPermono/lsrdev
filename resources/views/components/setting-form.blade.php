<div>
    <x-portal::layout.admin page="Settings" type="">
        <section class="app-content shadow-sm pb-2">
            <form action="{{ route('admin.settings.store') }}" method="post">
                @csrf
                <!-- Tambahkan elemen-elemen form yang Anda butuhkan di sini -->
            </form>
        </section>
    </x-portal::layout.admin>
</div>
