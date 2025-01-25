import { globalScript } from "./globalScript";
import Swal from "sweetalert2";
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";

export default function createProduct() {
    return {
        form: {
            category: "",
            name: "",
            buy_price: "",
            sell_price: "",
            stock: "",
            image: null,
        },
        errors: {},
        loading: false,
        categories: [],
        dropzone: null,

        async getCategories() {
            const global = new globalScript();
            try {
                const response = await global.getDataCategory();
                if (response.data.status === "success") {
                    this.categories = response.data.data.category;
                }
            } catch (error) {
                global.SwalErrorProses(error.message, "kategori produk");
            }
        },

        initDropzone() {
            let vm = this;

            vm.dropzone = new Dropzone(this.$refs.dropzone, {
                url: "#",
                autoProcessQueue: false,
                maxFiles: 1,
                acceptedFiles: "image/*",
                addRemoveLinks: true,
                dictRemoveFile: "Hapus",
                dictDefaultMessage:
                    "Drop file gambar di sini atau klik untuk memilih",
                init: function () {
                    let dz = this;
                    dz.on("addedfile", function (file) {
                        vm.form.image = file;
                    });
                    dz.on("removedfile", function (file) {
                        vm.form.image = null;
                    });
                },
            });
        },

        confirmCreateProduct() {
            Swal.fire({
                title: "Konfirmasi",
                text: "Yakin ingin menambahkan produk ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Simpan!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.createProduct();
                }
            });
        },

        async createProduct() {
            this.loading = true;
            this.errors = {};

            let formData = new FormData();
            formData.append("category", this.form.category);
            formData.append("name", this.form.name);
            formData.append("buy_price", this.form.buy_price);
            formData.append("sell_price", this.form.sell_price); // Pastikan sell_price terisi
            formData.append("stock", this.form.stock);

            if (this.form.image) {
                formData.append("image", this.form.image);
            }

            const global = new globalScript();

            try {
                const response = await global.createProduct(formData);
                if (response.data.status === "success") {
                    Swal.fire(
                        "Berhasil",
                        "Produk berhasil disimpan",
                        "success"
                    );

                    this.form = {
                        category: "",
                        name: "",
                        buy_price: "",
                        sell_price: "",
                        stock: "",
                        image: null,
                    };

                    if (this.dropzone) {
                        this.dropzone.removeAllFiles(true);
                    }
                } else {
                    Swal.fire(
                        "Gagal",
                        response.data.message || "Terjadi kesalahan",
                        "error"
                    );
                }
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    let errorData = error.response.data.errors;

                    Object.keys(errorData).forEach((key) => {
                        this.errors[key] = errorData[key][0];
                    });
                }
                Swal.fire(
                    "Error",
                    "Terjadi kesalahan saat menyimpan data",
                    "error"
                );
            } finally {
                this.loading = false;
            }
        },
    };
}
