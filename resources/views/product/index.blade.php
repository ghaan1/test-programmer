<x-master>
    <div x-data="product()" x-init="getProducts()">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Daftar Produk</h1>
        <p class="text-gray-600" x-show="loading">Loading...</p>

        <!-- Search Bar dan Filter -->
        <div class="mb-4 flex items-center space-x-4">
            <div class="flex-1">
                <input type="text" x-model="searchTerm" @input="filterProducts()" placeholder="Cari barang..."
                    class="w-full px-4 py-2 border rounded-md" />
            </div>
            <div class="w-1/4">
                <select x-model="selectedCategory" @change="filterProducts()"
                    class="w-full px-4 py-2 border rounded-md">
                    <option value="">Semua Kategori</option>
                    <template x-for="category in categories" :key="category.id">
                        <option :value="category.id" x-text="category.name"></option>
                    </template>
                </select>
            </div>
            <button class="bg-green-500 text-white px-4 py-2 rounded-md">Export Excel</button>
            <button class="bg-red-500 text-white px-4 py-2 rounded-md">Tambah Produk</button>
        </div>

        <!-- Tabel Produk -->
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Image</th>
                    <th class="px-4 py-2 border">Nama Produk</th>
                    <th class="px-4 py-2 border">Kategori Produk</th>
                    <th class="px-4 py-2 border">Harga Beli (Rp)</th>
                    <th class="px-4 py-2 border">Harga Jual (Rp)</th>
                    <th class="px-4 py-2 border">Stok Produk</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(product, index) in filteredProducts" :key="product.id">
                    <tr>
                        <td class="border px-4 py-2" x-text="index + 1"></td>
                        <td class="border px-4 py-2">
                            <img :src="product.image" alt="" class="w-16 h-16 object-cover">
                        </td>
                        <td class="border px-4 py-2" x-text="product.name"></td>
                        <td class="border px-4 py-2" x-text="product.category_name"></td>
                        <td class="border px-4 py-2" x-text="product.price"></td>
                        <td class="border px-4 py-2" x-text="product.selling_price"></td>
                        <td class="border px-4 py-2" x-text="product.stock"></td>
                        <td class="border px-4 py-2">
                            <button @click="updateProduct(product.id)"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Edit</button>
                            <button @click="deleteProduct(product.id)"
                                class="bg-red-500 text-white px-4 py-2 rounded ml-2">Delete</button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            <p class="text-sm text-gray-600">Show 10 from 51</p>
            <div class="flex justify-center space-x-2">
                <button class="px-4 py-2 bg-gray-200 rounded-md">‹</button>
                <button class="px-4 py-2 bg-gray-200 rounded-md">1</button>
                <button class="px-4 py-2 bg-gray-200 rounded-md">2</button>
                <button class="px-4 py-2 bg-gray-200 rounded-md">...</button>
                <button class="px-4 py-2 bg-gray-200 rounded-md">6</button>
                <button class="px-4 py-2 bg-gray-200 rounded-md">›</button>
            </div>
        </div>
    </div>
</x-master>
