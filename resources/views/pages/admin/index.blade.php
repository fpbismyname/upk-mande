<x-app title="Welcome {{ auth()->user()->name }}">
    <x-ui.admin-sidebar>
        @switch(request()->query('menu'))
            @case('dashboard')
                <x-admin.dashboard />
            @break

            @case('data-anggota')
                <x-admin.data-anggota />
            @break

            @case('transaksi-angsuran')
                <x-admin.transaksi.angsuran />
            @break

            @case('transaksi-pencairan')
                <x-admin.transaksi.pencairan />
            @break

            @case('transaksi-pinjaman')
                <x-admin.transaksi.pinjaman />
            @break

            @case('laporan-transaksi')
                <x-admin.laporan.transaksi />
            @break

            @case('laporan-data-anggota')
                <x-admin.laporan.data-anggota />
            @break

            @case('laporan-pinjaman')
                <x-admin.laporan.pinjaman />
            @break

            @default
                <x-admin.dashboard />
        @endswitch
    </x-ui.admin-sidebar>
</x-app>
