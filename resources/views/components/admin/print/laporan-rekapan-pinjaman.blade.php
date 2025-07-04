@php
    $data = $datas->toArray();

@endphp

<div class="overflow-x-auto bg-base-300 rounded-xl">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Grup</th>
                <th>Limit Pinjaman</th>
                <th>Jumlah Pinjaman</th>
                <th>Pinjaman ke X kali</th>
                <th>Ketua Grup</th>
                <th>Status Grup</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $grup)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $grup->nama_grup }}</td>
                    <td>{{ $grup->limit_pinjaman }}</td>
                    <td>{{ $grup->pinjaman_sum_nominal_pinjaman }}</td>
                    <td>{{ $grup->pinjaman_count }}</td>
                    <td>{{ $grup->users['nama_lengkap'] }}</td>
                    <td>{{ $grup->status['nama_status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
