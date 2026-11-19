<header
    class="sticky top-0 z-60 flex w-full shrink-0 bg-[#022c22] xl:h-16 dark:bg-gray-950"
    x-data="{
        isApplicationMenuOpen: false,
        toggleApplicationMenu() {
            this.isApplicationMenuOpen = !this.isApplicationMenuOpen;
        }
    }">
    <div class="flex grow flex-col items-center justify-between xl:flex-row xl:px-6">
        <!-- Left side content -->
        <div
            class="flex w-full items-center justify-between gap-2 border-b border-white/10 px-3 py-2 sm:gap-4 xl:justify-normal xl:border-b-0 xl:px-0 xl:py-2 dark:border-gray-800">

            <!-- Logo -->
            <a href="/cliente" class="text-2xl font-bold text-white">PideYa</a>

            <!-- Application menu toggle (mobile only) -->
            <x-ui.button variant="ghost" size="icon" aria-label="Toggle application menu"
                class="text-white xl:hidden dark:text-gray-400" @click="toggleApplicationMenu()">
                <x-svg.horizontal-dots />
            </x-ui.button>

            <!-- Search (desktop only) -->
            <div class="hidden xl:block" x-data="{}"
                @keydown.window="if (($event.metaKey || $event.ctrlKey) && $event.key.toLowerCase() === 'k') { $event.preventDefault(); $refs.searchInput?.focus(); }">
                <form @submit.prevent>
                    <x-ui.field class="xl:w-107.5">
                        <x-ui.input-group class="border-white/15 bg-white/10 shadow-none dark:border-gray-800 dark:bg-white/3">
                            <x-ui.input-group.addon align="inline-start">
                                <x-svg.search class="size-5 text-white/70 dark:text-gray-400" />
                            </x-ui.input-group.addon>
                            <x-ui.input-group.input x-ref="searchInput" type="text" placeholder="Buscar comercio o producto..."
                                class="text-white placeholder:text-white/60 dark:text-white/90 dark:placeholder:text-white/30" />
                        </x-ui.input-group>
                    </x-ui.field>
                </form>
            </div>
        </div>

        <!-- Right side content -->
        <div :class="isApplicationMenuOpen ? 'flex' : 'hidden'"
            class="w-full items-center justify-between gap-4 px-5 py-4 shadow-theme-md xl:flex xl:justify-end xl:px-0 xl:shadow-none">
            <div class="2xsm:gap-3 flex items-center gap-2">
                <!-- Theme toggler -->
                <x-ui.button variant="outline" size="icon-lg" class="relative border-transparent bg-white/10 text-white shadow-none hover:bg-white/20 hover:text-white" aria-label="Toggle theme" @click="$store.theme.toggle()">
                    <x-svg.sun x-show="$store.theme.resolvedTheme === 'dark'" />
                    <x-svg.moon x-show="$store.theme.resolvedTheme !== 'dark'" />
                </x-ui.button>


                <!-- Carrito -->
                <x-ui.button variant="outline" size="icon-lg" class="relative border-transparent bg-white/10 text-white shadow-none hover:bg-white/20 hover:text-white" aria-label="Carrito">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l2.4 12.2a1 1 0 0 0 1 .8h9.7a1 1 0 0 0 1-.8L21 7H6" />
                        <circle cx="9" cy="20" r="1.3" />
                        <circle cx="18" cy="20" r="1.3" />
                    </svg>
                    <span class="absolute -top-1.5 -right-1.5 rounded-full bg-[#76BB20] px-1.5 text-xs font-bold text-white">2</span>
                </x-ui.button>

            </div>
            @auth
                <x-header.user-dropdown />
            @endauth

            @guest
                <a href="#" class="text-sm font-semibold text-white">Iniciar sesión</a>
                <a href="#" class="rounded-lg bg-[#459361] px-4 py-2 text-sm font-semibold text-white">Registrarse</a>
            @endguest
        </div>
    </div>
</header>
