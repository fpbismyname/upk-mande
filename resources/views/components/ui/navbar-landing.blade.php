<section id="navbar" class="fixed w-full top-0 z-10">
    <nav x-data="{
        scrolled: false,
        checkScroll() {
            this.scrolled = window.scrollY > 100;
        }
    }" x-init="checkScroll();
    window.addEventListener('scroll', () => checkScroll());" :class="scrolled ? 'backdrop-brightness-90' : 'bg-transparent'"
        class="flex flex-row flex-1 backdrop-blur-xl bg-transparent transition-all">
        <div class="container mx-auto p-4">
            <div class="flex flex-row flex-1 items-center">
                <div class="flex">
                    <label for="navbar" class="font-bold"><a
                            href="#">{{ GeneralHelper::getAppName() }}</a></label>
                </div>
                <div class="flex-none ms-auto">
                    <ul class="flex gap-6 items-center">
                        <li><a href="#hero">Beranda</a></li>
                        <li><a href="#about">Tentang</a></li>
                        <li><a href="#regulation">Teregulasi</a></li>
                        <li><a href="#contact">Kontak</a></li>
                        @php
                            $userId = auth()->user()->id_user ?? '';
                            $user = App\Models\User::with('role_user')->find($userId);
                            $currentRole = $user->role_user->nama_role ?? '';
                        @endphp
                        @auth
                            @if ($currentRole === 'admin')
                                <li><a href="{{ route('admin-dashboard') }}" class="btn btn-sm btn-secondary">Admin
                                        Dashboard</a></li>
                            @elseif ($currentRole === 'member')
                                <li><a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('admin-dashboard') }}" class="btn btn-sm btn-secondary">Dashboard
                                        {{ $currentRole }}</a>
                                </li>
                            @endif
                        @else
                            <li><a href="{{ route('login') }}" class="btn btn-sm btn-secondary">Buka akun</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</section>
