<?php
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Services\UserService;

new #[Layout('components.layouts.guest')] class extends Component
{
    public Product $product;
// selectedOptions,product_id,typeSelected,quantity

    public $product_id;
    public $related_products = [];

    public $templateStructure = [];

    public $selectedSubcategories = [];
    public $quantity = 1;

    public $selectedOptions = []; // Stores category => subcategory pairs

    public $typeSelected = 'BePaid';
    public $typeOptions = [
        'Credit' => 'Credit',
        'BePaid' => 'Be Paid',
    ];
    protected $rules = [
            'selectedOptions' => 'required|array',
            'selectedOptions.*' => 'required|string', // Ensure a subcategory is selected for each category
            'quantity' => 'required|numeric|min:1|max:10',
        ];

    protected $messages = [
        'selectedOptions.required' => 'Please select all required options.',
        'selectedOptions.*.required' => 'The :attribute field is required.',
    ];

    public function mount(Product $product){
        $this->product = $product;
        $this->product_id = $product->id;
        $this->related_products = $product->related_products();

        $this->fetchTemplates();

        // dd($this->templateStructure);
    }

        public function fetchTemplates()
    {   
        // dd($this->product->template);
        $this->product->load('template'); // Reload relationship
        // $this->product = Product::find($this->product->id);
        $this->templateStructure = optional($this->product->template->first())->structure ?? [];

        // Convert JSON string to associative array
        if($this->templateStructure){
            $this->templateStructure = json_decode($this->templateStructure, true);
            // dd( $this->templateStructure );
        }
    }


    // public function addtocart()
    // {
    //     $this->validate();

    //     Order::create([
    //         'user_id' => auth()->id(),
    //         'product_id' => $this->product->id,
    //         'options' => $this->selectedOptions, // {"Capacity":"5 VOLT", "BatteryType":"Li-ion"}
    //         'quantity' => $this->quantity,
    //     ]);

    //     // Reset form and show success message
    //     $this->selectedOptions = [];
    //     $this->quantity = 1;
    //     session()->flash('message', 'Product added to cart!');
    // }

public function addtocart(UserService $userService)
{
    // Retrieve the cart cookie value or create it if it doesn't exist
    $cookie_value = $userService->getOrCreateCartCookie();

    // Generate order code
    $code = 'Order-' . Str::upper(Str::random(16));

    // Validate form inputs
    $this->validate([
        'selectedOptions' => 'required|array',
        'selectedOptions.*' => 'required|string',
        'quantity' => 'required|numeric|min:1|max:10',
        'typeSelected' => [
            'required',
            'in:Credit,BePaid',
            function ($attribute, $value, $fail) {
                $user = Auth::user();
                
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
        'product_id' => 'required', // Ensure product exists
    ]);

    // Get authenticated user
    $user = Auth::user();
    if (!$user) {
        // Set user type to 'guest' if not authenticated
        $userType = 'guest';
    } else {
        $userType = $user->role(); // Corporate or customer
    }


    $currency = 'ETB';

    // Corporate/Customer ID handling
    if ($userType == 'corporate') {
        $corporateId = $user->corporate()->first()->id ?? null;
        if (!$corporateId) {
            session()->flash('error', 'Corporate account not found!');
            return;
        }
    } elseif ($userType == 'customer') {
        $customerId = $user->id;
    } elseif ($userType == 'guest') {
        // For guests, use the guest cookie value
        $guestId = $cookie_value;
    }


    // dd([
    //     'corporateId' => $corporateId ?? null,
    //     'customerId' => $customerId ?? null,
    //     'guestId' => $guestId ?? null,
    //     'userType' => $userType,
    //     'code' => $code,
    //     'product_id' => $this->product_id,
    //     'typeSelected' => $this->typeSelected,
    // ]);


    try {
        // Create order
        $order = Order::create([
            'corporate_id' => $corporateId ?? null,
            'user_id' => $customerId ?? null,
            'guest_id' => $guestId ?? null,
            'code' => $code,
            'userType' => $userType,
            'product_id' => $this->product_id,
            'type' => $this->typeSelected ?? 'BePaid',
        ]);



        // Product validation
        $product = Product::find($this->product_id);

        // Create order detail
        $order->detail()->create([
            'product_ordered' => json_encode($this->selectedOptions), // Storing as JSON for array structure
            'quantity' => $this->quantity,
            'currency' => $currency,
            'price' => $product->price,
            'amount' => $product->price * $this->quantity,
        ]);

        // Create transaction
        $order->transaction()->create([
            'tx_ref' => 'TX-' . Str::upper(Str::random(16)),
            'status' => 'unconfirmed',
            'method' => null,
        ]);

        // session()->flash('success', 'Order created successfully!');
        // $this->dispatch('order-created');
        $this->redirect(route('home'));
        // $this->reset(['selectedOptions', 'quantity', 'typeSelected']);

    } catch (\Exception $e) {
        session()->flash('error', 'Error creating order: ' . $e->getMessage());
    }

    // Reset form fields
}






}; ?>



<main class="main">
    <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
        <div class="container d-flex align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.product.index') }}">Products</a></li>
            </ol>
        </div>
        <!-- End .container -->
    </nav>
    <!-- End .breadcrumb-nav -->

    <div class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    <div class="product-details-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="product-gallery">
                                    <figure class="product-main-image">
                                        <span class="product-label label-top">Top</span>
                                        <img id="product-zoom" src="{{ asset($product->image) }}"
                                            data-zoom-image="{{ asset($product->image) }}" alt="product image" />

                                        <a href="#" id="btn-product-gallery" class="btn-product-gallery">
                                            <i class="icon-arrows"></i>
                                        </a>
                                    </figure>
                                    <!-- End .product-main-image -->

                                    <div id="product-zoom-gallery" class="product-image-gallery">
                                        <a class="product-gallery-item active" href="#"
                                            data-image="{{ asset($product->image) }}"
                                            data-zoom-image="{{ asset($product->image) }}">
                                            <img src="{{ asset($product->image) }}" alt="product side" />
                                        </a>


                                    </div>
                                    <!-- End .product-image-gallery -->
                                </div>
                                <!-- End .product-gallery -->
                            </div>
                            <!-- End .col-md-6 -->

                            <div class="col-md-6">
                                <div class="product-details product-details-sidebar">
                                    <h1 class="product-title">
                                        {{ $product->name }}
                                    </h1>
                                    <!-- End .product-title -->


                                    <!-- End .rating-container -->

                                    <div class="product-price">{{ $product->currency }} {{ $product->price }}</div>
                                    <!-- End .product-price -->

                                    <div class="product-content">
                                        <p>
                                            {{ $product->detail->additional_info }}
                                        </p>
                                    </div>
                                    <!-- End .product-content -->
                                    <form wire:submit.prevent="addtocart" class="mt-6 space-y-6">
                                        <div>
                                            @foreach($templateStructure as $category => $subcategories)
                                                <div class="details-filter-row details-row-size">
                                                    <label>{{ $category }}:</label>
                                                    <div class="select-custom">
                                                        <select wire:model="selectedOptions.{{ $category }}"
                                                            class="form-control" required>
                                                            <option value="">Select {{ $category }}</option>
                                                            @foreach($subcategories as $subcategory => $status)
                                                            <option value="{{ $subcategory }}">{{ ucfirst($subcategory) }}
                                                                ({{ ucfirst($status) }})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <x-input-error class="mt-2"
                                                        :messages="$errors->get('selectedOptions.' . $category)" />
                                                </div>
                                            @endforeach
                                        </div>

                                        <input type="text" wire:model="product_id" hidden />
                                        <div>
                                            <label for="Payment">Payment</label>
                                            <select wire:model="typeSelected" class="form-control" required>
                                                <option disabled selected>Select Type</option>
                                                <option value="Credit">Credit</option>
                                                <option value="BePaid">Be Paid</option>
                                            </select>
                                            <x-input-error class="mt-2" :messages="$errors->get('typeSelected')" />
                                        </div>

                                        <div class="product-details-action">
                                            <div class="details-action-col">
                                                <label for="qty">Qty:</label>
                                                <input type="number" wire:model="quantity" id="qty" class="form-control"
                                                    min="1" max="10" required />
                                                <x-input-error class="mt-2" :messages="$errors->get('quantity')" />

                                                <button wire:submit="addtocart" class="btn btn-primary">
                                                    Add to Cart
                                                </button>

                                                @if (session()->has('success'))
                                                <div class="alert alert-success mt-3">
                                                    {{ session('success') }}
                                                </div>
                                                @endif

                                                @if (session()->has('error'))
                                                <div class="alert alert-danger mt-3">
                                                    {{ session('error') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </form>



                                    <div class="details-action-wrapper">
                                        <x-action-message class="me-3" on="order-created" message='Order Created' />

                                        <a href="#" class="btn-product btn-wishlist" title="Wishlist"><span>Add
                                                to
                                                Wishlist</span></a>
                                        <a href="#" class="btn-product btn-compare" title="Compare"><span>Add to
                                                Compare</span></a>
                                    </div>






                                    <div class="product-details-footer details-footer-col">
                                        <div class="product-cat">
                                            <span>Category:</span>
                                            <a
                                                href="{{ route('public.category.products.index',$product->category()->slug) }}">{{ $product->category()->name }}</a>
                                        </div>
                                        <!-- End .product-cat -->

                                        <div class="social-icons social-icons-sm d-none">
                                            <span class="social-label">Share:</span>
                                            <a href="#" class="social-icon" title="Facebook" target="_blank"><i
                                                    class="icon-facebook-f"></i></a>
                                            <a href="#" class="social-icon" title="Twitter" target="_blank"><i
                                                    class="icon-twitter"></i></a>
                                            <a href="#" class="social-icon" title="Instagram" target="_blank"><i
                                                    class="icon-instagram"></i></a>
                                            <a href="#" class="social-icon" title="Pinterest" target="_blank"><i
                                                    class="icon-pinterest"></i></a>
                                        </div>
                                    </div>
                                    <!-- End .product-details-footer -->
                                </div>
                                <!-- End .product-details -->
                            </div>
                            <!-- End .col-md-6 -->
                        </div>
                        <!-- End .row -->
                    </div>
                    <!-- End .product-details-top -->

                    <div class="product-details-tab">
                        <ul class="nav nav-pills justify-content-center" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="product-desc-link" data-toggle="tab"
                                    href="#product-desc-tab" role="tab" aria-controls="product-desc-tab"
                                    aria-selected="true">Description</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="product-info-link" data-toggle="tab" href="#product-info-tab"
                                    role="tab" aria-controls="product-info-tab" aria-selected="false">Additional
                                    information</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-shipping-link" data-toggle="tab"
                                    href="#product-shipping-tab" role="tab" aria-controls="product-shipping-tab"
                                    aria-selected="false">Shipping & Returns</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="product-review-link" data-toggle="tab"
                                    href="#product-review-tab" role="tab" aria-controls="product-review-tab"
                                    aria-selected="false">Reviews (2)</a>
                            </li> --}}
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="product-desc-tab" role="tabpanel"
                                aria-labelledby="product-desc-link">
                                <div class="product-desc-content">
                                    <h3>Product Information</h3>
                                    <p>
                                        {{$product?->detail?->additional_info}}
                                    </p>

                                </div>
                                <!-- End .product-desc-content -->
                            </div>
                            <!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-info-tab" role="tabpanel"
                                aria-labelledby="product-info-link">
                                <div class="product-desc-content">
                                    <h3>Information</h3>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing
                                        elit. Donec odio. Quisque volutpat mattis eros. Nullam
                                        malesuada erat ut turpis. Suspendisse urna viverra
                                        non, semper suscipit, posuere a, pede. Donec nec justo
                                        eget felis facilisis fermentum. Aliquam porttitor
                                        mauris sit amet orci.
                                    </p>

                                    <h3>Fabric & care</h3>
                                    <ul>
                                        <li>Faux suede fabric</li>
                                        <li>Gold tone metal hoop handles.</li>
                                        <li>RI branding</li>
                                        <li>Snake print trim interior</li>
                                        <li>Adjustable cross body strap</li>
                                        <li>
                                            Height: 31cm; Width: 32cm; Depth: 12cm; Handle Drop:
                                            61cm
                                        </li>
                                    </ul>

                                    <h3>Size</h3>
                                    <p>one size</p>
                                </div>
                                <!-- End .product-desc-content -->
                            </div>
                            <!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-shipping-tab" role="tabpanel"
                                aria-labelledby="product-shipping-link">
                                <div class="product-desc-content">
                                    <h3>Delivery & returns</h3>
                                    <p>
                                        We deliver to over 100 countries around the world. For
                                        full details of the delivery options we offer, please
                                        view our <a href="#">Delivery information</a><br />
                                        We hope you’ll love every purchase, but if you ever
                                        need to return an item you can do so within a month of
                                        receipt. For full details of how to make a return,
                                        please view our <a href="#">Returns information</a>
                                    </p>
                                </div>
                                <!-- End .product-desc-content -->
                            </div>
                            <!-- .End .tab-pane -->
                            <div class="tab-pane fade" id="product-review-tab" role="tabpanel"
                                aria-labelledby="product-review-link">
                                <div class="reviews">
                                    <h3>Reviews (2)</h3>
                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">Samanta J.</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 80%"></div>
                                                        <!-- End .ratings-val -->
                                                    </div>
                                                    <!-- End .ratings -->
                                                </div>
                                                <!-- End .rating-container -->
                                                <span class="review-date">6 days ago</span>
                                            </div>
                                            <!-- End .col -->
                                            <div class="col">
                                                <h4>Good, perfect size</h4>

                                                <div class="review-content">
                                                    <p>
                                                        Lorem ipsum dolor sit amet, consectetur
                                                        adipisicing elit. Ducimus cum dolores
                                                        assumenda asperiores facilis porro
                                                        reprehenderit animi culpa atque blanditiis
                                                        commodi perspiciatis doloremque, possimus,
                                                        explicabo, autem fugit beatae quae voluptas!
                                                    </p>
                                                </div>
                                                <!-- End .review-content -->

                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (2)</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful
                                                        (0)</a>
                                                </div>
                                                <!-- End .review-action -->
                                            </div>
                                            <!-- End .col-auto -->
                                        </div>
                                        <!-- End .row -->
                                    </div>
                                    <!-- End .review -->

                                    <div class="review">
                                        <div class="row no-gutters">
                                            <div class="col-auto">
                                                <h4><a href="#">John Doe</a></h4>
                                                <div class="ratings-container">
                                                    <div class="ratings">
                                                        <div class="ratings-val" style="width: 100%"></div>
                                                        <!-- End .ratings-val -->
                                                    </div>
                                                    <!-- End .ratings -->
                                                </div>
                                                <!-- End .rating-container -->
                                                <span class="review-date">5 days ago</span>
                                            </div>
                                            <!-- End .col -->
                                            <div class="col">
                                                <h4>Very good</h4>

                                                <div class="review-content">
                                                    <p>
                                                        Sed, molestias, tempore? Ex dolor esse iure
                                                        hic veniam laborum blanditiis laudantium iste
                                                        amet. Cum non voluptate eos enim, ab cumque
                                                        nam, modi, quas iure illum repellendus,
                                                        blanditiis perspiciatis beatae!
                                                    </p>
                                                </div>
                                                <!-- End .review-content -->

                                                <div class="review-action">
                                                    <a href="#"><i class="icon-thumbs-up"></i>Helpful (0)</a>
                                                    <a href="#"><i class="icon-thumbs-down"></i>Unhelpful
                                                        (0)</a>
                                                </div>
                                                <!-- End .review-action -->
                                            </div>
                                            <!-- End .col-auto -->
                                        </div>
                                        <!-- End .row -->
                                    </div>
                                    <!-- End .review -->
                                </div>
                                <!-- End .reviews -->
                            </div>
                            <!-- .End .tab-pane -->
                        </div>
                        <!-- End .tab-content -->
                    </div>
                    <!-- End .product-details-tab -->


                </div>
                <!-- End .col-lg-9 -->

                <aside class="col-lg-3">
                    <div class="sidebar sidebar-product">
                        <div class="widget widget-products">
                            <h4 class="widget-title">Related Product</h4>
                            <!-- End .widget-title -->

                            <div class="products">
                                @foreach($related_products as $product)
                                <div class="product product-sm">
                                    <figure class="product-media">
                                        <a href="{{ route('public.products.show', $product->slug) }}">
                                            <img src="{{ asset($product->image) }}" alt="Product image"
                                                class="product-image" />
                                        </a>
                                    </figure>

                                    <div class="product-body">
                                        <h5 class="product-title">
                                            <a
                                                href="{{ route('public.products.show', $product->slug) }}">{{ $product->name }}</a>
                                        </h5>
                                        <!-- End .product-title -->
                                        <div class="product-price">
                                            <span class="new-price">{{ $product->currency }}
                                                {{ $product->price }}</span>
                                            {{-- <span class="old-price">ETB 110.00</span> --}}
                                        </div>
                                        <!-- End .product-price -->
                                    </div>
                                    <!-- End .product-body -->
                                </div>
                                @endforeach



                            </div>
                            <!-- End .products -->

                            <a href="{{ route('public.category.products.index',$product->category()->slug) }}"
                                class="btn btn-outline-dark-3"><span>View
                                    More Products</span><i class="icon-long-arrow-right"></i></a>
                        </div>
                        <!-- End .widget widget-products -->


                        <!-- End .widget -->
                    </div>
                    <!-- End .sidebar sidebar-product -->
                </aside>
                <!-- End .col-lg-3 -->


            </div>
            <!-- End .row -->
        </div>
        <!-- End .container -->
    </div>
    <!-- End .page-content -->
</main>
