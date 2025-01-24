import Alpine from "alpinejs";
import Swal from "sweetalert2";
import { globalScript } from "./globalScript";

export default function sidebar() {
    const global = new globalScript();

    return {
        isCollapsed: false,
        isActive: "",
        hoveredItem: "",
        isInitialized: false,

        toggleSidebar() {
            this.isCollapsed = !this.isCollapsed;
        },

        setHovered(item) {
            this.hoveredItem = item;
        },

        resetHovered() {
            this.hoveredItem = "";
        },

        async logout() {
            try {
                global.SwalLoading("logging out", "user");

                const response = await global.logout();
                if (response.data.status === "success") {
                    localStorage.removeItem("token");

                    global.SwalSuccess(null, "Logout", "dilakukan");

                    setTimeout(() => {
                        Swal.close();
                        window.location.href = "/";
                    }, 500);
                } else {
                    global.SwalError(
                        "Gagal logout, silakan coba lagi.",
                        "Logout",
                        "melakukan"
                    );
                }
            } catch (error) {
                global.SwalError(
                    "Gagal logout, silakan coba lagi.",
                    "Logout",
                    "melakukan"
                );
            }
        },

        init() {
            this.isInitialized = true;
        },
    };
}
