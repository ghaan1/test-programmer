<x-master>
    <div class="px-6 py-4" x-data="createProduct()" x-init="initDropzone()">

        <!-- Breadcrumb atau judul halaman -->
        <nav class="text-gray-500 text-sm mb-4">
            <a href="{{ url('product') }}" class="hover:underline">Daftar Produk</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800 font-semibold">Tambah Produk</span>
        </nav>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Produk</h1>

        <!-- Notifikasi sukses atau error -->
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

        <form @submit.prevent="confirmCreate" class="space-y-4">
            <!-- Kategori & Nama Barang -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pilih Kategori -->
                <div>
                    <label class="block font-medium mb-1">Kategori</label>
                    <select x-model="form.fk_product_category" class="border rounded w-full p-2">
                        <option value="">-- Pilih Kategori --</option>

                        <!-- Kalau Anda lempar data kategori dari controller -->
                        @isset($categories)
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                <!-- Nama Produk -->
                <div>
                    <label class="block font-medium mb-1">Nama Barang</label>
                    <input type="text" x-model="form.name" class="border rounded w-full p-2"
                        placeholder="Raket Badminton" />
                </div>
            </div>

            <!-- Harga Beli, Harga Jual, Stok -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Harga Beli -->
                <div>
                    <label class="block font-medium mb-1">Harga Beli</label>
                    <input type="text" x-model="form.price" class="border rounded w-full p-2"
                        placeholder="100,000" />
                </div>
                <!-- Harga Jual -->
                <div>
                    <label class="block font-medium mb-1">Harga Jual</label>
                    <input type="text" x-model="form.selling_price" class="border rounded w-full p-2"
                        placeholder="130,000" />
                </div>
                <!-- Stok Barang -->
                <div>
                    <label class="block font-medium mb-1">Stok Barang</label>
                    <input type="number" x-model="form.stock" class="border rounded w-full p-2" placeholder="35" />
                </div>
            </div>

            <!-- Dropzone -->
            <div>
                <label class="block font-medium mb-1">Upload Image</label>
                <div x-ref="dropzoneElem" class="border-2 border-dashed border-gray-300 p-4 rounded bg-white">
                    <p class="text-sm text-gray-600">Tarik gambar ke sini atau klik area ini.</p>
                </div>
                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG | Maks: 2MB</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex space-x-4">
                <a href="{{ url('product') }}" class="px-4 py-2 rounded border hover:bg-gray-100">
                    Batalkan
                </a>
                <button type="submit" class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-master>
