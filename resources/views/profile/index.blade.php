<x-master>
    <div class="px-6 py-4" x-data="profilePage()" x-init="init()">
        <div class="flex items-center space-x-4 mb-6">
            <div class="relative">
                <img :src="existingImageUrl"
                     alt="Avatar"
                     class="w-24 h-24 rounded-full object-cover border shadow">
                <label for="avatar-upload" class="absolute bottom-0 right-0 bg-gray-200 p-1 rounded-full cursor-pointer hover:bg-gray-300">
                    <i class="fas fa-edit text-gray-600"></i>
                </label>
                <input id="avatar-upload" type="file" class="hidden" @change="handleAvatarUpload($event)">
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800" x-text="form.name"></h1>
                <p class="text-gray-500" x-text="form.position"></p>
            </div>
        </div>

        <div>
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Nama Kandidat</label>
                <input type="text" x-model="form.name" class="border rounded w-full p-2" />
            </div>
            <div class="mb-4">
                <label class="block font-medium text-gray-700">Posisi Kandidat</label>
                <input type="text" x-model="form.position" class="border rounded w-full p-2" />
            </div>
        </div>

        <div class="mt-4 flex justify-end">
            <button class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
                    @click="saveProfile">Simpan Perubahan</button>
        </div>
    </div>
</x-master>
