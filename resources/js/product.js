import { globalScript } from "./globalScript";

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
