import Alpine from "alpinejs";

export default function setupLogin() {
    document.addEventListener("alpine:init", () => {
        Alpine.data("passwordToggle", () => ({
            showPassword: false,
            togglePasswordVisibility() {
                this.showPassword = !this.showPassword;
            },
        }));
    });
}
