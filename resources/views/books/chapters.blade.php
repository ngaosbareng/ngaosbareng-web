<x-layouts.app :title="__('Kitab Saya')">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $book->title }}
        </h2>
    </x-slot>

    <livewire:books.chapter-index :book="$book" />
</x-layouts.app>