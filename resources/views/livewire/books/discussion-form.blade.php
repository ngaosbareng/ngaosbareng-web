<div>
    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Judul Pembahasan</label>
            <input type="text" wire:model="title" id="title"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('title') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Isi Pembahasan</label>
            <textarea wire:model="content" id="content" rows="5"
                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Tulis isi pembahasan di sini..."></textarea>
            @error('content') <span class="mt-1 text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
            <button type="submit"
                class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-md hover:bg-indigo-700 sm:ml-3 sm:w-auto transition">
                {{ $discussion ? 'Simpan Perubahan' : 'Tambah Pembahasan' }}
            </button>
            <button type="button" wire:click="$dispatch('close-modal')"
                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">
                Batal
            </button>
        </div>
    </form>
</div>