@php
    $data = $datas;
    $includes = $include ?? [];
    $currentRoute = GeneralHelper::currentRouteName('name');
    $placeholder = isset($placeholder) === true ? $placeholder : '';
@endphp

<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}" leftItem="{{ $placeholder }}" :routeName="$routeName">
        <x-ui.data-table :datas="$data" :includes="$includes" :routeName="$routeName" />
    </x-ui.admin-sidebar>
</x-app>
