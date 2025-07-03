@php
    $ListMenu = [
        [
            'title' => 'main-menu',
            'type' => 'divider',
        ],
        [
            'icon' => 'layout-dashboard',
            'title' => 'dashboard',
            'route' => '/admin',
            'type' => 'item',
        ],
        [
            'title' => 'master-Data',
            'type' => 'divider',
        ],
        [
            'icon' => 'user-round',
            'title' => 'Data akun',
            'route' => '/admin/data-user',
            'type' => 'item',
        ],
        [
            'icon' => 'banknote-arrow-down',
            'title' => 'Pendanaan',
            'route' => '/admin/pendanaan',
            'type' => 'item',
        ],
        [
            'title' => 'Grup',
            'icon' => 'book-user',
            'route' => 'grup',
            'type' => 'dropdown',
            'children' => [
                [
                    'icon' => 'users',
                    'title' => 'Data grup',
                    'route' => '/admin/data-grup',
                ],
                [
                    'icon' => 'file-user',
                    'title' => 'Data anggota grup',
                    'route' => '/admin/data-anggota-grup',
                ],
            ],
        ],
        [
            'title' => 'Transaksi',
            'icon' => 'arrow-left-right',
            'route' => 'transaksi',
            'type' => 'dropdown',
            'children' => [
                [
                    'icon' => 'hand-coins',
                    'title' => 'Pinjaman',
                    'route' => '/admin/transaksi-pinjaman',
                ],
                [
                    'icon' => 'coins',
                    'title' => 'Cicilan Pinjaman',
                    'route' => '/admin/transaksi-cicilan-pinjaman',
                ],
            ],
        ],
        [
            'title' => 'Laporan',
            'icon' => 'book-text',
            'route' => 'laporan',
            'type' => 'dropdown',
            'children' => [
                [
                    'icon' => 'hand-coins',
                    'title' => 'Pinjaman',
                    'route' => '/admin/laporan-pinjaman',
                ],
                [
                    'icon' => 'users',
                    'title' => 'Data Grup',
                    'route' => '/admin/laporan-data-grup',
                ],
            ],
        ],
    ];
    $currentRoute = GeneralHelper::currentRouteName();
@endphp

@props(['title' => 'Header content', 'leftItem' => false, 'routeName' => ''])

<section id="sidebar-admin">
    <aside class="flex min-h-screen flex-row w-screen overflow-hidden">
        <div class="flex-col hidden sm:flex sm:w-64 bg-base-200 max-h-screen overflow-y-auto overflow-x-hidden">
            <div class="p-4 bg-base-300 sticky top-0">
                <h1 class="font-bold text-xl">
                    {{ GeneralHelper::getAppName() }}
                </h1>
            </div>
            <div class="flex gap-4">
                <ul class="flex flex-1 flex-col *:p-2 p-2">
                    @foreach ($ListMenu as $menu)
                        {{-- Type Divider --}}
                        @if ($menu['type'] === 'divider')
                            <li class="divider divider-start my-2 text-sm px-4 text-gray-500">
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
                                    $activeMenuDropdown = GeneralHelper::Contains($currentRoute, $menu['route']);
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
                                                $activeMenuItem = GeneralHelper::Equals($currentRoute, $item['route']);
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
                </ul>
            </div>
            <div class="flex p-4 bg-base-300 mt-auto items-center gap-4 sticky bottom-0">
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
        <div class="flex flex-col flex-1 overflow-x-hidden bg-base-100 w-full">
            <x-ui.container>
                <x-ui.navbar-admin title="{{ $title }}" :leftItem="$leftItem" :routeName="$routeName" />
                {{ $slot }}
            </x-ui.container>
        </div>
    </aside>
</section>
