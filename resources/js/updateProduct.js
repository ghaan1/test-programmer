import { globalScript } from "./globalScript";
import Swal from "sweetalert2";
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";

Dropzone.autoDiscover = false;

function getFileName(path) {
    return path.split("/").pop();
}

export default function updateProduct() {
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
        productId: "",
        existingImageUrl: "",

        global: new globalScript(),

        async init() {
            await this.getCategories();
            await this.loadProductData();
            this.initDropzone();
        },

        async getCategories() {
            try {
                const response = await this.global.getDataCategory();
                if (response.data.status === "success") {
                    this.categories = response.data.data.category;
                }
            } catch (error) {
                this.global.SwalErrorProses(error.message, "kategori produk");
            }
        },

        initDropzone() {
            let vm = this;

            if (this.dropzone) {
                this.dropzone.destroy();
                this.dropzone = null;
            }

            this.dropzone = new Dropzone(this.$refs.dropzone, {
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

                        if (dz.files[1]) {
                            dz.removeFile(dz.files[0]);
                        }
                    });

                    dz.on("removedfile", function (file) {
                        vm.form.image = null;
                    });

                    if (vm.existingImageUrl) {
                        let mockFile = {
                            name: getFileName(vm.existingImageUrl),
                            size: 12345,
                            type: "image/jpeg",
                        };
                        dz.emit("addedfile", mockFile);
                        dz.emit("thumbnail", mockFile, vm.existingImageUrl);
                        dz.emit("complete", mockFile);
                        dz.files.push(mockFile);
                    }
                },
            });
        },

        async loadProductData() {
            const urlParts = window.location.pathname.split("/");
            this.productId = urlParts[urlParts.length - 1];

            try {
                const response = await this.global.getDataProductDetail(
                    this.productId
                );
                if (response.data.status === "success") {
                    const product = response.data.data.product;
                    this.form = {
                        category: product.fk_product_category,
                        name: product.name,
                        buy_price: product.price,
                        sell_price: product.selling_price,
                        stock: product.stock,
                        image: null,
                    };
                    this.existingImageUrl = product.image
                        ? `/storage/images/${getFileName(product.image)}`
                        : "";
                } else {
                    this.global.SwalError(
                        "Gagal memuat data produk.",
                        "Produk",
                        "memuat"
                    );
                }
            } catch (error) {
                this.global.SwalError(
                    "Terjadi kesalahan saat memuat data produk.",
                    "Produk",
                    "memuat"
                );
            }
        },

        confirmUpdateProduct() {
            Swal.fire({
                title: "Konfirmasi",
                text: "Yakin ingin mengupdate produk ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Update!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.updateProductData();
                }
            });
        },

        async updateProductData() {
            this.loading = true;
            this.errors = {};

            let formData = new FormData();
            formData.append("category", this.form.category);
            formData.append("name", this.form.name);
            formData.append("buy_price", this.form.buy_price);
            formData.append("sell_price", this.form.sell_price);
            formData.append("stock", this.form.stock);

            if (this.form.image && this.form.image instanceof File) {
                formData.append("image", this.form.image);
            }

            try {
                const response = await this.global.updateProduct(
                    this.productId,
                    formData
                );
                if (response.data.status === "success") {
                    this.global.SwalSuccess(
                        "Produk berhasil diupdate",
                        "Produk",
                        "diupdate"
                    );
                    window.location.href = "/product";
                } else {
                    this.global.SwalError(
                        response.data.message || "Terjadi kesalahan",
                        "Update",
                        "mengupdate"
                    );
                }
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    let errorData = error.response.data.errors;
                    Object.keys(errorData).forEach((key) => {
                        this.errors[key] = errorData[key][0];
                    });
                }
                this.global.SwalError(
                    "Terjadi kesalahan saat mengupdate produk.",
                    "Update",
                    "mengupdate"
                );
            } finally {
                this.loading = false;
            }
        },
    };
}
