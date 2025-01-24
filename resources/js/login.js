import Alpine from "alpinejs";
import Swal from "sweetalert2";
import { globalScript } from "./globalScript";

export default function setupLogin() {
    document.addEventListener("alpine:init", () => {
        if (localStorage.getItem("token") && window.location.pathname === "/") {
            window.location.href = "/product";
            return;
        }
        const global = new globalScript();

        Alpine.data("setupLogin", () => ({
            email: "",
            password: "",
            showPassword: false,

            togglePasswordVisibility() {
                this.showPassword = !this.showPassword;
            },

            async submitLogin() {
                try {
                    global.SwalLoading("proses", "login");

                    const response = await global.login(
                        this.email,
                        this.password
                    );

                    if (
                        response.data.status === "success" &&
                        response.data.data.token
                    ) {
                        localStorage.setItem("token", response.data.data.token);
                        global.SwalSuccess(null, "Login", "dilakukan");
                        setTimeout(() => {
                            Swal.close();
                            window.location.href = "/product";
                        }, 500);
                    }
                } catch (error) {
                    global.SwalError(
                        "Gagal login, silakan coba lagi.",
                        "Login",
                        "melakukan"
                    );
                } finally {
                    this.email = "";
                    this.password = "";
                }
            },
        }));
    });
}
