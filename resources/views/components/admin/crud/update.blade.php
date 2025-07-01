@php
    $data = $datas;
    $title = $title ?? '';
@endphp
<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}">
        <h1>update</h1>
    </x-ui.admin-sidebar>
</x-app>
