<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Template;
use App\Models\ProductTemplate;


new #[Layout('components.layouts.admin')] class extends Component {
    //
    public Product $product;
    public string $product_name;
    public int $product_id;
    public $templates = [];

    public $selected_template = '';

    public function mount(Product $product)
    {
        $this->product_name = $product->name;
        $this->product_id = $product->id;
        $this->templates = Template::where('status', 1)
            ->whereNotNull('structure')
            ->latest()
            ->get();
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


    public function store()
    {
        // Find the template by selected_template
        $template = Template::find($this->selected_template);

        // If no template is found, handle that scenario
        if (!$template) {
            $this->dispatch('template-notfound');
            return;
        }

        $structure = $template->structure;

        // Try to find an existing record matching both product_id and template_id
        $existingProductTemplate = ProductTemplate::where('product_id', $this->product_id)
                                                    ->first();

        // If the record exists and the structure has changed, update it
        if ($existingProductTemplate) {
            // Only update if the structure is different
            if ($existingProductTemplate->structure !== $structure) {
                $existingProductTemplate->update([
                    'template_id' => $this->selected_template,
                    'structure' => $structure
                ]);
            }
        } else {
            // If no record exists, create a new one
            ProductTemplate::create([
                'product_id' => $this->product_id,
                'template_id' => $this->selected_template,
                'structure' => $structure,
            ]);
        }

        // Dispatch an event after successfully storing/updating the template
        $this->dispatch('template-set');
    }




}; ?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Templates') }}
        </h2>

        <div>
            <a href="{{ route('admin.store.product.edit', $product->uuid) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                wire:navigate>
                Show Product
            </a>
            <a href="{{ route('admin.store.product.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
                wire:navigate>
                List Products
            </a>
        </div>
    </div>
</x-slot>



<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="w-100">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Choose a template for ' . $product_name) }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure the template information aligns with the product specification.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="template-set" message="Success" />
                    <x-action-message class="me-3" on="template-notfound" message="Template not found"  type="failure" />

                    <div class="container pb-5">
                        <form wire:submit="store" id="templateForm">
                            <!-- Submit Button Section -->
                            <div class="text-end mt-6">
                                <!-- Default Login Button -->
                                <x-primary-button class="ms-3" wire:loading.remove wire:target="store">
                                    {{ __('Set Template') }}
                                </x-primary-button>

                                <x-loader target="store" content="Setting Template" />
                            </div>

                            {{-- <input type="text" class="hidden" id="product_id" name="product_id"
                                value="{{ $product_id }}" /> --}}

                            <!-- Template Grid Section -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach( $templates as $template )
                                <div class="my-6">
                                    <!-- Template Card -->
                                    <label class="cursor-pointer text-lg font-semibold text-gray-800"
                                        for="template{{ $template->id }}">
                                        <div
                                            class="bg-white shadow-lg rounded-lg overflow-hidden p-6 hover:shadow-xl transition-shadow duration-300">
                                            <!-- Template Header -->
                                            <div class="flex items-center space-x-3 mb-4">
                                                <input type="radio" class="form-radio text-blue-600 w-6 h-6"
                                                    wire:model="selected_template" id="template{{ $template->id }}"
                                                    value="{{ $template->id }}" required />

                                                <label class="cursor-pointer text-lg font-semibold text-gray-800"
                                                    for="template{{ $template->id }}">
                                                    {{ htmlspecialchars($template->name) }}
                                                </label>
                                            </div>

                                            <!-- Template Structure Section -->
                                            @if (!empty($template->structure))
                                            <details class="mt-4">
                                                <summary class="text-blue-600 cursor-pointer font-medium">View Structure
                                                </summary>
                                                <div class="mt-2 bg-gray-100 p-4 border border-gray-300 rounded-lg">
                                                    <!-- Displaying Nested Structure -->
                                                    @php
                                                    $this->displayBoxStructure(json_decode($template->structure, true));
                                                    @endphp
                                                </div>
                                            </details>
                                            @endif
                                        </div>
                                    </label>
                                </div>
                                @endforeach
                            </div>


                        </form>
                    </div>





                </section>
            </div>
        </div>
    </div>
</div>
