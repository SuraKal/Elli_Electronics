<?php
use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Services\UserService;
use App\Services\ProductService;
use Livewire\Attributes\Layout;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


// quantity, currency, price, amount


new #[Layout('components.layouts.admin')] class extends Component {
    public ?string $corporate_id = NULL;
    public ?string $customer_id = NULL;

    public array $users = [];
    protected $userService;
    public ?string $user_id = '';
    public string $code;
    // public array $status = ['Pending','Assigned','Ontheway','Dropped','Cancelled'];
    public array $status = [
        'pending' => 'Pending',
        'assigned' => 'Assigned',
        'cancelled' => 'Cancelled',
        'ontheway' => 'Ontheway',
        'dropped' => 'Dropped'
    ];
    public ?string $statusSelected = '';

    public array $currency = [
        'ETB' => 'ETB'
    ];
    public ?string $currencySelected = '';

    public array $country = [
        'Ethiopia' => 'Ethiopia'
    ];
    public ?string $countrySelected = '';

    public array $type = [
        'BePaid' => 'BePaid',
        'Credit' => 'Credit'
    ];
    public ?string $typeSelected = '';





    public ?string $street = null;
    public ?string $city = null;
    public ?string $zip = null;
    public ?string $note = null;


    protected $productService;
    public array $products = [];
    public ?string $quantity;

    public ?string $product_id = '';


    public ?string $product_ordered = NULL;


    public float $price;
    public float $amount;
    


    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            'typeSelected' => [
                // Base validation for all users
                'required',
                // Conditional validation for Joe
                function ($attribute, $value, $fail) {
                    $user = User::find($this->user_id);
                    
                    if ($user && $user->role() === 'corporate') {
                        if (!in_array($value, ['Credit', 'BePaid'])) {
                            $fail('Credit is only allowed for corporate users');
                        }
                    } else {
                        if (!in_array($value, ['BePaid'])) {
                            $fail('Only BePaid allowed for non-corporate users');
                        }
                    }
                }
            ],
            'code' => ['required', 'string'],
            'statusSelected' => ['required', 'in:pending,assigned,ontheway,dropped,cancelled'],
            'currencySelected' => ['required', 'in:ETB'],
            'countrySelected' => ['required', 'in:Ethiopia'],
            'street' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'zip' => ['nullable', 'string'],
            'note' => ['nullable', 'string'],
            'quantity' => ['required', 'numeric', 'min:1']
        ];
    }
    
    public function store(){
        // Validate form
        $this->validate();
        $user = User::find($this->user_id);
        $userType = $user->role();


        if($userType == 'corporate'){
            $this->corporate_id = $user->corporate()->first()->id;
        }elseif($userType == 'customer'){
            $this->customer_id = $this->user_id;
        }

        // Create order
        $order = Order::create([
            'corporate_id' =>$this->corporate_id ?? null,
            'user_id' => $this->customer_id ?? null,
            'code' => $this->code,
            'userType' => $userType,
            'product_id' => $this->product_id,
            'type' => $this->typeSelected,
            'status' => $this->statusSelected,
        ]);

        if ($order) {
            $product = Product::find($this->product_id);
            $this->product_ordered = $product?->template?->first()?->structure ?? null;
            $this->price = $product->price;


            // Create product details
            $order->detail()->create([
                'product_ordered' => $this->product_ordered,
                'quantity' => $this->quantity,
                'currency' => $this->currencySelected,
                'price' => $this->price,
                'amount' => $this->price * $this->quantity,
            ]);


            $order->transaction()->create([
                'tx_ref' => 'TX-'.Str::upper(Str::random(16)),
                'status' => 'unconfirmed',
                'method' => NULL,
            ]);

            $userType = 'customer';
            // Create shipping details
            $order->shipping()->create([
                'user_id' => $this->user_id,
                'userType' => $userType,
                'email' => $user->email,
                'name' => $user->name,
                'phone' => $user->phone,
                'country' => $this->countrySelected,
                'city' => $this->city,
                'address' => $this->street,
                'zip' => $this->zip,
            ]);


            $order->delivery()->create([
                'deliveryType' => 'customerBased'
            ]);




            // $table->foreignIdFor(Order::class)->constrained()->cascadeOnDelete();
            // $table->enum('deliveryType', ['customerBased', 'deliveryPartner', 'indoorDelivery'])->default('customerBased')->nullable()->default(NULL);

            // $table->foreignIdFor(Courier::class)->nullable()->constrained()->onDelete(NULL);
            // $table->text('additional_info')->nullable();
            

        }

        // Dispatch event and reset form
        $this->redirectIntended(route('admin.order.edit', $order->uuid));
        // $this->dispatchBrowserEvent('order-created');
        $this->reset();
    }

    


    public function mount(UserService $userService, ProductService $productService){
        
        $this->fetchUsersProducts($userService,$productService);
    }
        /**
     * Fetch users from the database
     */
    public function fetchUsersProducts($userService,$productService)
    {
        $this->code = 'Order-'.Str::upper(Str::random(8));
        $this->users = $userService->getUsers('corporate','customer')
                                    ->pluck('name', 'id')
                                    ->toArray();
        $this->users = $userService->getUsers('corporate','customer')
            ->mapWithKeys(function ($user) {
                return [
                    $user->id => $user->name . '(' . $user->role() . ')'
                ];
            })
            ->toArray();

        $this->products = $productService->getProductsActive2()
                                    ->pluck('name', 'id')
                                    ->toArray();
    }


    #[\Livewire\Attributes\On('order-created')]
    public function refreshNeeded(UserService $userService, ProductService $productService)
    {
        $this->fetchUsersProducts($userService,$productService);
    }

}; ?>


<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Order' ) }}
        </h2>

        <a href="{{ route('admin.order.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            List Orders
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

                    <x-action-message class="me-3" on="order-created" message='Order Created' />

                    <form wire:submit="store" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="code" :value="__('Order Code')" />
                            <x-text-input wire:model="code" id="code" name="code" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="code" disabled />
                            <x-input-error class="mt-2" :messages="$errors->get('code')" />
                        </div>
                        <div>
                            <x-input-label for="Customer" :value="__('Customer')" />
                            <x-select :options="$users" placeholder="Choose Customer" class="mt-1 block w-full"
                                wire:model="user_id" required />
                            <x-input-error class="mt-2" :messages="$errors->get('user_id')" />
                        </div>
                        <div>
                            <x-input-label for="Status" :value="__('Status')" />
                            <x-select :options="$status" placeholder="Choose Status" class="mt-1 block w-full"
                                wire:model="statusSelected" required />
                            <x-input-error class="mt-2" :messages="$errors->get('statusSelected')" />
                        </div>
                        <div>
                            <x-input-label for="Currency" :value="__('Currency')" />
                            <x-select :options="$currency" placeholder="Choose Currency" class="mt-1 block w-full"
                                wire:model="currencySelected" />
                            <x-input-error class="mt-2" :messages="$errors->get('currencySelected')" />
                        </div>
                        <div>
                            <x-input-label for="type" :value="__('Type')" />
                            <x-select :options="$type" placeholder="Choose Type" class="mt-1 block w-full"
                                wire:model="typeSelected" />
                            <x-input-error class="mt-2" :messages="$errors->get('typeSelected')" />
                        </div>


                        <div>
                            <x-input-label for="country" :value="__('Country')" />
                            <x-select :options="$country" placeholder="Choose Country" class="mt-1 block w-full"
                                wire:model="countrySelected" />
                            <x-input-error class="mt-2" :messages="$errors->get('countrySelected')" />
                        </div>

                        
                        <div>
                            <x-input-label for="zip" :value="__('Zip')" />
                            <x-text-input wire:model="zip" id="zip" name="zip" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="zip" />
                            <x-input-error class="mt-2" :messages="$errors->get('zip')" />
                        </div>

                        <div>
                            <x-input-label for="city" :value="__('City')" />
                            <x-text-input wire:model="city" id="city" name="city" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="city" />
                            <x-input-error class="mt-2" :messages="$errors->get('city')" />
                        </div>
                        

                        <div>
                            <x-input-label for="street" :value="__('Address')" />
                            <x-text-input wire:model="street" id="street" name="street" type="text"
                                class="mt-1 block w-full" autofocus autocomplete="street" />
                            <x-input-error class="mt-2" :messages="$errors->get('street')" />
                        </div>

                        
                        

                        
                        <div>
                            <x-input-label for="note" :value="__('Note')" />
                            {{-- <x-text-input wire:model="note" id="note" name="note" type="text" class="mt-1 block w-full"
                                autofocus autocomplete="note"  /> --}}

                            <x-textarea wire:model="note" name="note" autocomplete="note" class="mt-1 block w-full h-64"
                                placeholder="Short note about the order...">
                            </x-textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('note')" />
                        </div>
                        <hr>

                        <div>
                            <x-input-label for="products" :value="__('Products')" />
                            <x-select :options="$products" placeholder="Choose Product" class="mt-1 block w-full"
                                wire:model="product_id" required />
                            <x-input-error class="mt-2" :messages="$errors->get('product_id')" />
                        </div>



                        <div>
                            <x-input-label for="quantity" :value="__('Quantity')" />
                            <x-text-input wire:model="quantity" id="quantity" name="quantity" type="text"
                                class="mt-1 block w-full" required autofocus autocomplete="quantity" min="1"/>
                            <x-input-error class="mt-2" :messages="$errors->get('quantity')" />
                        </div>

                        <div class="flex items-center gap-4">

                            <x-primary-button class="ms-3" wire:loading.remove wire:target="store">
                                {{ __('Create') }}
                            </x-primary-button>
                            <x-loader target="store" content="Creating..." />
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</section>
