<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use Carbon\Carbon;

new #[Layout('components.layouts.admin')] class extends Component {
    public $sn = 1;
    public string $search = '';
    public $itemsPerPage = 5;
    public $currentPage = 1;

    // public function getFilteredProductsProperty()
    // {
    //     return Product::where('name', 'like', '%' . $this->search . '%')
    //         ->orderBy('created_at', 'desc') // Order by latest first
    //         ->skip(($this->currentPage - 1) * $this->itemsPerPage)
    //         ->take($this->itemsPerPage)
    //         ->get();
    // }
        public function getFilteredProductsProperty()
    {
        return Product::with(['categories']) // Eager load relationships
            ->search($this->search)
            ->latest()
            ->paginate($this->itemsPerPage, ['*'], 'page', $this->currentPage);
    }



    // public function getFilteredProductsProperty()
    // {
    //     return Product::query()
    //         ->when($this->search, fn($query) => 
    //             $query->where('name', 'like', '%' . $this->search . '%')
    //         )
    //         ->latest()
    //         ->paginate($this->itemsPerPage, ['*'], 'page', $this->currentPage);
    // }








    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        $this->dispatch('product-deleted');
    }

    public function nextPage()
    {
        $this->currentPage++;
    }

    public function previousPage()
    {
        if ($this->currentPage > 1) {
            $this->currentPage--;
        }
    }





};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Products') }}
        </h2>

        <a href="{{ route('admin.store.product.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            Add New
        </a>
    </div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <section>
                <x-action-message class="me-3" on="product-deleted" message='Product Removed'/>


                <div class="overflow-x-auto rounded-lg border border-gray-200 p-4">

                    <!-- Search Bar -->
                    <div class="mb-4">
                        <input type="text" wire:model.live="search" placeholder="Search..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 font-medium text-gray-900">Name</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Category</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Status</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Currency</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Price</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Template</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($this->filteredProducts as $product)
                                    <tr wire:key="Product-{{ $product->id }}">
                                        <td class="px-4 py-2 text-gray-900">{{ $product->name }}</td>
                                        <td class="px-4 py-2 text-gray-900">{{ $product?->category()?->name }}</td>
                                        <td class="px-4 py-2 text-gray-900">
                                            {{ $product->status ? 'Active' : 'In Active' }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-900">{{ $product->currency }}</td>
                                        <td class="px-4 py-2 text-gray-900">{{ $product->price }}</td>
                                        <td class="px-4 py-2 text-gray-900">{{ $product->hasTemplate() ? 'Set' : 'Not Set' }}</td>

                                        <td class="px-4 py-2 text-gray-700 flex gap-2">
                                            <a href="{{ route('admin.store.product.edit', $product->uuid) }}"
                                                class="px-3 py-1 text-white bg-black rounded-md hover:bg-gray-800" wire:navigate>Edit</a>
                                            <button wire:click="destroy({{ $product->id }})"
                                                class="px-3 py-1 text-white bg-red-600 rounded-md hover:bg-red-500">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">No results found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="flex flex-col sm:flex-row justify-between items-center mt-4 space-y-2 sm:space-y-0">
                        <button wire:click="previousPage"
                            class="px-3 py-1 bg-black text-white rounded-md hover:bg-gray-800">Prev</button>

                        <span class="text-gray-700">Page {{ $currentPage }}</span>

                        <button wire:click="nextPage"
                            class="px-3 py-1 bg-black text-white rounded-md hover:bg-gray-800">Next</button>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>
