@php
    $ListMenu = [
        [
            'title' => 'main-menu',
            'type' => 'divider',
        ],
        [
            'icon' => 'layout-dashboard',
            'name' => 'dashboard',
            'type' => 'item',
        ],
        [
            'title' => 'master-Data',
            'type' => 'divider',
        ],
        [
            'icon' => 'users',
            'name' => 'data-anggota',
            'type' => 'item',
        ],
        [
            'title' => 'transaksi',
            'icon' => 'arrow-left-right',
            'type' => 'dropdown',
            'children' => [
                [
                    'icon' => 'hand-coins',
                    'name' => 'pinjaman',
                ],
                [
                    'icon' => 'banknote-arrow-down',
                    'name' => 'angsuran',
                ],
                [
                    'icon' => 'coins',
                    'name' => 'pencairan',
                ],
            ],
        ],
        [
            'title' => 'laporan',
            'icon' => 'book',
            'type' => 'dropdown',
            'children' => [
                [
                    'icon' => 'hand-coins',
                    'name' => 'pinjaman',
                ],
                [
                    'icon' => 'arrow-left-right',
                    'name' => 'transaksi',
                ],
                [
                    'icon' => 'users',
                    'name' => 'data-anggota',
                ],
            ],
        ],
    ];
    $currentMenu = request()->query('menu');
@endphp

<section id="sidebar-admin">
    <div class="flex min-h-screen flex-row bg-blue-600">
        <div class="flex-col hidden sm:flex sm:w-60 bg-base-200">
            <div class="flex p-4 bg-base-200">
                <h1 class="font-bold text-xl">
                    {{ GeneralHelper::getAppName() }}
                </h1>
            </div>
            <div class="flex gap-4">
                <ul class="flex flex-1 flex-col *:p-2 p-2">
                    @foreach ($ListMenu as $menu)
                        @if ($menu['type'] === 'divider')
                            <li class="divider divider-start my-2 text-sm px-4 text-gray-500">
                                {{ $UpperCase($menu['title']) }}
                            </li>
                        @endif
                        @if ($menu['type'] === 'item')
                            @php
                                // Check current Active menu item
                                $activeMenu = $currentMenu === $menu['name'];
                            @endphp
                            <li
                                class="flex gap-2 items-center rounded-xl cursor-pointer transition-all {{ $activeMenu ? 'bg-base-300' : 'hover:bg-base-300' }}">
                                <a href="?menu={{ $menu['name'] }}"
                                    class="w-full flex gap-2 item-center {{ $activeMenu ? 'font-bold' : '' }}">
                                    <x-utils.lucide-icon iconName="{{ $menu['icon'] }}" />
                                    {{ $UpperCase($menu['name']) }}
                                </a>
                            </li>
                        @endif
                        <li>
                            @if ($menu['type'] === 'dropdown')
                                @php
                                    $activeMenuDropdown = $Contains($currentMenu, $menu['title'] . '-');
                                @endphp
                                <div class="collapse {{ $activeMenuDropdown ? 'collapse-open' : '' }}">
                                    <input type="checkbox">
                                    <div
                                        class="collapse-title flex item-center gap-2 p-0 {{ $activeMenuDropdown ? 'font-bold' : '' }}">
                                        <x-utils.lucide-icon iconName="{{ $menu['icon'] }}" />
                                        {{ $UpperCase($menu['title']) }}
                                    </div>
                                    <div class="collapse-content">
                                        @foreach ($menu['children'] as $item)
                                            @php
                                                // Check Current Active Dropdown Item
                                                $activeItem = $currentMenu === $menu['title'] . '-' . $item['name'];
                                            @endphp
                                            <a class="flex gap-2 items-center rounded-xl cursor-pointer transition-all w-full {{ $activeItem ? 'bg-base-300' : 'hover:bg-base-300' }} p-2 {{ $activeItem ? 'font-bold' : '' }}"
                                                href="?menu={{ $menu['title'] }}-{{ $item['name'] }}">
                                                <x-utils.lucide-icon iconName="{{ $item['icon'] }}" />
                                                {{ $UpperCase($item['name']) }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>

            </div>
            <div class="flex p-4 bg-base-300 mt-auto items-center gap-4">
                <div class="flex flex-1 gap-4 items-center">
                    <img src="https://cdn-icons-png.flaticon.com/128/3135/3135715.png" alt="" class="w-10 h-10">
                    <div class="flex flex-col overflow-auto">
                        <h5 class="font-bold overflow-hidden overflow-ellipsis">{{ $UpperCase(auth()->user()->name) }}
                        </h5>
                        <p>{{ $UpperCase(auth()->user()->role) }}</p>
                    </div>
                </div>
                <div>
                    <div class="dropdown dropdown-top">
                        <div tabindex="0" role="button" class="btn btn-circle">
                            <x-utils.lucide-icon iconName="ellipsis-vertical" />
                        </div>
                        <ul tabindex="0" class="menu dropdown-content bg-base-200 w-56 rounded-xl border-2">
                            <div class="divider m-0"></div>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1 w-auto bg-base-100">
            {{ $slot }}
        </div>
    </div>
</section>
