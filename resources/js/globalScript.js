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

    getDataCategory() {
        const promise = axios.get(`/get/data-product-category`);
        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }

    getDataProduct() {
        const promise = axios.get(`/get/data-product`);
        const dataPromise = promise.then((response) => response);
        return dataPromise;
    }
}
