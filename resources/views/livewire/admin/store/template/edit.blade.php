<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Template;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component
{
    public Template $template;
    public string $name = '';
    public string $note = '';
    public string $status = '1'; // Default to Active ('1' = Active, '0' = Inactive)
    public array $criteria = [];
    public array $subCriteria = [];
    public string $templateId = '';

    public function mount(Template $template)
    {
        // Use fill() to populate the component's properties with the template data
        $this->fill($template);

        $this->templateId = $this->template->id;

        $this->status = (string) $this->template->status; // Ensure status is treated as a string

        // Decode the structure and populate criteria and sub-criteria
        $structure = json_decode($this->template->structure, true);

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
// Rule::unique('templates')->ignore($this->templateId),
    public function update()
    {
        // Validate input data
        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('templates')->ignore($this->templateId),
            ],
            'note' => 'nullable|string|max:25',
            'status' => 'required|in:1,0', // Ensure status is either '1' or '0'
            // 'criteria' => 'required|array|min:1',
            // 'criteria.*' => 'string|distinct|min:3',
            // 'subCriteria.*.*.name' => 'required|string|min:3',
            // 'subCriteria.*.*.status' => 'required|in:active,inactive',
        ], [
            'status.in' => 'Status should be either Active or Inactive.',
        ]);

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

        // Fetch the latest template instance
        $template = Template::findOrFail($this->templateId);

        // Update the template instance
        $template->update([
            'name' => $this->name,
            'status' => (int) $this->status, // Convert back to integer for the database
            'note' => $this->note,
            'structure' => json_encode($structure),
        ]);

        // Refresh the component data
        $this->fill($template->fresh()->toArray());

        // Dispatch Event & Notify
        $this->dispatch('templates-updated');
    }

};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Template') }}
        </h2>

        <a href="{{ route('admin.store.template.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            View Templates
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
                            {{ __('Edit Template: ') }} {{ $name }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Modify the template details and criteria.') }}
                        </p>
                    </header>

                    <x-action-message on="templates-updated" message="Template Updated Successfully." />

                    <form wire:submit.prevent="update" class="mt-6 space-y-6">
                        @csrf

                        <!-- Template Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input 
                                wire:model="name" 
                                id="name" 
                                name="name" 
                                type="text" 
                                class="mt-1 block w-full" 
                                placeholder="Enter template name" 
                                required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Template Note -->
                        <div>
                            <x-input-label for="note" :value="__('Note (Max: 25 characters)')" />
                            <x-text-input 
                                wire:model="note" 
                                id="note" 
                                name="note" 
                                type="text" 
                                class="mt-1 block w-full" 
                                placeholder="Enter a short description (optional)" />
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />

                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status"
                                class="mt-1 block w-full" wire:model="status" required />


                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

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
