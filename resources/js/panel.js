import Alpine from 'alpinejs';
import registerUi from './panel/ui';

window.Alpine = Alpine;
// Register Alpine.js components before initializing
Alpine.data("dropdown", () => ({
    open: false,
    toggle() {
        this.open = !this.open;
        if (this.open) this.position();
    },
    position() {
        this.$nextTick(() => {
            const button = this.$el;
            const dropdown = this.$refs.dropdown;
            const rect = button.getBoundingClientRect();

            // Apply initial styles to ensure measurement is possible
            dropdown.style.position = "fixed";
            dropdown.style.zIndex = "999";

            const isRtl = document.documentElement.getAttribute("dir") === "rtl";
            if (isRtl) {
                dropdown.style.left = `${rect.left}px`;
                dropdown.style.right = "auto";
            } else {
                dropdown.style.right = `${window.innerWidth - rect.right - 13}px`;
                dropdown.style.left = "auto";
            }

            const dropdownHeight = Math.max(dropdown.offsetHeight, 0);
            const spaceBelow = window.innerHeight - rect.bottom;
            const spaceAbove = rect.top;

            if (spaceBelow < dropdownHeight && spaceAbove > spaceBelow) {
                dropdown.style.top = `${rect.top - dropdownHeight}px`;
            } else {
                dropdown.style.top = `${rect.bottom}px`;
            }
        });
    },
    init() {
        this.$watch("open", (value) => {
            if (value) this.position();
        });
    },
}));


registerUi(Alpine);
Alpine.start();
