@props(['datas' => [], 'includes' => [], 'routeName' => '#'])

@php
    if ($routeName === 'admin') {
        return null;
    }
    $data = $datas->first() ? $datas->first()->toArray() : [];
    $arrayKeys = array_keys($data);

@endphp

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
                <div class="stat-action">
                    <button class="btn btn-xs btn-success" popovertarget="addFund" style="anchor-name:--add-fund">
                        Tambah saldo
                    </button>
                    <button class="btn btn-xs btn-error" popovertarget="decreaseFund"
                        style="anchor-name:--decrease-fund">
                        Tarik saldo
                    </button>
                    <ul class="dropdown menu rounded-box bg-base-300 border-2 mt-2" popover id="addFund"
                        style="position-anchor:--add-fund">
                        <form action="{{ route($routeName . '.store') }}" class="flex gap-2" method="POST">
                            @csrf
                            <input type="number" class="input input-sm input-neutral" name="new-saldo">
                            <button class="btn btn-sm btn-primary">Submit</button>
                        </form>
                    </ul>
                    <ul class="dropdown menu rounded-box bg-base-300 border-2 mt-2" popover id="decreaseFund"
                        style="position-anchor:--decrease-fund">
                        <form action="{{ route($routeName . '.update', ['pendanaan' => $pendanaan['id']]) }}"
                            class="flex gap-2" method="POST">
                            @method('PUT')
                            @csrf
                            <input type="number" class="input input-sm input-neutral" name="new-saldo">
                            <button class="btn btn-sm btn-primary">Submit</button>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif


@if (!GeneralHelper::Contains($routeName, 'pendanaan'))
    <div class="overflow-x-auto bg-base-300 rounded-xl">
        <table class="table">
            {{-- Header table --}}
            <thead>
                <tr>
                    <th>#</th>
                    @foreach ($arrayKeys as $column)
                        @if (in_array($column, $includes))
                            <th>{{ GeneralHelper::UpperCase($column) }}</th>
                        @endif
                    @endforeach
                    <th>Action</th>
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
                                        @elseif (is_numeric($value) && $key != 'nik')
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
                                                @if (!GeneralHelper::isIsoDateString($value[$key]))
                                                    <td>{{ GeneralHelper::UpperCase($value[$key]) }}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            @endforeach

                            <td class="flex items-center gap-2  ">
                                <a class="btn btn-sm btn-info"
                                    href="{{ route($routeName . '.edit', [GeneralHelper::SnakeCase($routeName) => $row['id']]) }}"><x-utils.lucide-icon
                                        iconName="pencil" /> Edit</a>
                                <form
                                    action="{{ route($routeName . '.destroy', [GeneralHelper::SnakeCase($routeName) => $row['id']]) }}"
                                    method="post">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-error"><x-utils.lucide-icon
                                            iconName="trash" />Hapus</button>
                                </form>
                            </td>
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
