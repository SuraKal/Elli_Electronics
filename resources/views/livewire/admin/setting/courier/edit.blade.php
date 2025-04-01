<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Courier;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;


new #[Layout('components.layouts.admin')] class extends Component{
    use WithFileUploads;

    public Courier $courier;
    public string $courierId;
    public string $name = '';
    public $logo = '';
    public $previous_image = '';
    public $courier_image = '';
    public $status = '';


    public string $contact_phone = '';
    public string $contact_email = '';

    public string $address = '';
    public string $description = '';
    public $is_featured = '';

    


    public function mount()
    {
        $this->courierId = $this->courier->id;
        $this->name = $this->courier->name;
        $this->status = $this->courier->status;
        $this->contact_phone = $this->courier->contact_phone;
        $this->contact_email = $this->courier->contact_email;
        $this->previous_image = $this->courier->logo ?? '';

        $this->address = $this->courier->address;
        $this->description = $this->courier->description;
        $this->is_featured = $this->courier->is_featured;

    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'logo' => 'nullable|sometimes|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:1,0', // Ensure status is either '1' or '0' 
            'is_featured' => 'required|in:1,0', // Ensure status is either '1' or '0' 
            'contact_phone' => [
                'required',
                'string',
            ],
            'contact_email' => [
                'required',
                'email',
                'string',
            ],
            'address' => [
                'nullable',
                'string',
            ],
            'description' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Status should be either Active or Inactive.',
            'is_featured.in' => 'Featured should be either Yes or No.',
        ];
    }

    public function update()
    {
        $this->validate();

        $courier_image = $this->previous_image;
        // ✅ Handle Image Upload
        if ($this->logo) {
            // Delete the previous logo if it exists
            if ($this->previous_image && Storage::disk('public')->exists(str_replace('storage/', '', $this->previous_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $this->previous_image));
            }

            // Store new logo
            $courier_image = 'storage/' . $this->logo->store('images/courier_logos/', 'public');
        } else {
            $courier_image = $this->previous_image;
        }



        // ✅ Update the courier with the new image path
        $this->courier->update([
            'name' => $this->name,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            'logo' => $courier_image,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'address' => $this->address,
            'description' => $this->description,
        ]);

        $this->dispatch('courier-edited');
        $this->reset('logo');
    }




}; 




?>




<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courier') }}
        </h2>

        <a href="{{ route('admin.setting.courier.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            View Couriers
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
                            {{ __('Edit a courier') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your courier credentials are correct. ') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="courier-edited" message='Courier Edited' />


                    <form wire:submit="update" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="name" :value="__('Courier Name')" />
                            <x-text-input wire:model.defer="name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="name" required placeholder="DHL, FedEx, UPS" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contact_phone" :value="__('Contact Phone')" />
                            <x-text-input wire:model.defer="contact_phone" name="contact_phone" type="text"
                                class="mt-1 block w-full" autocomplete="contact_phone" required
                                placeholder="+1234567890" />
                            <x-input-error :messages="$errors->get('contact_phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contact_email" :value="__('Contact Email')" />
                            <x-text-input wire:model.defer="contact_email" name="contact_email" type="email"
                                class="mt-1 block w-full" autocomplete="contact_email" required
                                placeholder="example@courier.com" />
                            <x-input-error :messages="$errors->get('contact_email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input wire:model.defer="address" name="address" type="text"
                                class="mt-1 block w-full" autocomplete="address"
                                placeholder="123 Courier St, City, Country" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            {{-- <textarea wire:model.defer="description" name="description" class="mt-1 block w-full"
                                rows="3" placeholder="Short description about the courier..."></textarea> --}}

                            <x-textarea placeholder="Write a description"  wire:model.defer="description" name="description"
                                autocomplete="description" class="mt-1 block w-full h-64" placeholder="Short description about the courier..."></x-textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="logo" :value="__('Logo(Must be < 2MB)')" />
                            <x-text-input wire:model="logo" name="logo" type="file" class="mt-1 block w-full"
                                autocomplete="logo" />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            <div wire:loading wire:target="logo" class="text-sm text-blue-500">Uploading...</div>
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status"
                                class="mt-1 block w-full" wire:model.defer="status" required />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="is_featured" :value="__('Featured')" />
                            <x-select :options="['1' => 'Yes', '0' => 'No']" placeholder="Choose Option"
                                class="mt-1 block w-full" wire:model.defer="is_featured" required />
                            <x-input-error :messages="$errors->get('is_featured')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="update">
                                {{ __('Update') }}
                            </x-primary-button>

                            <x-loader target="update" content="Updating..." />
                        </div>

                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
