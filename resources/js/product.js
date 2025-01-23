import { globalScript } from "./globalScript";

export default function product() {
    return {
        products: [],
        filteredProducts: [],
        searchTerm: "",
        selectedCategory: "",
        categories: [],
        loading: true,

        async getProducts() {
            this.loading = true;
            const global = new globalScript();
            try {
                const response = await global.getDataProduct();
                this.products = response.data.data.product;
                this.filteredProducts = this.products; // Default display all products
                console.log("Products loaded:", this.products);

                // Get categories (assuming it's an API endpoint or static data)
                const categoryResponse = await global.getDataCategory();
                this.categories = categoryResponse.data.data.categories;
            } catch (error) {
                console.error("Error loading products:", error);
                this.products = [];
                this.filteredProducts = [];
            } finally {
                this.loading = false;
            }
        },

        filterProducts() {
            this.filteredProducts = this.products.filter((product) => {
                const matchesSearch = product.name
                    .toLowerCase()
                    .includes(this.searchTerm.toLowerCase());
                const matchesCategory = this.selectedCategory
                    ? product.category_id === this.selectedCategory
                    : true;
                return matchesSearch && matchesCategory;
            });
        },

        deleteProduct(id) {
            // Logic for deleting a product
            console.log(`Delete product with ID: ${id}`);
        },

        updateProduct(id) {
            // Logic for updating a product
            console.log(`Update product with ID: ${id}`);
        },
    };
}
