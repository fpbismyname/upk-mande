@props(['datas' => [], 'excludes' => []])

@php
    if (!$datas) {
        return null;
    }
    $data = $datas->first()->toArray();
    $arrayKeys = array_keys($data);
@endphp

<div class="overflow-x-auto bg-base-300 rounded-xl">
    <table class="table">
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
        <tbody>
            @foreach ($datas as $row)
                <tr class="hover:bg-base-200 transition-all">
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
                                <td>{{ GeneralHelper::UpperCase($value['nama_role']) }}</td>
                            @endif
                        @endif
                    @endforeach
                    <td class="flex flex-1 items-center justify-center gap-2 *:btn-sm">
                        <a class="btn btn-circle btn-info"
                            href="{{ GeneralHelper::currentRouteName() . '/' . $row['id'] . '/edit' }}"><x-utils.lucide-icon
                                iconName="pencil" /></a>
                        <a class="btn btn-circle btn-error" href=""><x-utils.lucide-icon iconName="trash" /></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
