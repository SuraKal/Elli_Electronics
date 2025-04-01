<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use App\Services\UserService;
use App\Services\CourierService;

new #[Layout('components.layouts.admin')] class extends Component {
    public Order $order;
    public string $code;
    public ?int $guest_id;
    public ?int $customer_id;
    public ?int $corporate_id;
    public ?int $user_id;
    

    public bool $is_project_order;
    public ?int $project_id;
    public string $userType;
    public int $product_id;
    public string $type;
    public string $status;
    public string $product_name;
    

    // Additional Values 
    public ?string $customer_name;

    public array $users = [];

    // Shipping detail
    public ?string $shipping_email;
    public ?string $shipping_name;
    public ?string $shipping_phone;
    public ?string $shipping_tax_id;
    public ?string $shipping_address;
    public ?string $shipping_appartment;
    public ?string $shipping_city;
    public ?string $shipping_zip;


    // Currency
    public ?string $order_currency;


    // Product
    public $product;

    // Order detail
    public ?string $product_ordered;
    public ?string $quantity;
    public ?string $currency;
    public ?string $price;
    public ?string $amount;
    public ?string $coupon_used;
    public ?string $order_status = '';
    public array $orderStatusList = [
        'pending' => 'Pending',
        'assigned' => 'Assigned',
        'cancelled' => 'Cancelled',
        'ontheway' => 'Ontheway',
        'dropped' => 'Dropped'
    ];

    
    // Transactions 
    public $transaction;
    public $transaction_tx_ref;

    public array $transactionStatusList = [
        'unconfirmed' => 'Unconfirmed',
        'waiting' => 'Waiting',
        'paid' => 'Paid & Confirmed',
        'declined' => 'Declined'
    ];
    public ?string $transaction_status = '';
    public $transaction_method = NULL;
    public $transaction_method_show = NULL;

    public array $transaction_method_list = [
        'bank' => 'Bank',
        'cash' => 'Cash',
    ];



    public ?string $delivery_method = NULL;

    public array $delivery_method_list = [
        'customerBased' => 'Customer Took Package Personally',
        'deliveryPartner' => 'Delivery Partner Took Package',
        'indoorDelivery' => 'Staff Took The Package',
    ];

    public ?string $courier_id = null;
    public array $courier = [];

    // courierSelected


// $courier_list
    protected $userService;
    protected $courierService;

    public function mount(Order $order,UserService $userService, CourierService $courierService)
    {
        // dd($order);
        $this->userService = $userService;
        $userList = $this->userService->getUsersForOrderDetail('corporate','customer');

        $this->users = $userList->pluck('name', 'id')->toArray();



        $this->courierService = $courierService;
        $couriersList = $this->courierService->getAll();
        $this->courier = $couriersList->pluck('name', 'id')->toArray();


        $this->order = $order;

        $this->fill($this->order);

        if($order->userType == 'guest') {
            $user = $order?->guest;
            $this->customer_name = $user?->identifier;
        } elseif($order->userType == 'customer') {
            $user = $order?->user;
            $this->customer_name = $user?->name;
        }elseif($order->userType == 'corporate') {
            $user = $order?->corporate->user;
            $this->customer_name = $user?->name;
        }


        $this->user_id = $user?->id;
        
        // Shipping details
        $this->shipping_email = $user->shipping?->email;
        $this->shipping_name = $user->shipping?->name;
        $this->shipping_phone = $user->shipping?->phone;
        $this->shipping_tax_id = $user->shipping?->tax_id;
        $this->shipping_address = $user->shipping?->address;
        $this->shipping_appartment = $user->shipping?->appartment;
        $this->shipping_city = $user->shipping?->city;
        $this->shipping_zip = $user->shipping?->zip;

        // Currency
        $this->order_currency = $order?->detail?->currency;

        // Product
        $this->product = $order->product;
        $this->product_name = $order?->product?->name;

        // Order detail 
    
        $this->product_ordered = $order?->detail?->product_ordered;
        $this->quantity = $order?->detail?->quantity;
        $this->currency = $order?->detail?->currency;
        $this->price = $order?->detail?->price;
        $this->amount = $order?->detail?->amount;
        $this->coupon_used = $order?->detail?->coupon_used;
        $this->order_status = (string) $order?->status;


        // Transaction

        $this->transactions = $order->transaction;
        $this->transaction_tx_ref = $order?->transaction?->tx_ref;
        $this->transaction_status = $order?->transaction?->status;
        $this->transaction_method = $order?->transaction?->method ?? 'N/A';
        $this->transaction_method_show = $order?->transaction?->method ?? 'N/A';
        

        // delivery info 
        $this->delivery_method = $order?->delivery?->deliveryType;

        $this->courier_id = $order?->delivery?->courier_id;

        $this->fetchCouriers($courierService);
    }


// order_status
// updateOrderStatus

    public function updateOrderStatus(){
        $this->validate([
            'order_status' => 'required|in:pending,assigned,ontheway,dropped,cancelled'
        ]);

        $this->order->update([
            'status' => $this->order_status
        ]);

        $this->dispatch('orderStatus-updated');
    }

// transaction_status,transactionStatusList
    public function updateTransactionStatus(){
        $this->validate([
            'transaction_status' => 'required|in:unconfirmed,waiting,paid,declined'
        ]);

        $this->order->transaction->update([
            'status' => $this->transaction_status
        ]);

        $this->dispatch('transactionStatus-updated');
    }

    public function updateTransactionMethod(){
        $this->validate([
            'transaction_method' => 'required|in:bank,cash'
        ]);

        $this->order->transaction->update([
            'method' => $this->transaction_method
        ]);

        $this->transaction_method_show = $this->order?->transaction?->method ?? 'N/A';
        $this->dispatch('transactionMethod-updated');
    }

    public function rules(){
        return [
            'delivery_method' => ['required','in:customerBased,deliveryPartner,indoorDelivery'],
            'courier_id' => ['required_if:delivery_method,deliveryPartner'],
        ];
    }

    // public function messages(){
    //     return [
    //         'courier_id.required_if' => 'Delivery Partner is needed if you choose it is delivered by a partner',
    //     ];
    // }
    
    public function updateDeliveryMethod(){
        $this->validate();

// ->messages([
//                 'courier_id.required_if' => 'Delivery Partner is needed if you choose it is delivered by a partner'
//             ]);
        $this->order->delivery->update([
            'deliveryType' => $this->delivery_method,
            'courier_id' => $this->courier_id
        ]);

        $this->dispatch('deliveryMethod-updated');
    }




    // updateDeliveryMethod,courier_id,deliveryMethod-updated



    public function fetchCouriers($courierService)
    {
        // $this->categories = Category::all()->mapWithKeys(function ($category) {
        //     return [$category->id => $category->name];
        // })->toArray() ?: ['' => 'No category available'];

        $this->courierService = $courierService;
        $couriersList = $this->courierService->getAll();
        $this->courier = $couriersList->pluck('name', 'id')->toArray();
    }

    #[\Livewire\Attributes\On('product-edited')]
    public function refreshCategories(CourierService $courierService)
    {
        $this->fetchCouriers($courierService);
    }

    // updateTransactionStatus
};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage ' . $code ) }}
        </h2>

        <a href="{{ route('admin.order.create') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            Add New Order
        </a>
    </div>
</x-slot>

<section>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Order Information') }}
                        </h2>
                    </header>


                    <section class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="code" :value="__('Order Code')" />
                            <x-text-input wire:model="code" id="code" name="code" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="code" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('code')" />
                        </div>

                        <x-action-message class="me-3" on="orderStatus-updated" message='Order Status Updated' />

                        <form wire:submit.prevent="updateOrderStatus" class="my-6">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <x-input-label for="order_status" :value="__('Order Status')" />
                                    <x-select :options="$orderStatusList" placeholder="Choose Status"
                                        class="mt-1 block w-full" wire:model="order_status" required />
                                    <x-input-error :messages="$errors->get('order_status')" class="mt-2" />
                                </div>

                                


                                


                                <div class="col-12 col-md-6 d-flex align-items-center mt-4">
                                    <!-- Aligns button with input field -->
                                    <x-primary-button wire:loading.remove wire:target="updateOrderStatus">
                                        {{ __('Update Status') }}
                                    </x-primary-button>
                                    <x-loader target="updateOrderStatus" content="Updating..." class="ms-2" />
                                </div>
                            </div>
                        </form>


                        <div>
                            <x-input-label for="userType" :value="__('User Type')" />
                            <x-text-input wire:model="userType" id="userType" name="userType" type="text"
                                class="mt-1 block w-full capitalize" required autofocus autocomplete="userType"
                                disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('userType')" />
                        </div>

                        {{-- <div>
                            <x-input-label for="Customer" :value="__('Customer')" />
                            <x-select :options="$users" placeholder="Choose Customer" class="mt-1 block w-full"
                                wire:model="user_id" />
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div> --}}

                        <div>
                            <x-input-label for="Customer" :value="__('Customer')" />
                            <x-text-input wire:model="customer_name" id="customer" name="customer" type="text"
                                class="mt-1 block w-full capitalize" required autofocus autocomplete="customer"
                                disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('customer')" />
                        </div>

                        <div>
                            <x-input-label for="currency" :value="__('Currency')" />
                            <x-text-input wire:model="currency" id="currency" name="currency" type="text"
                                class="mt-1 block w-full capitalize" required autofocus autocomplete="currency"
                                disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                        </div>

                        <div>
                            <x-input-label for="product" :value="__('Product')" />
                            <x-text-input wire:model="product_name" id="product" name="product" type="text"
                                class="mt-1 block w-full capitalize cursor-pointer" required autofocus
                                autocomplete="product" disabled wire:click="redirectToEdit('{{ $product->uuid }}')" />
                            <x-input-error class="mt-2" :messages="$errors->get('product')" />
                        </div>
                        <div>
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input wire:model="quantity" id="quantity" name="quantity" type="text"
                                class="mt-1 block w-full capitalize" required autofocus autocomplete="quantity"
                                disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>
                        <div>
                            <x-input-label for="unit_price" :value="__('Unit Product Price')" />
                            <x-text-input wire:model="price" id="price" name="price" type="text"
                                class="mt-1 block w-full capitalize" required autofocus autocomplete="price" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('price')" />
                        </div>
                        <div>
                            <x-input-label for="order_price" :value="__('Order Total Price')" />
                            <x-text-input wire:model="amount" id="amount" name="amount" type="text"
                                class="mt-1 block w-full capitalize" required autofocus autocomplete="amount"
                                disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>

                        <hr>

                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Transaction Information') }}
                            </h2>
                        </header>


                        <div class="lg:mt-4">
                            <x-input-label for="transaction_method" :value="__('Transaction Method')" />
                            <x-text-input wire:model="transaction_method_show" id="transaction_method"
                                name="transaction_method" type="text" class="mt-1 block w-full capitalize" required
                                autofocus autocomplete="transaction_method" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('transaction_method')" />
                        </div>
                        <div>
                            <x-input-label for="transaction_tx_ref" :value="__('Tx_ref')" />
                            <x-text-input wire:model="transaction_tx_ref" id="transaction_tx_ref"
                                name="transaction_tx_ref" type="text" class="mt-1 block w-full capitalize" required
                                autofocus autocomplete="transaction_tx_ref" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('transaction_tx_ref')" />
                        </div>

                        <x-action-message class="me-3" on="transactionMethod-updated"
                            message='Transaction Method Updated' />
                        <form wire:submit.prevent="updateTransactionMethod" class="my-6">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <x-input-label for="transaction_method" :value="__('Transaction Method')" />
                                    <x-select :options="$transaction_method_list" placeholder="Choose method"
                                        class="mt-1 block w-full" wire:model="transaction_method" required />
                                    <x-input-error :messages="$errors->get('transaction_method')" class="mt-2" />
                                </div>


                                <div class="col-12 col-md-6 d-flex align-items-center mt-4">
                                    <!-- Aligns button with input field -->
                                    <x-primary-button wire:loading.remove wire:target="updateTransactionMethod">
                                        {{ __('Update Transaction Method') }}
                                    </x-primary-button>
                                    <x-loader target="updateTransactionMethod" content="Updating..." class="ms-2" />
                                </div>

                            </div>
                        </form>
                        <x-action-message class="me-3" on="transactionStatus-updated"
                            message='Transaction Status Updated' />

                        <form wire:submit.prevent="updateTransactionStatus" class="my-6">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <x-input-label for="transaction_status" :value="__('Transaction Status')" />
                                    <x-select :options="$transactionStatusList" placeholder="Choose Status"
                                        class="mt-1 block w-full" wire:model="transaction_status" required />
                                    <x-input-error :messages="$errors->get('transaction_status')" class="mt-2" />
                                </div>


                                <!-- Conditional div -->
                                <div class="mt-4" @if($transaction_status==='deliveryPartner' ) style="display:block" @else
                                    style="display:none" @endif>
                                    <x-input-label for="pending_details" :value="__('Pending Details')" />
                                    <x-textarea wire:model="pending_details" id="pending_details"
                                        class="mt-1 block w-full" />
                                </div>


                                <div class="col-12 col-md-6 d-flex align-items-center mt-4">
                                    <!-- Aligns button with input field -->
                                    <x-primary-button wire:loading.remove wire:target="updateTransactionStatus">
                                        {{ __('Update Transaction Status') }}
                                    </x-primary-button>
                                    <x-loader target="updateTransactionStatus" content="Updating..." class="ms-2" />
                                </div>
                            </div>
                        </form>





                        <hr>


                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Delivery Information') }}
                            </h2>
                        </header>

                        <x-action-message class="me-3" on="deliveryMethod-updated"
                            message='Delivery Method Updated' />
                        <form wire:submit.prevent="updateDeliveryMethod" class="my-6 d-none">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <x-input-label for="delivery_method" :value="__('Delivery Status')" />
                                    <x-select :options="$delivery_method_list" placeholder="Choose method"
                                        class="mt-1 block w-full" wire:model="delivery_method" required />
                                    <x-input-error :messages="$errors->get('delivery_method')" class="mt-2" />
                                </div>

                                <div wire:show="delivery_method === 'deliveryPartner'" x-transition:enter="fade"
                                    x-transition:leave="fade" class="mt-4">
                                    <x-input-label for="couriers" :value="__('Select Your Partner')" />

                                    <x-select :options="$courier" placeholder="Choose Partner"
                                        class="mt-1 block w-full" wire:model="courier_id" required />
                                    <x-input-error :messages="$errors->get('courier_id')" class="mt-2" />
                                </div>

                                <div class="col-12 col-md-6 d-flex align-items-center mt-4">
                                    <!-- Aligns button with input field -->
                                    <x-primary-button wire:loading.remove wire:target="updateDeliveryMethod">
                                        {{ __('Update Delivery Method') }}
                                    </x-primary-button>
                                    <x-loader target="updateDeliveryMethod" content="Updating..." class="ms-2" />
                                </div>

                            </div>
                        </form>
                    </section>




                    <div class="flex items-center gap-4">
                        {{-- <x-primary-button>{{ __('Save') }}</x-primary-button> --}}

                        {{-- <x-action-message class="me-3" on="profile-updated">
                                {{ __('Saved.') }}
                        </x-action-message> --}}
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
