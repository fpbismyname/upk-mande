@props(['title' => 'title-navbar', 'leftItem' => '', 'hrefAddButton' => '#'])

@php
    $queryUrl = request('search');
    $onAdd = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'create');
    $onEdit = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'edit');
    $back = url()->current() === url()->previous() ? route('admin-dashboard') : url()->previous();
    $isDashboard = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'admin');
@endphp

<div class="flex p-4 rounded-xl items-center bg-base-300 justify-between w-full">
    <div>
        <h1 class="font-bold">{{ $title }}</h1>

    </div>
    @if (!$onAdd && !$onEdit)
        <div>
            <a href="{{ GeneralHelper::currentRouteName() . '/create' }}" class="btn btn-secondary btn-xs">Tambah Data</a>
        </div>
    @else
        <div>
            <a href="{{ $back }}" class="btn btn-secondary btn-xs">Kembali</a>
        </div>
    @endif
</div>
@if (!$onAdd && !$isDashboard && !$onEdit)
    <div class="flex p-4 rounded-xl items-center justify-end w-full">
        <div>
            @if ($leftItem)
                <form action="{{ route(GeneralHelper::currentRouteName('name')) }}" method="GET" class="flex gap-4">
                    <input type="search" name="search" placeholder="{{ $leftItem }}"
                        class="input input-accent input-sm" value="{{ request('search') }}" />
                    <button type="submit" class="btn btn-sm btn-circle btn-accent">
                        <x-utils.lucide-icon iconName="search" />
                    </button>
                </form>
            @endif
        </div>
    </div>
@endif
