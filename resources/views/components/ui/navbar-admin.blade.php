@props(['title' => 'title-navbar', 'leftItem' => '', 'routeName' => 'adminn', 'listMenu' => []])

@php
    $queryUrl = request('search');
    $onAddPage = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'create');
    $onEditPage = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'edit');
    $isDashboard = GeneralHelper::Contains(GeneralHelper::currentRouteName('name'), 'admin');

    // current routes
    $currentRoute = GeneralHelper::currentRouteName();

    // redirect route for add data
    $routeAdd = $routeName === 'admin' ? '#' : route("$routeName.create");

@endphp

<div class="flex p-4 rounded-xl bg-base-300 gap-4 w-full">
    <div class="hidden">
        <div class="drawer w-fit">
            <input id="my-drawer" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content">
                <label for="my-drawer" class="btn btn-sm drawer-button">
                    <x-utils.lucide-icon iconName="menu" />
                </label>
            </div>
            <div class="drawer-side">
                <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                    <div class="p-4 bg-base-300 sticky top-0 rounded-xl">
                        <h1 class="font-bold text-xl">
                            {{ GeneralHelper::getAppName() }}
                        </h1>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex flex-1 flex-col *:p-2 p-2">
                            @foreach ($listMenu as $menu)
                                {{-- Type Divider --}}
                                @if ($menu['type'] === 'divider')
                                    <li class="my-2 text-sm px-4 text-gray-500">
                                        {{ GeneralHelper::UpperCase($menu['title']) }}
                                    </li>
                                @endif
                                {{-- Type item --}}
                                @if ($menu['type'] === 'item')
                                    @php
                                        $activeMenu = GeneralHelper::Equals($currentRoute, $menu['route']);
                                    @endphp
                                    <li
                                        class="flex gap-2 items-center rounded-xl cursor-pointer transition-all {{ $activeMenu ? 'bg-base-300' : 'hover:bg-base-300' }}">
                                        <a href="{{ $menu['route'] }}"
                                            class="w-full flex flex-row gap-2 item-center {{ $activeMenu ? 'font-bold' : '' }}">
                                            <x-utils.lucide-icon iconName="{{ $menu['icon'] }}" class="self-center" />
                                            {{ GeneralHelper::UpperCase($menu['title']) }}
                                        </a>
                                    </li>
                                @endif
                                {{-- Type Dropdown --}}
                                <li>
                                    @if ($menu['type'] === 'dropdown')
                                        @php
                                            $activeMenuDropdown = GeneralHelper::Contains(
                                                $currentRoute,
                                                $menu['route'],
                                            );
                                        @endphp
                                        <div class="collapse {{ $activeMenuDropdown ? 'collapse-open' : '' }}">
                                            <input type="checkbox">
                                            <div
                                                class="collapse-title flex item-center gap-2 p-0 {{ $activeMenuDropdown ? 'font-bold' : '' }}">
                                                <x-utils.lucide-icon iconName="{{ $menu['icon'] }}" class="my-1" />
                                                {{ GeneralHelper::UpperCase($menu['title']) }}
                                            </div>
                                            <div class="collapse-content">
                                                @foreach ($menu['children'] as $item)
                                                    @php
                                                        // Check Current Active Dropdown Item
                                                        $activeMenuItem = GeneralHelper::Equals(
                                                            $currentRoute,
                                                            $item['route'],
                                                        );
                                                    @endphp
                                                    <a class="flex gap-2 items-center rounded-xl cursor-pointer transition-all my-2 w-full {{ $activeMenuItem ? 'bg-base-300' : 'hover:bg-base-300' }} p-2 {{ $activeMenuItem ? 'font-bold' : '' }}"
                                                        href="{{ $item['route'] }}">
                                                        <x-utils.lucide-icon iconName="{{ $item['icon'] }}" />
                                                        {{ GeneralHelper::UpperCase($item['title']) }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex p-4 bg-base-300 mt-auto items-center gap-4 sticky bottom-0 rounded-xl">
                        <div class="flex flex-1 gap-4 items-center">
                            <img src="{{ asset('images/profile.png') }}" alt="" class="w-10 h-10">
                            <div class="flex flex-col overflow-auto">
                                <h5 class="font-bold overflow-hidden overflow-ellipsis">
                                    {{ GeneralHelper::UpperCase(auth()->user()->nama_lengkap) }}
                                </h5>
                                @php
                                    $userId = auth()->user()->id;
                                    $user = App\Models\User::with('role_user')->find($userId);
                                    $userRole = $user->role_user->nama_role;
                                @endphp
                                <p>{{ GeneralHelper::UpperCase($userRole) }}</p>
                            </div>
                        </div>
                        <div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-circle btn-error">
                                    <x-utils.lucide-icon iconName="log-out" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <h1 class="font-bold">{{ $title }}</h1>
    </div>
</div>

@if (!GeneralHelper::Contains($routeName, ['pendanaan', 'laporan', 'suku-bunga', 'admin']))
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
                    <a href="{{ $routeAdd }}" class="btn btn-primary btn-sm">
                        <x-utils.lucide-icon iconName="circle-plus" /> Tambah data</a>
                </div>
            @endif
        </div>
    @endif
@endif

@if (GeneralHelper::Contains($routeName, ['laporan']))
    @php
        // Route for print laporan / report
        $printReport = route("print.$routeName");
    @endphp
    <div class="flex p-4 rounded-xl items-center bg-base-300 justify-between w-full flex-col sm:flex-row gap-4">
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
        <div class="flex rounded-xl w-fit">
            <a href="{{ $printReport }}" class="btn btn-primary btn-sm">
                <x-utils.lucide-icon iconName="printer" />Print</a>
        </div>
    </div>
@endif
