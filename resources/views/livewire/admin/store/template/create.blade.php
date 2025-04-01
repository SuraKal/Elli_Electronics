<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Template;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component {

    public string $name = '';
    public bool $status = true;
    public string $note = '';
    public array $criteria = []; // Main criteria (e.g., Color, Size)
    public array $subCriteria = []; // Sub-criteria (e.g., Red, Blue, Small, Medium)

    public function addCriterion()
    {
        $this->criteria[] = ''; // Add a new empty criterion
    }

    public function removeCriterion($index)
    {
        unset($this->criteria[$index]); // Remove a criterion at the given index
        unset($this->subCriteria[$index]); // Remove associated sub-criteria
    }

    public function addSubCriterion($criterionIndex)
    {
        $this->subCriteria[$criterionIndex][] = ['name' => '', 'status' => 'inactive']; // Add a new sub-criterion with 'inactive' status by default
    }

    public function removeSubCriterion($criterionIndex, $subCriterionIndex)
    {
        unset($this->subCriteria[$criterionIndex][$subCriterionIndex]); // Remove sub-criterion at the given index
    }

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('templates'),
            ],
            'note' => 'string|nullable|max:25',
            'criteria' => 'required|array', // Ensure criteria are provided
            'criteria.*' => 'string|distinct|min:3', // Ensure each criterion is unique and at least 3 characters
        ], [
            'name.unique' => 'Templates already exist.',
            'note.max' => 'Decrease your notes to be only 25 words.',
            'criteria.*.min' => 'Each criterion must be at least 3 characters long.',
        ]);

        // Construct the structure with criteria and their sub-criteria
        $structure = [];
        foreach ($this->criteria as $index => $criterion) {
            $subCriteriaValues = [];
            foreach ($this->subCriteria[$index] ?? [] as $subCriterion) {
                // Use the name and status of each sub-criterion
                $subCriteriaValues[$subCriterion['name']] = $subCriterion['status'];
            }
            $structure[$criterion] = $subCriteriaValues;
        }

        // Store the structure as a JSON string in the database
        Template::create([
            'name' => $this->name,
            'status' => $this->status,
            'note' => $this->note,
            'structure' => json_encode($structure), // Store structure in the desired format
        ]);

        $this->dispatch('templates-created');
        $this->reset();
    }
};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Template') }}
        </h2>

        <a href="{{ route('admin.store.template.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500" wire:navigate>
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
                            {{ __('Create a Template') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your templates name is short, descriptive, and unique.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="templates-created" timeout="5000" message='Template Added.'/>

                    <form wire:submit="store" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="name" aria-placeholder="Painting, Cloth, Dress Templates ..."
                                placeholder="Painting, Cloth, Dress Templates ..." required/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="note" :value="__('Note (Max: 25 letters) Optional')" />
                            <x-text-input wire:model="note" name="note" type="text" class="mt-1 block w-full"
                                autocomplete="note"
                                placeholder="Make it short and describes the purpose of the template" />
                            <x-input-error :messages="$errors->get('note')" class="mt-2" />
                        </div>

                        <div>
                            <h3 class="text-md font-medium text-gray-900">Criteria</h3>
                            @foreach($criteria as $index => $criterion)
                                <div class="flex items-center gap-4">
                                    <input type="text" wire:model="criteria.{{ $index }}" class="mt-1 block w-full"
                                           placeholder="Enter a criterion" />
                                    <button type="button" wire:click="removeCriterion({{ $index }})" class="text-red-600">Remove</button>
                                </div>
                                <div class="ml-6">
                                    <h4 class="text-sm font-medium text-gray-700">Sub-Criteria</h4>
                                    @foreach($subCriteria[$index] ?? [] as $subIndex => $subCriterion)
                                        <div class="flex items-center gap-4">
                                            <input type="text" wire:model="subCriteria.{{ $index }}.{{ $subIndex }}.name" class="mt-1 block w-full"
                                                   placeholder="Enter a sub-criterion" />
                                            <select wire:model="subCriteria.{{ $index }}.{{ $subIndex }}.status" class="mt-1 block w-full">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                            <button type="button" wire:click="removeSubCriterion({{ $index }}, {{ $subIndex }})" class="text-red-600">Remove</button>
                                        </div>
                                    @endforeach
                                    <button type="button" wire:click="addSubCriterion({{ $index }})" class="text-blue-600">Add Sub-Criterion</button>
                                </div>
                            @endforeach
                            <button type="button" wire:click="addCriterion" class="text-blue-600">Add Criterion</button>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="store">
                                {{ __('Create') }}
                            </x-primary-button>
                            <x-loader target="store" content="Create"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
