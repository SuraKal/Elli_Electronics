<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Productdetail;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


new #[Layout('components.layouts.admin')] class extends Component{
    use WithFileUploads;

    public Product $product;
    public string $name = '';
    public $image = '';
    public string $status = '';
    public string $currency = 'ETB';
    public float $price;
    public float $discount_percent;

    public bool $is_hotdeal = false;
    public ?string $hotdeal_start = null;
    public ?string $hotdeal_end = null;

    public string $description;

    public $templateStructure;

    // public string $category_id = '';
    public ?string $category_id = null;

    public array $categories = [];


    public array $selectedTags = []; // Ensure this is explicitly an array
    public array $tags = [];


    public function mount(Product $product)
    {
        // Check if session flash exists and dispatch event
        $this->product = $product;

        // Load existing product data
        $this->name = $product->name;
        $this->status = (string) $product->status;
        $this->currency = $product->currency;
        $this->price = $product->price;
        $this->discount_percent = optional($product->detail)->discount_percent ?? 0;
        $this->is_hotdeal = optional($product->detail)->is_hotdeal ?? false;
        $this->hotdeal_start = optional($product->detail)->hotdeal_start ?? null;
        $this->hotdeal_end = optional($product->detail)->hotdeal_end ?? null;
        $this->description = optional($product->detail)->additional_info ?? '';


        $this->category_id = $this->product?->category()?->id;
        
        if (session()->has('template_updated')) {
            $this->dispatch('template-updated');
        }



        $this->fetchCategories();
        $this->fetchTags();
        $this->fetchTemplates();
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string',Rule::unique('products', 'name')->ignore($this->product->id)],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'status' => 'required|in:1,0',
            'currency' => 'required|in:ETB',
            'price' => ['required', 'numeric'],
            'discount_percent' => ['required'],
            'is_hotdeal' => ['boolean'],
            'hotdeal_start' => ['nullable', 'required_if:is_hotdeal,true'],
            'hotdeal_end' => ['nullable', 'required_if:is_hotdeal,true'],
            'description' => ['nullable','string'],
            'category_id' => 'required|string|exists:categories,id',
            'selectedTags' => ['array'], // Ensure tags is an array
            'selectedTags.*' => ['exists:tags,id'], // Validate each tag exists
        ];
    }

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
            'category_id.required' => 'Please select a category for the product.',
            'category_id.exists' => 'The selected category does not exist.',
        ];
    }

    public function update()
    {
        $this->validate();

        if ($this->image) {
            // Update image if a new one is uploaded
            Storage::disk('public')->delete(str_replace('storage/', '', $this->product->image));
            $image_path = 'storage/' . $this->image->store('images/product_images', 'public');
            $this->product->update(['image' => $image_path]);
        }

        // Update product details
        $this->product->update([
            'name' => $this->name,
            'status' => (int) $this->status,
            'currency' => $this->currency,
            'price' => (float) $this->price,
        ]);

        // Update or create product detail
        if ($this->product->detail) {
            $this->product->detail()->update([
                'discount_percent' => (float) $this->discount_percent,
                'is_hotdeal' => (bool) $this->is_hotdeal,
                'hotdeal_start' => (bool) $this->is_hotdeal ? $this->hotdeal_start : null,
                'hotdeal_end' => (bool) $this->is_hotdeal ? $this->hotdeal_end : null,
                'additional_info' => (string) $this->description,
            ]);
        } else {
            // Create detail if it doesn't exist
            $this->product->detail()->create([
                'discount_percent' => (float) $this->discount_percent,
                'is_hotdeal' => (bool) $this->is_hotdeal,
                'hotdeal_start' => (bool) $this->is_hotdeal ? $this->hotdeal_start : null,
                'hotdeal_end' => (bool) $this->is_hotdeal ? $this->hotdeal_end : null,
                'additional_info' => (string) $this->description,
            ]);
        }


        if ($this->product) {

            // Attach category
            if ($this->category_id) {
                $existingCategory = $this->product->category(); // Use the category() method you defined in the Product model

                if ($existingCategory === null) {
                    // No category exists, so attach the new one
                    $this->product->categories()->attach($this->category_id);
                } else {
                    // Category exists, so sync the relationship.  This will *replace* the existing category with the new one.
                    $this->product->categories()->sync([$this->category_id]); // sync expects an array of ids
                }
            }

            // Tag logic
            if (!empty($this->selectedTags)) {
                $existingTags = $this->product->tags->pluck('id')->toArray();
                
                $tagsToAdd = array_diff($this->selectedTags, $existingTags);
                $tagsToRemove = array_diff($existingTags, $this->selectedTags);

                // Attach new tags
                if (!empty($tagsToAdd)) {
                    $this->product->tags()->attach($tagsToAdd);
                }

                // Detach tags
                if (!empty($tagsToRemove)) {
                    $this->product->tags()->detach($tagsToRemove);
                }
            } else {
                // No tags selected, detach all existing tags
                $this->product->tags()->detach();
            }

            // Attach selected tags
            // if (!empty($this->selectedTags)) {
            //     $product->tags()->sync($this->selectedTags);
            // }

            // Attach selected tags
            // if (!empty($this->selectedTags)) {
            //     $product->tags()->sync($this->selectedTags);
            // }
        }

        // 'category_id' => $this->category_id,
        // Dispatch event and reset form
        $this->dispatch('product-edited');
        $this->reset('image');


    }


    public function displayBoxStructure($array)
    {
        echo '<ul class="list-inside pl-4">';
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                echo '<li class="mb-2"><strong class="text-lg font-semibold text-blue-600">' . ucfirst($key) . ':</strong>';
                echo '<ul class="ml-4 mt-2">';
                $this->displayBoxStructure($value);  // Recursively call the function
                echo '</ul>';
                echo '</li>';
            } else {
                echo '<li class="mb-1"><strong class="text-gray-800">' . ucfirst($key) . ':</strong> <span class="text-gray-600">' . ucfirst($value) . '</span></li>';
            }
        }
        echo '</ul>';
    }




    public function fetchTemplates()
    {   
        // dd($this->product->template);
        $this->product->load('template'); // Reload relationship
        // $this->product = Product::find($this->product->id);
        $this->templateStructure = optional($this->product->template->first())->structure ?? [];
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

        $this->selectedTags = $this->product->tags->pluck('id')->toArray();
        //
        //

        // dd($this->product->tags->pluck('id')->toArray());
    }




    #[\Livewire\Attributes\On('template-updated')]
    public function refreshTemplates()
    {
        $this->fetchTemplates();
        
    }



    public function fetchCategories()
    {
        $this->categories = Category::all()->mapWithKeys(function ($category) {
            return [$category->id => $category->name];
        })->toArray() ?: ['' => 'No category available'];
    }

    #[\Livewire\Attributes\On('product-edited')]
    public function refreshCategories()
    {
        $this->fetchCategories();
        $this->fetchTags();

    }




}; 




?>




<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>

        <div>
            <a href="{{ route('admin.store.product.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                wire:navigate>
                View Products
            </a>
            <a href="{{ route('admin.store.product.template', $product->uuid) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                wire:navigate>
                Customize Template
            </a>

        </div>



    </div>
</x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Edit a product') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your product credentials are correct. ') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="product-edited" message='Product Edited'/>
                    <x-action-message class="me-3" on="template-updated" message='Template Updated'/>


                    <form wire:submit="update" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="name" required placeholder="Cable eurocable, Junction box" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Category')" />

                            <x-select :options="$categories" placeholder="Choose Category" class="mt-1 block w-full"
                                wire:model="category_id" />

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



                        <div>
                            <x-input-label for="currency" :value="__('Currency')" />

                            <x-select :options="['ETB' => 'ETB']" selected="ETB" class="mt-1 block w-full"
                                wire:model="currency" required />

                            <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input wire:model="price" name="price" class="mt-1 block w-full" autocomplete="price"
                                required type="number" step="0.01" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Image(Must be < 10MB)')" />
                            <x-text-input wire:model="image" name="image" type="file" class="mt-1 block w-full"
                                autocomplete="image" />
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            <div wire:loading wire:target="image" class="text-sm text-blue-500">Uploading...</div>

                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />

                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status"
                                class="mt-1 block w-full" wire:model="status" required />


                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>


                        <hr>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            {{-- <textarea wire:model.defer="description" name="description" class="mt-1 block w-full"
                                rows="3" placeholder="Short description about the courier..."></textarea> --}}

                            <x-textarea placeholder="Write a description" wire:model="description" name="description"
                                autocomplete="description" class="mt-1 block w-full h-64"
                                placeholder="Short description about the product..."></x-textarea>

                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="discount_percent"
                                :value="__('Discount Value In Percent (If any (Max 100))')" />
                            <x-text-input wire:model="discount_percent" name="discount_percent" type="number"
                                step="0.01" class="mt-1 block w-full" autocomplete="discount_percent" min="0"
                                max="100" />
                            <x-input-error :messages="$errors->get('discount_percent')" class="mt-2" />
                        </div>

                        <div x-data="{ showHotdeal: @entangle('is_hotdeal') }">
                            <x-input-label for="is_hotdeal"
                                :value="__('Does it have a hot deal date (Check if any)')" />

                            <!-- Checkbox to toggle hot deal -->
                            <input type="checkbox" wire:model="is_hotdeal" x-model="showHotdeal"
                                class="mt-1 block w-6 h-6" />

                            <x-input-error :messages="$errors->get('is_hotdeal')" class="mt-2" />

                            <!-- Show these fields dynamically using Alpine -->
                            <div x-show="showHotdeal" x-cloak>
                                <!-- Hot Deal Start Date -->
                                <div class="mt-4">
                                    <x-input-label for="hotdeal_start" :value="__('Starting date')" />
                                    <x-text-input wire:model.defer="hotdeal_start" name="hotdeal_start"
                                        type="datetime-local" class="mt-1 block w-full" autocomplete="hotdeal_start" />
                                    <x-input-error :messages="$errors->get('hotdeal_start')" class="mt-2" />
                                </div>

                                <!-- Hot Deal End Date -->
                                <div class="mt-4">
                                    <x-input-label for="hotdeal_end" :value="__('End date')" />
                                    <x-text-input wire:model.defer="hotdeal_end" name="hotdeal_end"
                                        type="datetime-local" class="mt-1 block w-full" autocomplete="hotdeal_end" />
                                    <x-input-error :messages="$errors->get('hotdeal_end')" class="mt-2" />
                                </div>
                            </div>
                        </div>


                        <div class="flex items-center gap-4">
                            <!-- Default Login Button -->
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="update">
                                {{ __('Update') }}
                            </x-primary-button>
                            <x-loader target="update" content="Update" />
                        </div>
                    </form>



                    @if (!empty($product->hasTemplate()))
                    <hr class="my-4">
                    <section>

                        <div class="flex justify-between items-center my-4">
                            <h4 class="text-blue-600 cursor-pointer font-medium text-lg">
                                View Product Structure
                            </h4>
                            {{-- <x-primary-button class="ms-3" href="{{ route('admin.store.product.template.edit', $product->uuid) }}">
                                {{ __('Edit') }}
                            </x-primary-button> --}}


                            <a href="{{ route('admin.store.product.template.edit', $product->uuid) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Edit
                            </a>

                        </div>
                        
                        

                        <div class="mt-2 bg-gray-100 p-4 border border-gray-300 rounded-lg">
                            <!-- Displaying Nested Structure -->
                            
                            @php
                                $this->displayBoxStructure(json_decode($templateStructure, true));
                            @endphp

                        </div>

                    </section>

                    @endif
                </section>
            </div>
        </div>
    </div>
</div>
