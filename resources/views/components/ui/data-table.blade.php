@props(['datas' => [], 'includes' => [], 'routeName' => 'admin'])


{{-- Page Dashboard --}}
@if (GeneralHelper::Contains($routeName, 'admin'))
    @php
        $indicators = $datas;
    @endphp
    @php
        $index = 0;
    @endphp
    <div class="flex flex-row">
        <div class="flex flex-row rounded-xl p-4 bg-base-300 *:text-base-200 flex-1 gap-4">
            <div class="flex flex-col">
                <h1 class="font-bold">Hi, {{ auth()->user()->nama_lengkap }}</h1>
                <span class="my-2">
                    <p>{{ GeneralHelper::getAppName('welcome') }}</p>
                    <p>{{ GeneralHelper::getAppName('desc') }}</p>
                </span>
            </div>
        </div>
    </div>
    <div class="flex flex-row gap-4">
        <div class="flex flex-col flex-1 gap-4">
            @foreach ($indicators as $key => $value)
                @if ($index % 3 === 0)
                    <div class="stats gap-4">
                @endif
                <div class="stats bg-primary">
                    <div class="stat">
                        <div class="*:text-primary-content">
                            <div class="stat-title flex gap-2"><x-utils.lucide-icon
                                    iconName="{{ $value['icon'] }}" />{{ GeneralHelper::UpperCase($key) }}</div>
                            <div class="stat-value">{{ $value['value'] }}</div>
                        </div>
                    </div>
                </div>
                @php
                    $index++;
                @endphp
                @if ($index % 3 === 0 || $loop->last)
        </div>
@endif
@endforeach
</div>
</div>
@endif


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
                            <label for="new-saldo">Tambah saldo</label>
                            <div class="flex join">
                                <div class="label">
                                    Rp.
                                    <input type="number" class="input input-sm join-item" x-model="new_saldo"
                                        name="new-saldo">
                                </div>
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
                            <label for="new-saldo">Tarik saldo</label>
                            <div class="flex join">
                                <div class="label">
                                    Rp.
                                    <input type="number" class="input input-sm join-item" x-model="new_saldo"
                                        name="new-saldo">
                                </div>
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

{{-- Suku Bunga --}}

@if (GeneralHelper::Contains($routeName, 'suku-bunga'))
    @php
        $sukuBunga = $datas->first()->toArray();
    @endphp
    <div class="flex flex-col flex-1">
        <div class="stats bg-primary">
            <div class="stat">
                <div class="*:text-primary-content">
                    <div class="stat-title">Suku bunga pinjaman</div>
                    <div class="stat-value">{{ GeneralHelper::formatPersentage($sukuBunga['jumlah_suku_bunga']) }}
                    </div>
                </div>
                <div class="stat-action" x-data="{ new_saldo: 0 }">
                    <button class="btn btn-xs btn-success" popovertarget="changeInterestRate"
                        style="anchor-name:--change-interest-rate">
                        Ubah Suku Bunga
                    </button>
                    <ul class="dropdown menu rounded-box bg-base-300 border-2 mt-2" popover id="changeInterestRate"
                        style="position-anchor:--change-interest-rate">
                        <form action="{{ GeneralHelper::routeAction($routeName, null, 'store') }}"
                            class="flex flex-col   gap-2" method="POST">
                            @csrf
                            <label for="jumlah_suku_bunga">Ubah Suku Bunga</label>
                            <div class="flex join">
                                <div class="label">
                                    %
                                    <input type="number" class="input input-sm join-item" x-model="new_saldo"
                                        name="jumlah_suku_bunga">
                                </div>
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

@if (!GeneralHelper::Contains($routeName, ['pendanaan', 'suku-bunga', 'admin', '#']))
    @php
        $data = $datas->first()->toArray();
        $arrayKeys = array_keys($data);
    @endphp
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
                                        @elseif (
                                            (is_numeric($value) && $key === 'nominal_pinjaman') ||
                                                $key === 'jumlah_pinjaman' ||
                                                $key === 'nominal_cicilan' ||
                                                $key === 'pinjaman_sum_nominal_pinjaman' ||
                                                $key === 'limit_pinjaman')
                                            <td>{{ GeneralHelper::formatRupiah($value) }} </td>
                                        @elseif (is_numeric($value) && $key === 'suku_bunga')
                                            <td>{{ $value }} % </td>
                                        @elseif (is_numeric($value) && $key === 'pinjaman_count')
                                            <td>{{ $value }} kali </td>
                                        @else
                                            <td>{{ $value }}</td>
                                        @endif
                                    @else
                                        @php
                                            $arrayKeys = isset($value) ? array_keys($value) : [];
                                        @endphp
                                        @foreach ($arrayKeys as $key)
                                            @if (in_array($key, $includes))
                                                <td>{{ GeneralHelper::UpperCase($value[$key]) }}</td>
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
