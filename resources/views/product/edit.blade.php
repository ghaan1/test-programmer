<x-master>
    <div class="px-6 py-4" x-data="updateProduct()" x-init="init()">
        <div x-effect="form.buy_price ? (form.sell_price = Math.round(form.buy_price * 1.3)) : (form.sell_price = '')">
        </div>

        <nav class="text-gray-500 text-sm mb-4">
            <a href="{{ url('product') }}" class="hover:underline">Daftar Produk</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-semibold">Edit Produk</span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Produk</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc ml-4">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form @submit.prevent="confirmUpdateProduct" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-medium mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select x-model="form.category" class="border rounded w-full p-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        <template x-for="category in categories" :key="category.id">
                            <option :value="category.id" x-text="category.name"></option>
                        </template>
                    </select>
                    <div x-show="errors.category" class="text-red-600 text-sm mt-1">
                        <span x-text="errors.category"></span>
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1">
                        Nama Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="form.name" class="border rounded w-full p-2"
                        placeholder="Raket Badminton" required />
                    <div x-show="errors.name" class="text-red-600 text-sm mt-1">
                        <span x-text="errors.name"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block font-medium mb-1">
                        Harga Beli <span class="text-red-500">*</span>
                    </label>
                    <input type="number" x-model.number="form.buy_price" class="border rounded w-full p-2"
                        placeholder="100,000" min="0" step="1" required />
                    <div x-show="errors.buy_price" class="text-red-600 text-sm mt-1">
                        <span x-text="errors.buy_price"></span>
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1">
                        Harga Jual <span class="text-red-500">*</span>
                    </label>
                    <input type="text" x-model="form.sell_price"
                        class="border rounded w-full p-2 bg-gray-100 cursor-not-allowed" placeholder="130,000" disabled
                        required />
                    <div x-show="errors.sell_price" class="text-red-600 text-sm mt-1">
                        <span x-text="errors.sell_price"></span>
                    </div>
                </div>
                <div>
                    <label class="block font-medium mb-1">
                        Stok Barang <span class="text-red-500">*</span>
                    </label>
                    <input type="number" x-model.number="form.stock" class="border rounded w-full p-2" placeholder="35"
                        min="0" step="1" required />
                    <div x-show="errors.stock" class="text-red-600 text-sm mt-1">
                        <span x-text="errors.stock"></span>
                    </div>
                </div>
            </div>

            <div>
                <label class="block font-medium mb-1">
                    Upload Image
                </label>
                <div x-ref="dropzone" class="border-2 border-dashed border-gray-300 rounded p-6 w-full">
                    <p class="text-gray-400 text-sm">
                        Drop file gambar di sini atau klik untuk memilih
                    </p>
                </div>
                <div x-show="errors.image" class="text-red-600 text-sm mt-1">
                    <span x-text="errors.image"></span>
                </div>
            </div>

            <div class="mt-6 flex space-x-4">
                <a href="{{ url('product') }}" class="px-4 py-2 rounded border hover:bg-gray-100">
                    Batalkan
                </a>
                <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-master>
