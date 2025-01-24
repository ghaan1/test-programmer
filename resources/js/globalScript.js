import Swal from "sweetalert2";
import axios from "axios";

export class globalScript {
    constructor() {}

    SwalLoading(proses, name) {
        Swal.fire({
            title: "Loading...",
            text: `Sedang ${proses} ${name}`,
            icon: "info",
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    }

    SwalSuccess(message, name, proses) {
        Swal.fire({
            title: "Berhasil!",
            text: message || `${name} berhasil ${proses}`,
            icon: "success",
            confirmButtonText: "OK",
            customClass: {
                confirmButton:
                    "bg-primary2-500 hover:bg-primary2-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary2-500 dark:hover:bg-primary2-700 dark:focus:ring-primary-800",
            },
        });
    }

    SwalError(message, name, proses) {
        Swal.fire({
            title: "Gagal!",
            text: message || `Terjadi kesalahan saat ${proses} ${name}`,
            icon: "error",
            confirmButtonText: "OK",
            customClass: {
                confirmButton:
                    "bg-primary2-500 hover:bg-primary2-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary2-500 dark:hover:bg-primary2-700 dark:focus:ring-primary-800",
            },
        });
    }

    SwalErrorProses(message, name) {
        Swal.fire({
            title: "Gagal!",
            text: message || `Gagal memuat data ${name}`,
            icon: "error",
            confirmButtonText: "OK",
        });
    }

    login(email, password) {
        const promise = axios.post("/api/login", {
            email,
            password,
        });

        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }

    logout() {
        const token = localStorage.getItem("token");
        if (!token) {
            this.SwalError(
                "Token tidak ditemukan. Anda harus login terlebih dahulu.",
                "Logout",
                "melakukan"
            );
            return;
        }

        const promise = axios.post(
            "/api/logout",
            {},
            {
                headers: {
                    Authorization: `Bearer ${token}`,
                },
            }
        );

        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }

    getDataCategory() {
        const token = localStorage.getItem("token");
        if (!token) {
            this.SwalError(
                "Token tidak ditemukan. Anda harus login terlebih dahulu.",
                "Logout",
                "melakukan"
            );
            return;
        }
        const promise = axios.get(`api/get/data-product-category`, {
            headers: {
                Authorization: `Bearer ${token}`,
                "Content-Type": "application/json",
                Accept: "application/json",
            },
        });
        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }

    getDataProduct(page = 1, searchTerm = "", category = "") {
        const token = localStorage.getItem("token");
        if (!token) {
            this.SwalError(
                "Token tidak ditemukan. Anda harus login terlebih dahulu.",
                "Logout",
                "melakukan"
            );
            return;
        }
        const promise = axios.get(`api/get/data-product`, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
            params: {
                page: page,
                searchTerm: searchTerm,
                category: category,
            },
        });
        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }

    saveProduct(data) {
        const token = localStorage.getItem("token");
        // Tergantung endpoint
        const promise = axios.post("/api/product/store", data, {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        });

        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }
}
