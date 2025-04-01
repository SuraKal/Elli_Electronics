<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Category;
use Illuminate\Validation\Rule;
new #[Layout('components.layouts.admin')] class extends Component{

    public string $name = '';
    public string $description = '';
    public string $status = '';

    public function store()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('categories'),
            ],
            'description' => 'nullable|string',
            'status' => 'required|in:1,0', // Ensure status is either '1' or '0'
        ], [
            'name.unique' => 'Category already exists.',
            'status.in' => 'Status should be either Active or Inactive.',
        ]);

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]); 

        $this->dispatch('category-created');
        $this->reset();
    }
}; ?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>

        <a href="{{ route('admin.store.category.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500" wire:navigate>
            View Categories
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
                            {{ __('Create a category') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your category name is short, descriptive, and unique.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="category-created" message='Category Added'/>
                    

                    <form wire:submit="store" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="name" aria-placeholder="Woodwork Lights, Table Wood Lamp ..."
                                placeholder="Woodwork Lights, Table Wood Lamp ..." required/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />

                            <x-textarea placeholder="Write a description" wire:model="description" name="description"
                                autocomplete="description" class="mt-1 block w-full h-64"></x-textarea>


                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />

                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status"
                                class="mt-1 block w-full" wire:model="status" required />


                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
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
