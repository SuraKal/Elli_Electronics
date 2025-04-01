<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;
use Carbon\Carbon;

new #[Layout('components.layouts.admin')] class extends Component {
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


    
        // return Order::where('code', 'like', '%' . $this->search . '%')
        //     ->orderBy('created_at', 'desc') // Order by latest first
        //     ->skip(($this->currentPage - 1) * $this->itemsPerPage)
        //     ->take($this->itemsPerPage)
        //     ->get();





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



    public string $status = '';
    public array $orderStatusList = [
        'pending' => 'Pending',
        'assigned' => 'Assigned',
        'cancelled' => 'Cancelled',
        'ontheway' => 'Ontheway',
        'dropped' => 'Dropped'
    ];

    public function updateStatus($status, $orderId)
    {
        $order = Order::find($orderId);

        dd($order);
        // if ($order) {
        //     $order->status = $status;
        //     $order->save();
        //     $this->emit('statusUpdated', $order); // Optionally emit an event to notify the frontend
        // }
    }



};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of Orders') }}
        </h2>

        <a href="{{ route('admin.order.create') }}"
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

                                $status = $order->status;


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
                                $customerLink = '<a href="'.$route.'"
                                    class="hover:underline">'.htmlspecialchars($customer, ENT_QUOTES,
                                    'UTF-8').'</a>';
                                break;

                                case 'corporate':
                                $customer = optional($order->corporate)->user->name ?? 'Corporate Account';
                                $route = route('admin.user.edit', optional($order->corporate)->user->uuid ?? 0);
                                $customerLink = '<a href="'.$route.'"
                                    class="hover:underline">'.htmlspecialchars($customer, ENT_QUOTES,
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
</div>
