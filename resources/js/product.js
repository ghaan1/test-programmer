import { globalScript } from "./globalScript";
import Swal from "sweetalert2";

export default function product() {
    return {
        // Daftar produk & pagination
        products: [],
        searchTerm: "",
        selectedCategory: "",
        categories: [],
        loading: true,
        noData: false,
        pagination: {
            current_page: 1,
            per_page: 0,
            total: 0,
            last_page: 1,
            total_data_page: 0,
        },

        // Contoh state form untuk create
        form: {
            fk_product_category: "",
            name: "",
            price: "",
            selling_price: "",
            stock: "",
        },

        // Ambil list kategori
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

        // Ambil list produk
        async getProducts(page = 1) {
            this.loading = true;
            this.noData = false;
            const global = new globalScript();
            try {
                const response = await global.getDataProduct(
                    page,
                    this.searchTerm,
                    this.selectedCategory
                );

                if (response.data.status === "success") {
                    this.products = response.data.data.product;
                    this.pagination = response.data.data.pagination;
                }
            } catch (error) {
                this.noData = true;
                this.products = [];
                this.pagination = {
                    current_page: 1,
                    per_page: 0,
                    total: 0,
                    last_page: 1,
                    total_data_page: 0,
                };
            } finally {
                this.loading = false;
            }
        },

        // Buat fungsi create product
        async createProduct() {
            // Contoh confirm pakai Swal
            const confirm = await Swal.fire({
                title: "Konfirmasi",
                text: "Yakin menyimpan data produk ini?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, Simpan",
                cancelButtonText: "Batal",
            });

            if (!confirm.isConfirmed) {
                return; // Batal
            }

            // Panggil globalScript
            const global = new globalScript();
            try {
                // Contoh panggil method saveProduct (Anda buat sendiri di globalScript)
                const response = await global.saveProduct(this.form);

                if (response.data.status === "success") {
                    Swal.fire(
                        "Berhasil",
                        "Produk berhasil disimpan",
                        "success"
                    );
                    // Reset form
                    this.form = {
                        fk_product_category: "",
                        name: "",
                        price: "",
                        selling_price: "",
                        stock: "",
                    };
                    // Refresh data
                    this.getProducts();
                } else {
                    Swal.fire(
                        "Gagal",
                        response.data.message || "Terjadi kesalahan",
                        "error"
                    );
                }
            } catch (error) {
                Swal.fire(
                    "Error",
                    error.response?.data?.message || error.message,
                    "error"
                );
            }
        },

        // Fungsi filtering & pagination
        filterProducts() {
            this.getProducts(1);
        },

        goToPage(pageNumber) {
            if (pageNumber >= 1 && pageNumber <= this.pagination.last_page) {
                this.pagination.current_page = pageNumber;
                this.getProducts(pageNumber);
            }
        },

        resetFilters() {
            this.searchTerm = "";
            this.selectedCategory = "";
            this.getProducts(1);
        },
    };
}
