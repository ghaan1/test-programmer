<x-master>
    <div x-data="product()" x-init="getCategories();
    getProducts()">
        <h1 class="text-2xl font-bold text-gray-800 mb-8">Daftar Produk</h1>

        <div class="mb-4 flex items-center justify-between">
            <div class="w-1/2 flex items-center space-x-4">
                <div class="w-1/2 relative">
                    <input type="text" x-model="searchTerm" @input="filterProducts()" placeholder="Cari barang..."
                        class="w-full px-4 py-2 border rounded-md pl-10" />
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
                <div class="w-1/4 relative">
                    <select x-model="selectedCategory" @change="filterProducts()"
                        class="w-full px-4 py-2 border rounded-md pl-10">
                        <option value="">Semua Kategori</option>
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id" x-text="category.name"></option>
                        </template>
                    </select>
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2">
                        <img src="{{ asset('assets/image/package.svg') }}" alt="Package Icon" class="w-4 h-4">
                    </span>
                </div>
            </div>
            <div class="w-1/2 flex justify-end space-x-4">
                <button class="bg-custom-greed-excel-button text-white px-4 py-2 rounded-md flex items-center">
                    <span class="mr-2">
                        <img src="{{ asset('assets/image/MicrosoftExcelLogo.png') }}" alt="Excel Icon" class="w-4 h-4">
                    </span>
                    Export Excel
                </button>
                <button class="bg-custom-red-button text-white px-4 py-2 rounded-md flex items-center"
                    @click="window.location.href = '{{ route('product.create') }}'">
                    <span class="mr-2">
                        <img src="{{ asset('assets/image/PlusCircle.png') }}" alt="Add Icon" class="w-4 h-4">
                    </span>
                    Tambah Produk
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 border text-center">No</th>
                        <th class="px-4 py-2 border text-center">Image</th>
                        <th class="px-4 py-2 border text-center">Nama Produk</th>
                        <th class="px-4 py-2 border text-center">Kategori Produk</th>
                        <th class="px-4 py-2 border text-center">Harga Beli (Rp)</th>
                        <th class="px-4 py-2 border text-center">Harga Jual (Rp)</th>
                        <th class="px-4 py-2 border text-center">Stok Produk</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <tr x-show="loading">
                        <td colspan="8" class="py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500 mx-auto"></div>
                        </td>
                    </tr>

                    <tr x-show="noData && !loading">
                        <td colspan="8" class="py-8 text-gray-600">Data tidak ditemukan</td>
                    </tr>

                    <template x-for="(product, index) in products" :key="product.id">
                        <tr>
                            <td class="border px-4 py-2"
                                x-text="(pagination.current_page - 1) * pagination.per_page + index + 1"></td>
                            <td class="border px-4 py-2">
                                <img :src="product.image" alt="" class="w-16 h-16 object-cover mx-auto">
                            </td>
                            <td class="border px-4 py-2" x-text="product.name"></td>
                            <td class="border px-4 py-2" x-text="product.category_name"></td>
                            <td class="border px-4 py-2" x-text="product.price"></td>
                            <td class="border px-4 py-2" x-text="product.selling_price"></td>
                            <td class="border px-4 py-2" x-text="product.stock"></td>
                            <td class="border px-4 py-2">
                                <button @click="updateProduct(product.id)" class="text-white px-2 py-2 rounded">
                                    <img src="{{ asset('assets/image/edit.png') }}" alt="Edit Icon" class="w-5 h-5">
                                </button>
                                <button @click="deleteProduct(product.id)" class="text-white px-2 py-2 rounded ml-2">
                                    <img src="{{ asset('assets/image/delete.png') }}" alt="Delete Icon" class="w-5 h-5">
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-between items-center">
            <p class="text-sm text-gray-600"
                x-text="'Show ' + pagination.total_data_page + ' from ' + pagination.total"></p>
            <div class="flex justify-end space-x-2">
                <button class="px-4 py-2 bg-gray-200 rounded-md" @click="goToPage(pagination.current_page - 1)"
                    :disabled="pagination.current_page === 1">
                    ‹
                </button>

                <template x-for="page in Array.from({ length: pagination.last_page }, (_, index) => index + 1)"
                    :key="page">
                    <button class="px-4 py-2 bg-gray-200 rounded-md"
                        :class="{ 'bg-gray-400': page === pagination.current_page }" @click="goToPage(page)">
                        <span x-text="page"></span>
                    </button>
                </template>

                <button class="px-4 py-2 bg-gray-200 rounded-md" @click="goToPage(pagination.current_page + 1)"
                    :disabled="pagination.current_page === pagination.last_page">
                    ›
                </button>
            </div>
        </div>
    </div>
</x-master>
