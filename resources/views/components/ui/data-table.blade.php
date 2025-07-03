@props(['datas' => [], 'excludes' => [], 'routeName' => '#'])

@php
    if ($routeName === 'admin') {
        return null;
    }
    $data = $datas->first() ? $datas->first()->toArray() : [];
    $arrayKeys = array_keys($data);

@endphp

<div class="overflow-x-auto bg-base-300 rounded-xl">
    <table class="table">
        {{-- Header table --}}
        <thead>
            <tr>
                <th>#</th>
                @foreach ($arrayKeys as $column)
                    @if (!in_array($column, $excludes))
                        <th>{{ GeneralHelper::UpperCase($column) }}</th>
                    @endif
                @endforeach
                <th>Action</th>
            </tr>
        </thead>
        {{-- Body Table --}}
        <tbody>
            @if ($datas->count())
                @foreach ($datas as $row)
                    <tr class="hover:bg-gray-300 transition-all">
                        <td>{{ $loop->iteration }}</td>
                        @foreach ($row->toArray() as $key => $value)
                            @if (!in_array($key, $excludes))
                                @if (!is_array($value))
                                    @if (GeneralHelper::isIsoDateString($value))
                                        <td>{{ GeneralHelper::formatDate($value) }}</td>
                                    @else
                                        <td>{{ $value }}</td>
                                    @endif
                                @else
                                    {{-- <td>{{ GeneralHelper::UpperCase($value[0]) }}</td> --}}
                                @endif
                            @endif
                        @endforeach
                        <td class="flex flex-1 items-center justify-center gap-2 *:btn-sm">
                            <a class="btn btn-circle btn-info"
                                href="{{ route($routeName . '.edit', [GeneralHelper::SnakeCase($routeName) => $row['id']]) }}"><x-utils.lucide-icon
                                    iconName="pencil" /></a>
                            <form
                                action="{{ route($routeName . '.destroy', [GeneralHelper::SnakeCase($routeName) => $row['id']]) }}"
                                method="post">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-circle btn-error"><x-utils.lucide-icon
                                        iconName="trash" /></button>
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
@if ($datas->links()->toHTML())
    <div class="p-4 bg-base-300 rounded-xl">
        {{ $datas->links() }}
    </div>
@endif
