@props(['datas' => [], 'includes' => [], 'routeName' => '#'])

@php
    if (!$routeName) {
        return null;
    }
    $data = $datas->first() ? $datas->first()->toArray() : [];
    $arrayKeys = array_keys($data);

@endphp


{{-- Page Pendanaan --}}

@if (GeneralHelper::Contains($routeName, 'pendanaan'))
    @php
        $pendanaan = $datas->first()->toArray();
    @endphp
    <div class="flex flex-col flex-1">
        <div class="stats bg-primary">
            <div class="stat">
                <div class="*:text-primary-content">
                    <div class="stat-title">Saldo Pendanaan</div>
                    <div class="stat-value">{{ GeneralHelper::formatRupiah($pendanaan['saldo']) }}</div>
                </div>
                <div class="stat-action" x-data="{ new_saldo: 0 }">
                    <button class="btn btn-xs btn-success" popovertarget="addFund" style="anchor-name:--add-fund">
                        Tambah saldo
                    </button>
                    <ul class="dropdown menu rounded-box bg-base-300 border-2 mt-2" popover id="addFund"
                        style="position-anchor:--add-fund">
                        <form action="{{ GeneralHelper::routeAction($routeName, null, 'store') }}"
                            class="flex flex-col   gap-2" method="POST">
                            @csrf
                            <label for="new_saldo">Tambah saldo</label>
                            <div class="flex join">
                                <input type="number" class="input input-sm join-item" x-model="new_saldo"
                                    name="new-saldo">
                                <button class="btn btn-sm btn-primary join-item"
                                    x-bind:disabled="new_saldo <= 0 && !new_saldo">Submit</button>
                            </div>
                        </form>
                    </ul>
                    <button class="btn btn-xs btn-error" popovertarget="cashoutFund" style="anchor-name:--cashout-fund">
                        Tarik saldo
                    </button>
                    <ul class="dropdown menu rounded-box bg-base-300 border-2 mt-2" popover id="cashoutFund"
                        style="position-anchor:--cashout-fund">
                        <form action="{{ GeneralHelper::routeAction($routeName, $pendanaan['id'], 'update') }}"
                            class="flex flex-col   gap-2" method="POST">
                            @method('PUT')
                            @csrf
                            <label for="new_saldo">Tarik saldo</label>
                            <div class="flex join">
                                <input type="number" class="input input-sm join-item" x-model="new_saldo"
                                    name="new-saldo">
                                <button class="btn btn-sm btn-primary join-item"
                                    x-bind:disabled="new_saldo <= 0 && !new_saldo">Submit</button>
                            </div>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif



{{-- Dynamic page  --}}

@if (!GeneralHelper::Contains($routeName, 'pendanaan'))
    <div class="overflow-x-auto bg-base-300 rounded-xl">
        <table class="table">
            {{-- Header table --}}
            <thead>
                <tr>
                    <th>#</th>
                    @foreach ($arrayKeys as $column)
                        @if (in_array($column, $includes))
                            @if (GeneralHelper::Contains($column, 'pinjaman_count'))
                                <th>{{ GeneralHelper::Replace($column, 'pinjaman_count', 'Pinjaman ke X kali') }}</th>
                            @elseif (GeneralHelper::Contains($column, 'pinjaman_sum_nominal_pinjaman'))
                                <th>{{ GeneralHelper::Replace($column, 'pinjaman_sum_nominal_pinjaman', 'Jumlah Pinjaman') }}
                                </th>
                            @else
                                <th>{{ GeneralHelper::UpperCase($column) }}</th>
                            @endif
                        @endif
                    @endforeach
                    @if (!GeneralHelper::Contains($routeName, 'laporan'))
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            {{-- Body Table --}}
            <tbody>
                @if ($datas->count())
                    @foreach ($datas as $index => $row)
                        <tr class="hover:bg-gray-300 transition-all">
                            <td>{{ $datas->firstItem() + $index }}</td>
                            @foreach ($row->toArray() as $key => $value)
                                @if (in_array($key, $includes))
                                    @if (!is_array($value))
                                        @if (GeneralHelper::isIsoDateString($value))
                                            <td>{{ GeneralHelper::formatDate($value) }}</td>
                                        @elseif (is_numeric($value) && $key != 'nik' && $key != 'pinjaman_count')
                                            <td>{{ GeneralHelper::formatRupiah($value) }} </td>
                                        @else
                                            <td>{{ $value }}</td>
                                        @endif
                                    @else
                                        @php
                                            $arrayKeys = isset($value) ? array_keys($value) : [];
                                        @endphp
                                        @foreach ($arrayKeys as $key)
                                            @if (in_array($key, $includes))
                                                @if (is_numeric($value[$key]) && $key === 'jumlah_suku_bunga')
                                                    <td>{{ $value[$key] }} %</td>
                                                @else
                                                    <td>{{ GeneralHelper::UpperCase($value[$key]) }}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach
                            @if (!GeneralHelper::Contains($routeName, 'laporan'))
                                <td class="flex items-center gap-2  ">
                                    <a class="btn btn-sm btn-info"
                                        href="{{ GeneralHelper::routeAction($routeName, $row['id'], 'edit') }}"><x-utils.lucide-icon
                                            iconName="pencil" /> Edit</a>
                                    <form action="{{ GeneralHelper::routeAction($routeName, $row['id'], 'destroy') }}"
                                        method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-error"><x-utils.lucide-icon
                                                iconName="trash" />Hapus</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center">No Data</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if ($datas && $datas->links()->toHTML())
        <div class="p-4 bg-base-300 rounded-xl">
            {{ $datas->links() }}
        </div>
    @endif
@endif
