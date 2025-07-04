@php
    $listMenu = [
        [
            'name' => 'Beranda',
            'type' => 'menu',
            'href' => '#hero',
        ],
        [
            'name' => 'Tentang',
            'type' => 'menu',
            'href' => '#about',
        ],
        [
            'name' => 'Regulasi',
            'type' => 'menu',
            'href' => '#regulation',
        ],
        [
            'name' => 'Kontak',
            'type' => 'menu',
            'href' => '#contact',
        ],
        [
            'name' => 'Buka Akun',
            'type' => 'role',
            'role' => '',
            'href' => route('login'),
        ],
        [
            'name' => 'Dashboard',
            'type' => 'role',
            'role' => 'nasabah',
            'href' => route('dashboard'),
        ],
        [
            'name' => 'Admin Dashboard',
            'type' => 'role',
            'role' => 'admin',
            'href' => route('admin-dashboard'),
        ],
        [
            'name' => 'Keuangan Dashboard',
            'type' => 'role',
            'role' => 'divisi-keuangan',
            'href' => '#',
        ],
    ];
@endphp

@props(['roleUser' => ''])

<section id="navbar" class="fixed w-full top-0 z-10">
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            <!-- Navbar -->
            <div class="navbar bg-base-300 w-full">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <x-utils.lucide-icon iconName="menu" />
                    </label>
                </div>
                <div class="mx-2 flex-1 px-2 font-bold">{{ GeneralHelper::getAppName() }}</div>
                <div class="hidden flex-none lg:block">
                    <ul class="menu menu-horizontal">
                        @foreach ($listMenu as $item)
                            @if ($item['type'] === 'role')
                                @if ($item['role'] === $roleUser)
                                    <li><a href="{{ $item['href'] }}"
                                            class="btn btn-sm btn-primary">{{ $item['name'] }}</a></li>
                                @endif
                            @endif
                            @if ($item['type'] === 'menu')
                                <li><a href="{{ $item['href'] }}">{{ $item['name'] }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-base-200 min-h-full w-1/2 p-4">
                @foreach ($listMenu as $item)
                    @if ($item['type'] === 'role')
                        @if ($item['role'] === $roleUser)
                            <li><a href="{{ $item['href'] }}" class="btn btn-sm btn-primary">{{ $item['name'] }}</a>
                            </li>
                        @endif
                    @endif
                    @if ($item['type'] === 'menu')
                        <li><a href="{{ $item['href'] }}">{{ $item['name'] }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</section>
