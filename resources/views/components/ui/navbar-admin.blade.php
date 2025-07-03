@props(['title' => 'title-navbar', 'leftItem' => '', 'routeName' => ''])

@php
    $queryUrl = request('search');
    $onAddPage = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'create');
    $onEditPage = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'edit');
    $isDashboard = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'admin');
@endphp

<div class="flex p-4 rounded-xl items-center bg-base-300 justify-between w-full">
    <div class="flex items-center gap-4">
        <h1 class="font-bold">{{ $title }}</h1>
    </div>
</div>
@if (!GeneralHelper::Contains($routeName, 'pendanaan'))
    @if (!$onAddPage && !$onEditPage && !$isDashboard)
        <div class="flex p-4 rounded-xl items-center bg-base-300 justify-between w-full flex-col sm:flex-row gap-4">
            @if (!$onAddPage && !$onEditPage && !$isDashboard)
                <div class="flex  items-center gap-4">
                    <form method="GET" class="flex gap-4">
                        <div class="join">
                            <input type="search" name="search" placeholder="{{ $leftItem }}"
                                class="input input-primary input-sm join-item"
                                @if (!$leftItem) disabled @endif value="{{ request('search') }}" />
                            <button type="submit" class="btn btn-sm btn-primary join-item"
                                @if (!$leftItem) disabled @endif>
                                <x-utils.lucide-icon iconName="search" />
                            </button>
                        </div>
                    </form>

                </div>
            @endif
            @if (!$onAddPage && !$onEditPage && !$isDashboard)
                <div class="flex rounded-xl w-fit">
                    <a href="{{ !$isDashboard ? route("$routeName.create") : '#' }}" class="btn btn-primary btn-sm">
                        <x-utils.lucide-icon iconName="circle-plus" /> Tambah data</a>
                </div>
            @endif
        </div>
    @endif
@endif
