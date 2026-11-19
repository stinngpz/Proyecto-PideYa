<x-ui.dropdown-menu>
    <x-ui.dropdown-menu.trigger class="dropdown-toggle flex items-center text-white dark:text-gray-400">

        <span class="me-1 block text-sm font-medium">Mi Perfil</span>

        <x-svg.chevron-down class="size-5 text-white duration-200 dark:text-gray-400" x-bind:class="open ? 'rotate-180' : 'rotate-0'" />
    </x-ui.dropdown-menu.trigger>

    <x-ui.dropdown-menu.content align="end" :side-offset="12" class="w-65 p-3">
        <div class="px-3 py-2">
            <span class="block text-sm font-medium text-gray-700 dark:text-gray-400">Mi cuenta</span>
            <span class="mt-0.5 block text-xs text-gray-500 dark:text-gray-400">cliente@gmail.com</span>
        </div>

        <x-ui.dropdown-menu.separator />

        <x-ui.dropdown-menu.item to="/profile">
            <x-svg.user-circle class="size-6" />
            {{ __('Editar Perfil') }}
        </x-ui.dropdown-menu.item>

        <x-ui.dropdown-menu.item to="/profile">
            <x-svg.gear class="size-6" />
            {{ __('Configuración de cuenta') }}
        </x-ui.dropdown-menu.item>

        <x-ui.dropdown-menu.item to="/profile">
            <x-svg.info-circle class="size-6" />
            {{ __('Soporte') }}
        </x-ui.dropdown-menu.item>    
    <x-ui.dropdown-menu.separator />

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
        <x-ui.dropdown-menu.item variant="destructive" x-on:click.capture="document.getElementById('logout-form').submit()">
            <x-svg.log-out />
            {{ __('Cerrar sesión') }}
        </x-ui.dropdown-menu.item>
    </x-ui.dropdown-menu.content>
</x-ui.dropdown-menu>
