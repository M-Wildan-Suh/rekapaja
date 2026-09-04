<nav class="sticky top-0 z-50 border-b border-gray-900 bg-black px-4">
    <div class="mx-auto flex h-16 w-full max-w-xl items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center" aria-label="Dashboard">
            <div class="h-9 w-9">
                <img src="{{ asset('assets/images/logo.webp') }}" alt="RekapAja">
            </div>
        </a>

        <div x-data="{
            open: false,
            iconVisible: true,
            toggle() {
                this.iconVisible = false;
                window.setTimeout(() => {
                    this.open = !this.open;
                    this.iconVisible = true;
                }, 150);
            },
            close() {
                if (!this.open) return;

                this.iconVisible = false;
                window.setTimeout(() => {
                    this.open = false;
                    this.iconVisible = true;
                }, 150);
            }
        }" class="relative">
            <button type="button" @click="toggle()" @keydown.escape.window="close()"
                :aria-expanded="open.toString()" aria-controls="dashboard-menu" :aria-label="open ? 'Tutup menu' : 'Buka menu'"
                :class="open ? 'bg-[#b95300]' : 'bg-[#ff7100] hover:bg-[#b95300]'"
                class="inline-flex w-8 aspect-square items-center justify-center rounded-md p-1.5 text-white duration-300">
                <svg x-cloak x-show="iconVisible" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="scale-0" x-transition:enter-end="scale-100"
                    x-transition:leave="transition ease-in duration-150" x-transition:leave-start="scale-100"
                    x-transition:leave-end="scale-0" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                    <path x-show="!open" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="open" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div id="dashboard-menu" x-cloak x-show="open" @click.outside="close()"
                x-transition:enter="transition ease-out duration-150"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-52 overflow-hidden rounded-md bg-white py-1 text-sm shadow-lg ring-1 ring-black/5">
                <div class="border-b border-gray-100 px-4 py-3">
                    <p class="truncate font-medium text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>

                <a href="{{ route('dashboard') }}"
                    class="block px-4 py-2 {{ request()->routeIs('dashboard') ? 'bg-orange-50 font-semibold text-[#b95300]' : 'text-gray-700 hover:bg-gray-100' }}">
                    Dashboard
                </a>

                @if (Auth::user()->role === 'admin' || (Auth::user()->role === 'premium' && Auth::user()->premium_type === 'lifetime') || (Auth::user()->role === 'premium' && Carbon\Carbon::now()->lessThanOrEqualTo(Carbon\Carbon::parse(Auth::user()->expired))))
                    <a href="{{ route('rekap.index') }}"
                        class="block px-4 py-2 {{ request()->routeIs('rekap.index', 'rekap.create', 'rekap.show') ? 'bg-orange-50 font-semibold text-[#b95300]' : 'text-gray-700 hover:bg-gray-100' }}">
                        Rekap
                    </a>
                @endif

                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('user.index') }}"
                        class="block px-4 py-2 {{ request()->routeIs('user.index', 'user.create', 'user.show') ? 'bg-orange-50 font-semibold text-[#b95300]' : 'text-gray-700 hover:bg-gray-100' }}">
                        User
                    </a>
                    <a href="{{ route('template.index') }}"
                        class="block px-4 py-2 {{ request()->routeIs('template.index', 'template.create', 'template.show') ? 'bg-orange-50 font-semibold text-[#b95300]' : 'text-gray-700 hover:bg-gray-100' }}">
                        Template
                    </a>
                    <a href="{{ route('access.index') }}"
                        class="block px-4 py-2 {{ request()->routeIs('access.index', 'access.create', 'access.show') ? 'bg-orange-50 font-semibold text-[#b95300]' : 'text-gray-700 hover:bg-gray-100' }}">
                        Akses
                    </a>
                    <a href="{{ route('package.index') }}"
                        class="block px-4 py-2 {{ request()->routeIs('package.index', 'package.create', 'package.show') ? 'bg-orange-50 font-semibold text-[#b95300]' : 'text-gray-700 hover:bg-gray-100' }}">
                        Premium
                    </a>
                @endif

                <div class="my-1 border-t border-gray-100"></div>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
