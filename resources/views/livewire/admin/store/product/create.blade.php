<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component {
    use WithFileUploads;

    public string $name = '';
    public $image = '';
    public string $status = '';
    public string $currency = 'ETB';
    public float $price;
    public ?float $discount_percent = null;
    public bool $is_hotdeal = false;
    public ?string $hotdeal_start = null;
    public ?string $hotdeal_end = null;
    public string $description = '';
    public string $category_id = '';
    public array $selectedTags = []; // Ensure this is explicitly an array
    public array $categories = [];
    public array $tags = [];

    /**
     * Validation rules
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('products', 'name')],
            'category_id' => ['required', 'exists:categories,id'],
            'selectedTags' => ['array'], // Ensure tags is an array
            'selectedTags.*' => ['exists:tags,id'], // Validate each tag exists
            'image' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'status' => 'required|in:1,0',
            'currency' => 'required|in:ETB',
            'price' => ['required', 'numeric'],
            'discount_percent' => ['nullable', 'numeric'],
            'is_hotdeal' => ['boolean'],
            'hotdeal_start' => ['nullable', 'date_format:Y-m-d\TH:i', 'after_or_equal:now', 'required_if:is_hotdeal,true'],
            'hotdeal_end' => ['nullable', 'date_format:Y-m-d\TH:i', 'after:hotdeal_start', 'required_if:is_hotdeal,true'],
            'description' => ['nullable'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages()
    {
        return [
            'status.in' => 'Status should be either Active or Inactive.',
            'currency.in' => 'Currently, only ETB is supported.',
            'hotdeal_start.required_if' => 'A hot deal start date is required when hot deal is enabled.',
            'hotdeal_end.required_if' => 'A hot deal end date is required when hot deal is enabled.',
            'hotdeal_end.after' => 'The hot deal end date must be after the start date.',
            'hotdeal_start.date_format' => 'Invalid format. Use YYYY-MM-DDTHH:MM.',
            'hotdeal_end.date_format' => 'Invalid format. Use YYYY-MM-DDTHH:MM.',
        ];
    }

    /**
     * Create a new product
     */
    public function create()
    {
        $this->validate();

        // Handle image upload
        $image_path = null;
        if ($this->image) {
            $image_path = Storage::disk('public')->put('images/product_images', $this->image);
        }

        // Create product
        $product = Product::create([
            'name' => $this->name,
            'status' => $this->status,
            'image' => $image_path ? "storage/$image_path" : null,
            'currency' => $this->currency,
            'price' => $this->price,
        ]);

        if ($product) {
            // Create product details
            $product->detail()->create([
                'discount_percent' => $this->discount_percent,
                'is_hotdeal' => $this->is_hotdeal,
                'hotdeal_start' => $this->is_hotdeal ? $this->hotdeal_start : null,
                'hotdeal_end' => $this->is_hotdeal ? $this->hotdeal_end : null,
                'additional_info' => $this->description,
            ]);

            // Attach category
            if ($this->category_id) {
                $product->categories()->attach($this->category_id);
            }

            // Attach selected tags
            if (!empty($this->selectedTags)) {
                $product->tags()->sync($this->selectedTags);
            }
        }

        // Dispatch event and reset form
        $this->dispatch('product-created');
        $this->reset();
    }

    /**
     * Fetch categories from the database
     */
    public function fetchCategories()
    {
        $this->categories = Category::where('status', true)
                                    ->orderBy('created_at', 'desc')
                                    ->pluck('name', 'id')
                                    ->toArray();
    }

    /**
     * Fetch tags from the database
     */
    public function fetchTags()
    {
        $this->tags = Tag::where('status', true)
                            ->orderBy('created_at', 'desc')
                            ->pluck('name', 'id')
                            ->toArray();
    }

    /**
     * Lifecycle hook for mounting the component
     */
    public function mount()
    {
        $this->fetchCategories();
        $this->fetchTags();
    }


        #[\Livewire\Attributes\On('product-created')]
    public function refreshNeeded()
    {
        $this->fetchCategories();
        $this->fetchTags();
    }


};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Product') }}
        </h2>
        <a href="{{ route('admin.store.product.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            View Products
        </a>
    </div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Create a new product') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Fill in the details to add a new product.') }}
                        </p>
                    </header>
                    <x-action-message class="me-3" on="product-created" message='Product Created' />
                    <form wire:submit="create" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                required placeholder="Product name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="currency" :value="__('Currency')" />
                            <x-select :options="['ETB' => 'ETB']" selected="ETB" class="mt-1 block w-full" wire:model="currency" required />
                            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input wire:model="price" name="price" type="number" class="mt-1 block w-full" required step="0.01" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="image" :value="__('Image (Max: 10MB)')" />
                            <x-text-input wire:model="image" name="image" type="file" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <div wire:loading wire:target="image" class="text-sm text-blue-500">Uploading...</div>
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status"
                                class="mt-1 block w-full" wire:model="status" required />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <x-select 
                                :options="$categories" 
                                placeholder="Choose Category" 
                                class="mt-1 block w-full" 
                                wire:model="category_id"
                                required 
                            />
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Tags -->
                        <div>
                            <x-input-label for="tag" :value="__('Tag')" />
                            <x-checkbox-group 
                                :options="$tags"
                                :selected="$selectedTags"
                                wire-model="selectedTags"
                            />
                            <x-input-error :messages="$errors->get('selectedTags')" class="mt-2" />
                        </div>


                        

                        <hr>


                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            {{-- <textarea wire:model.defer="description" name="description" class="mt-1 block w-full"
                                rows="3" placeholder="Short description about the courier..."></textarea> --}}

                            <x-textarea placeholder="Write a description" wire:model="description" name="description"
                                autocomplete="description" class="mt-1 block w-full h-64" placeholder="Short description about the product..."></x-textarea>

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="discount_percent" :value="__('Discount Value In Percent (If any (Max 100))')" />
                            <x-text-input wire:model="discount_percent" name="discount_percent" type="number" step="0.01" class="mt-1 block w-full"
                                autocomplete="discount_percent" min="0" max="100"/>
                            <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
                        </div>

<div x-data="{ showHotdeal: @entangle('is_hotdeal') }">
    <x-input-label for="is_hotdeal" :value="__('Does it have a hot deal date (Check if any)')" />
    {{-- <input type="checkbox" wire:model="is_hotdeal" x-model="showHotdeal" class="mt-1" /> --}}

    <x-text-input wire:model="is_hotdeal" x-model="showHotdeal" type="checkbox" class="mt-1 block w-50 h-50"
                    />

    <x-input-error :messages="$errors->get('is_hotdeal')" class="mt-2" />

    <!-- Show these fields dynamically using Alpine -->
    <div x-show="showHotdeal" x-cloak> 
        <div class="mt-4">
            <x-input-label for="hotdeal_start" :value="__('Starting date')" />
            <x-text-input wire:model="hotdeal_start" name="hotdeal_start" type="datetime-local" class="mt-1 block w-full"
                autocomplete="hotdeal_start" />
            <x-input-error :messages="$errors->get('hotdeal_start')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="hotdeal_end" :value="__('End date')" />
            <x-text-input wire:model="hotdeal_end" name="hotdeal_end" type="datetime-local" class="mt-1 block w-full"
                autocomplete="hotdeal_end" />
            <x-input-error :messages="$errors->get('hotdeal_end')" class="mt-2" />
        </div>
    </div>
</div>






                        <div class="flex items-center gap-4">
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="create">
                                {{ __('Create') }}
                            </x-primary-button>
                            <x-loader target="create" content="Creating..." />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>