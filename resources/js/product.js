import { globalScript } from "./globalScript";
import Swal from "sweetalert2";

export default function product() {
    return {
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

        global: new globalScript(),

        async init() {
            await this.getCategories();
            await this.getProducts();
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

        async getProducts(page = 1) {
            this.loading = true;
            this.noData = false;
            try {
                const response = await this.global.getDataProduct(
                    page,
                    this.searchTerm,
                    this.selectedCategory
                );

                if (response.data.status === "success") {
                    this.products = response.data.data.product;
                    this.pagination = response.data.data.pagination;
                    this.noData = this.products.length === 0;
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

        async deleteProduct(id) {
            Swal.fire({
                title: "Konfirmasi",
                text: "Yakin ingin menghapus produk ini?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    try {
                        const response = await this.global.deleteProduct(id);
                        if (response.data.status === "success") {
                            this.global.SwalSuccess(
                                "Produk berhasil dihapus",
                                "Produk",
                                "dihapus"
                            );
                            this.getProducts(this.pagination.current_page);
                        } else {
                            this.global.SwalError(
                                response.data.message || "Terjadi kesalahan",
                                "Delete",
                                "menghapus"
                            );
                        }
                    } catch (error) {
                        this.global.SwalError(
                            "Terjadi kesalahan saat menghapus produk.",
                            "Delete",
                            "menghapus"
                        );
                    }
                }
            });
        },

        async exportExcel() {
            try {
                const params = new URLSearchParams();
                if (this.searchTerm) {
                    params.append("searchTerm", this.searchTerm);
                }
                if (this.selectedCategory) {
                    params.append("category", this.selectedCategory);
                }

                const url = `/product/export?${params.toString()}`;

                window.open(url, "_blank");
            } catch (error) {
                this.global.SwalError(
                    "Terjadi kesalahan saat mengekspor data.",
                    "Export",
                    "mengekspor"
                );
            }
        },
    };
}
