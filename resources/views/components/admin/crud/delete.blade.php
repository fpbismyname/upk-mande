@php
    $data = $datas;
    $title = $title ?? '';
@endphp
<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}">
        <h1>delete</h1>
    </x-ui.admin-sidebar>
</x-app>
