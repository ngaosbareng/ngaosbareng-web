<x-layouts.app :title="__('Diskusi Bab')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $chapter->title }}
        </h2>
    </x-slot>

    <livewire:books.discussion-index :chapter="$chapter" />
</x-layouts.app>