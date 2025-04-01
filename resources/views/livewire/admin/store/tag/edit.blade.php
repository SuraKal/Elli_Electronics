<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Tag;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component {
    public string $name = '';
    public string $status = '';
    public ?int $tagId = null;

    public function mount(Tag $tag)
    {
        $this->tagId = $tag->id;
        $this->name = $tag->name;
        $this->status = (string) $tag->status;
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('tags')->ignore($this->tagId),
            ],
            'status' => 'required|in:1,0',
        ], [
            'name.unique' => 'Tag already exists.',
            'status.in' => 'Status should be either Active or Inactive.',
        ]);

        Tag::where('id', $this->tagId)->update([
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->dispatch('tag-updated');
    }
};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Tag') }}
        </h2>

        <a href="{{ route('admin.store.tag.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500" wire:navigate>
            View Tags
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
                            {{ __('Edit Tag') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Modify the tag details and save your changes.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="tag-updated" message='Tag Updated'/>

                    <form wire:submit="update" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                required/>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />

                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status"
                                class="mt-1 block w-full" wire:model="status" required />

                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="update">
                                {{ __('Update') }}
                            </x-primary-button>

                            <x-loader target="update" content="Update"/>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
