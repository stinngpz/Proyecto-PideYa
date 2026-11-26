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

            <!-- Logo (escritorio) -->
            <a href="{{ route('panel') }}" class="hidden shrink-0 text-2xl font-bold text-white xl:block xl:w-[226px]">PideYa</a>

            <!-- Mobile sidebar toggle (below xl) -->
            <x-ui.button variant="outline" size="icon" class="border-transparent bg-white/10 text-white shadow-none hover:bg-white/20 hover:text-white xl:hidden lg:size-11 dark:text-gray-400"
                aria-label="Mostrar menú" @click.stop="$store.sidebar.toggleMobileOpen()">
                <x-svg.x x-show="$store.sidebar.isMobileOpen" class="size-6" />
                <x-svg.menu-two x-show="!$store.sidebar.isMobileOpen" class="size-auto! rtl:-scale-x-100" />
            </x-ui.button>

            <!-- Logo (celular) -->
            <a href="{{ route('panel') }}" class="text-2xl font-bold text-white xl:hidden">PideYa</a>

            <!-- Application menu toggle (mobile only) -->
            <x-ui.button variant="ghost" size="icon" aria-label="Abrir menú"
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
                <x-ui.button variant="outline" size="icon-lg" class="relative border-transparent bg-white/10 text-white shadow-none hover:bg-white/20 hover:text-white" aria-label="Cambiar tema" @click="$store.theme.toggle()">
                    <x-svg.sun x-show="$store.theme.resolvedTheme === 'dark'" />
                    <x-svg.moon x-show="$store.theme.resolvedTheme !== 'dark'" />
                </x-ui.button>

            </div>
            <x-header.user-dropdown />
        </div>
    </div>
</header>
