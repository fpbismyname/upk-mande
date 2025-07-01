@php
    $title = $title ?? '';
@endphp
<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}">
        <h1>add</h1>
    </x-ui.admin-sidebar>
</x-app>
