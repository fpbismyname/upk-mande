@php
    $data = $datas->toArray();

@endphp

<div class="overflow-x-auto bg-base-300 rounded-xl">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Grup</th>
                <th>Nominal Cicilan</th>
                <th>Jatuh Tempo</th>
                <th>Telat Bayar</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $cicilan_pinjaman)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cicilan_pinjaman->grup['nama_grup'] }}</td>
                    <td>{{ $cicilan_pinjaman->nominal_cicilan }}</td>
                    <td>{{ $cicilan_pinjaman->jatuh_tempo }}</td>
                    <td>{{ $cicilan_pinjaman->telat_bayar }}</td>
                    <td>{{ $cicilan_pinjaman->status['nama_status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
