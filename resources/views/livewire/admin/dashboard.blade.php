<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Order;
use App\Models\Product;

use Carbon\Carbon;
use App\Services\DashboardService;


new #[Layout('components.layouts.admin')] class extends Component
{
        public $sn = 1;
    public string $search = '';
    public $itemsPerPage = 5;
    public $currentPage = 1;

    public function getFilteredOrdersProperty()
    {
        return Order::with(['user', 'product', 'corporate']) // Eager load relationships
            ->search($this->search)
            ->latest()
            ->paginate($this->itemsPerPage, ['*'], 'page', $this->currentPage);
    }

    public function getFilteredProductsProperty()
{
    return Product::with(['categories'])
        ->search($this->search)
        ->latest()
        ->limit(5) // Limits total results to 5
        ->paginate($this->itemsPerPage, ['*'], 'page', $this->currentPage);
}






    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        $this->dispatch('order-deleted');
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




    // ------
    public int $userCount = 0;
    public int $productCount = 0;
    public int $orderCount = 0;


    public function mount(DashboardService $dashboardService){
        $this->userCount = $dashboardService->userCount();
        $this->productCount = $dashboardService->productCount();
        $this->orderCount = $dashboardService->orderCount();
    }


}; ?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Dashboard Cards Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- User Count Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">
                <div class="flex flex-col items-center gap-4">
                    <h3 class="text-lg font-medium text-gray-800">Total Users</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $userCount }}</p>
                    <a href="{{ route('admin.user.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14m7-7H5"></path>
                        </svg>
                        List Users
                    </a>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">
                <div class="flex flex-col items-center gap-4">
                    <h3 class="text-lg font-medium text-gray-800">Orders</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $orderCount }}</p>
                    <a href="{{ route('admin.order.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14m7-7H5"></path>
                        </svg>
                        List Orders
                    </a>
                </div>
            </div>

            <!-- Products Card -->
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out">
                <div class="flex flex-col items-center gap-4">
                    <h3 class="text-lg font-medium text-gray-800">Products</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $productCount }}</p>
                    <a href="{{ route('admin.store.product.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14m7-7H5"></path>
                        </svg>
                        List Products
                    </a>
                </div>
            </div>
        </div>
    </div>



    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight my-3">
                {{ __('Sales') }}
            </h2>
            <section>
                <x-action-message class="me-3" on="order-deleted" message='Order Removed' />

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
                                    <th class="px-4 py-2 font-medium text-gray-900">Code</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Type</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Customer</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Status</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Currency</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Total Price</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Order Date</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Edit</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($this->filteredOrders as $order)
                                @php
                                // Unified customer link handling
                                $customerLink = 'Unknown Customer';

                                switch($order->userType) {
                                case 'guest':
                                $customer = $order->guest->identifier ?? 'Guest Customer';
                                $customerLink = htmlspecialchars($customer, ENT_QUOTES, 'UTF-8');
                                break;

                                case 'customer':
                                $customer = $order->user->name ?? 'Deleted Customer';
                                $route = route('admin.user.edit', $order->user->uuid ?? 0);
                                $customerLink = '<a href="'.$route.'" class="hover:underline">'.htmlspecialchars($customer, ENT_QUOTES,
                                    'UTF-8').'</a>';
                                break;

                                case 'corporate':
                                $customer = optional($order->corporate)->user->name ?? 'Corporate Account';
                                $route = route('admin.user.edit', optional($order->corporate)->user->uuid ?? 0);
                                $customerLink = '<a href="'.$route.'" class="hover:underline">'.htmlspecialchars($customer, ENT_QUOTES,
                                    'UTF-8').'</a>';
                                break;
                                }
                                @endphp

                                <tr wire:key="order-{{ $order->id }}-{{ $order->userType }}">
                                    <td class="px-4 py-2 text-gray-900">
                                        <a href="{{ route('admin.order.edit', $order->uuid) }}" class="hover:underline">
                                            {{ $order->code }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-gray-900 capitalize">{{ $order->userType }}</td>

                                    <!-- Safe HTML output -->
                                    <td class="px-4 py-2 text-gray-900">{!! $customerLink !!}</td>

                                    <!-- Rest of your table cells -->

                                    <td class="px-4 py-2 text-gray-900 capitalize">{{ $order->status }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $order?->detail?->currency}}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $order?->detail?->amount }}</td>
                                    <td class="px-4 py-2 text-gray-900">{{ $order->created_date }}</td>

                                    <td class="px-4 py-2 text-gray-700 flex gap-2">
                                        <a href="{{ route('admin.order.edit', $order->uuid) }}"
                                            class="px-3 py-1 text-white bg-black rounded-md hover:bg-gray-800"
                                            wire:navigate>Manage</a>
                                        <button wire:click="destroy('{{ $order->id }}')"
                                            class="px-3 py-1 text-white bg-red-600 rounded-md hover:bg-red-500"
                                            onclick="return confirm('Delete this order permanently?')">Delete</button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-2 text-center text-gray-500">No orders found</td>
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

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mt-5">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight my-3">
                {{ __('Top selling') }}
            </h2>
            <section>

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
                                    <th class="px-4 py-2 font-medium text-gray-900">Price</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Sold</th>
                                    <th class="px-4 py-2 font-medium text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                
                                @forelse ($this->filteredProducts as $product)
                                    <tr wire:key="Product-{{ $product->id }}">
                                        <td class="px-4 py-2 text-gray-900">{{ $product->name }}</td>
                                        <td class="px-4 py-2 text-gray-900">{{ $product?->category()?->name }}</td>
                                        <td class="px-4 py-2 text-gray-900">{{ $product->currency }} {{ $product->price }}</td>

                                        <td class="px-4 py-2 text-gray-900">{{ rand(1, 3) }}
</td>

                                        <td class="px-4 py-2 text-gray-700 flex gap-2">
                                            <a href="{{ route('admin.store.product.edit', $product->uuid) }}"
                                                class="px-3 py-1 text-white bg-black rounded-md hover:bg-gray-800" wire:navigate>Detail</a>
                                            
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
