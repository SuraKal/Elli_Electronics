<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\ProductTemplate;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component
{
    public Product $product;
    public string $product_name = '';
    public string $product_id;
    public array $criteria = [];
    public array $subCriteria = [];

    public function mount(Product $product)
    {
        $this->product_id = $this->product->id;
        $this->product_name = $this->product->name;
        // Decode the structure and populate criteria and sub-criteria
        $structure = json_decode($this->product->template->first()->structure, true);

        if (is_array($structure)) {
            foreach ($structure as $criterion => $subCriteriaValues) {
                $this->criteria[] = $criterion;
                $this->subCriteria[] = array_map(function ($name, $status) {
                    return ['name' => $name, 'status' => $status];
                }, array_keys($subCriteriaValues), array_values($subCriteriaValues));
            }
        }


        


    }

    public function addCriterion()
    {
        // Add a new empty criterion and initialize its sub-criteria array
        $this->criteria[] = '';
        $this->subCriteria[] = [];
    }

    public function removeCriterion($index)
    {
        // Remove a criterion and its associated sub-criteria
        unset($this->criteria[$index]);
        unset($this->subCriteria[$index]);
    }

    public function addSubCriterion($criterionIndex)
    {
        // Add a new sub-criterion with default values
        $this->subCriteria[$criterionIndex][] = ['name' => '', 'status' => 'inactive'];
    }

    public function removeSubCriterion($criterionIndex, $subIndex)
    {
        // Remove a specific sub-criterion
        unset($this->subCriteria[$criterionIndex][$subIndex]);
    }
// Rule::unique('products')->ignore($this->product_id),
    public function update()
    {


        // Construct the structure JSON
        $structure = [];
        foreach ($this->criteria as $index => $criterion) {
            if (!empty($criterion)) {
                $subCriteriaValues = [];
                foreach ($this->subCriteria[$index] ?? [] as $subCriterion) {
                    if (!empty($subCriterion['name'])) {
                        $subCriteriaValues[$subCriterion['name']] = $subCriterion['status'];
                    }
                }
                $structure[$criterion] = $subCriteriaValues;
            }
        }

        // Fetch the latest product instance
        // Try to find an existing record matching both product_id and template_id
        $existingProductTemplate = ProductTemplate::where('product_id', $this->product_id)
                                                    ->first();

        // If the record exists and the structure has changed, update it
        if ($existingProductTemplate) {
            // Only update if the structure is different
            if ($existingProductTemplate->structure !== $structure) {
                $existingProductTemplate->update([
                    'structure' =>$structure
                ]);
            }
        } 

        // Refresh the component data
        $this->fill($this->product->fresh()->toArray());

        // Dispatch Event & Notify
        session()->flash('template_updated', true); // Flash session variable
        return redirect()->route('admin.store.product.edit', $this->product->uuid);

    }

};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Template for ' ) }} {{ $product_name }}
        </h2>

        <a href="{{ route('admin.store.product.edit',$product->uuid) }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            Show Product
        </a>
    </div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        
                        <p class="mt-1 text-lg text-gray-900">
                            {{ __('Modify the template to fit products criteria.') }}
                        </p>
                    </header>

                    <x-action-message on="template-updated" message="Template Updated Successfully." />

                    <form wire:submit.prevent="update" class="mt-6 space-y-6">


                        <!-- Criteria Section -->
                        <div>
                            <h3 class="text-md font-medium text-gray-900">Criteria</h3>
                            @foreach($criteria as $index => $criterion)
                                <div class="flex items-center gap-4">
                                    <x-text-input 
                                        wire:model="criteria.{{ $index }}" 
                                        placeholder="Enter a criterion" 
                                        class="mt-1 block w-full" />
                                    <button type="button" wire:click="removeCriterion({{ $index }})"
                                            class="text-red-600">Remove</button>
                                </div>

                                <!-- Sub-Criteria -->
                                <div class="ml-6">
                                    <h4 class="text-sm font-medium text-gray-700">Sub-Criteria</h4>
                                    @foreach($subCriteria[$index] ?? [] as $subIndex => $subCriterion)
                                        <div class="flex items-center gap-4">
                                            <x-text-input 
                                                wire:model="subCriteria.{{ $index }}.{{ $subIndex }}.name"
                                                placeholder="Enter a sub-criterion"
                                                class="mt-1 block w-full" />
                                            <select wire:model="subCriteria.{{ $index }}.{{ $subIndex }}.status"
                                                    class="mt-1 block w-full">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <button type="button"
                                                    wire:click="removeSubCriterion({{ $index }}, {{ $subIndex }})"
                                                    class="text-red-600">Remove</button>
                                        </div>
                                    @endforeach
                                    <button type="button"
                                            wire:click="addSubCriterion({{ $index }})"
                                            class="text-blue-600">Add Sub-Criterion</button>
                                </div>
                            @endforeach
                            <button type="button" wire:click="addCriterion"
                                    class="text-blue-600">Add Criterion</button>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4">
                            {{-- <x-primary-button>{{ __('Update') }}</x-primary-button> --}}
                            <x-primary-button wire:loading.remove wire:target="update">
                                {{ __('Update') }}
                            </x-primary-button>
                            <x-loader target="update" content="Updating"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
