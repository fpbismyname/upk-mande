@php
    $data = $datas;
    $excludes = $exclude ?? [];
    $currentRoute = GeneralHelper::currentRouteName('name');
    $isDashboard = GeneralHelper::Equals(GeneralHelper::currentRouteName(), '/admin');
    $placeholder = isset($placeholder) === true && !$data->isEmpty() ? $placeholder : '';
@endphp
<x-app title="{{ $title }}">
    <x-ui.admin-sidebar title="{{ $title }}" leftItem="{{ $placeholder }}">
        @if ($isDashboard)
            <h1>Dashboard</h1>
        @elseif (isset($data) && !$isDashboard && $data->isNotEmpty())
            <x-ui.data-table :datas="$data" :excludes="$excludes" />
        @else
            <div class="flex flex-1 items-center justify-center">
                <div class="flex flex-col gap-2 p-4 rounded-xl items-center justify-center bg-base-300">
                    <x-utils.lucide-icon iconName="circle-slash" />
                    <h1 class="font-bold">Data tidak tersedia.</h1>
                    <button class="btn btn-secondary my-4">Tambah data</button>
                </div>
            </div>
        @endif
    </x-ui.admin-sidebar>
</x-app>
