@props(['title' => 'title-navbar', 'leftItem' => '', 'routeName' => ''])

@php
    $queryUrl = request('search');
    $onAddPage = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'create');
    $onEditPage = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'edit');
    $back = url()->current() === url()->previous() ? route('admin-dashboard') : url()->previous();
    $isDashboard = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'admin');
@endphp

<div class="flex p-4 rounded-xl items-center bg-base-300 justify-between w-full">
    <div class="flex items-center gap-4">
        <h1 class="font-bold">{{ $title }}</h1>
        @if (!$onAddPage && !$onEditPage && !$isDashboard)
            <div class="flex rounded-xl w-fit">
                <a href="{{ !$isDashboard ? route("$routeName.create") : '#' }}" class="btn btn-primary btn-xs">
                    <x-utils.lucide-icon iconName="circle-plus" />Tambah data</a>
            </div>
        @endif
    </div>
    @if (!$onAddPage && !$onEditPage && !$isDashboard)
        <div class="flex  items-center gap-4">
            <form method="GET" class="flex gap-4">
                <input type="search" name="search" placeholder="{{ $leftItem }}"
                    class="input input-primary input-sm" value="{{ request('search') }}" />
                <button type="submit" class="btn btn-sm btn-circle btn-primary">
                    <x-utils.lucide-icon iconName="search" />
                </button>
            </form>

        </div>
    @endif
    @if ($onEditPage || $onAddPage)
        <a href="{{ $back }}" class="btn btn-xs btn-secondary">Kembali</a>
    @endif
</div>
