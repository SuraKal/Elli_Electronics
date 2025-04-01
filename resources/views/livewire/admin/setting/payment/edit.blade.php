<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;


new #[Layout('components.layouts.admin')] class extends Component{
    use WithFileUploads;

    public Payment $payment;
    public string $paymentId;
    public string $method = '';
    public $logo = '';
    public $previous_image = '';
    public $payment_image = '';
    public $status = '';


    public string $acc_name = '';
    public string $acc_number = '';


    public function mount()
    {
        $this->paymentId = $this->payment->id;
        $this->method = $this->payment->method;
        $this->status = $this->payment->status;
        $this->acc_name = $this->payment->acc_name;
        $this->acc_number = $this->payment->acc_number;
        $this->previous_image = $this->payment->logo ?? '';

    }

    public function rules()
    {
        return [
            'method' => [
                'required',
                'string',
            ],
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:1,0', // Ensure status is either '1' or '0' 
            'acc_name' => [
                'required',
                'string',
            ],
            'acc_number' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Status should be either Active or Inactive.',
        ];
    }

    public function update()
    {
        $this->validate();

        $payment_image = $this->previous_image;
        // ✅ Handle Image Upload
        if ($this->logo) {
            // Delete the previous logo if it exists
            if ($this->previous_image && Storage::disk('public')->exists(str_replace('storage/', '', $this->previous_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $this->previous_image));
            }

            // Store new logo
            $payment_image = 'storage/' . $this->logo->store('images/payment_logos/', 'public');
        } else {
            $payment_image = $this->previous_image;
        }



        // ✅ Update the payment with the new image path
        $this->payment->update([
            'method' => $this->method,
            'status' => $this->status,
            'logo' => $payment_image,
            'acc_name' => $this->acc_name,
            'acc_number' => $this->acc_number,

        ]);

        $this->dispatch('payment-edited');

        $this->reset('logo');
    }




}; 




?>




<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>

        <a href="{{ route('admin.setting.payment.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            View Payments
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
                            {{ __('Edit a payment') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your payment credentials are correct. ') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="payment-edited" message='Payment Edited' />


                    <form wire:submit="update" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="method" :value="__('Method')" />
                            <x-text-input wire:model="method" name="method" type="text" class="mt-1 block w-full"
                                autocomplete="method" required placeholder="Awash, CBE" />
                            <x-input-error :messages="$errors->get('method')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="acc_name" :value="__('Account name')" />
                            <x-text-input wire:model="acc_name" name="acc_name" type="text" class="mt-1 block w-full"
                                autocomplete="acc_name" required />
                            <x-input-error :messages="$errors->get('acc_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="acc_number" :value="__('Account number')" />
                            <x-text-input wire:model="acc_number" name="acc_number" type="text" class="mt-1 block w-full"
                                autocomplete="acc_number" required />
                            <x-input-error :messages="$errors->get('acc_number')" class="mt-2" />
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
                                class="mt-1 block w-full" wire:model="status" required />


                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>


                        <div class="flex items-center gap-4">

                            <!-- Default Login Button -->
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="update">
                                {{ __('Update') }}
                            </x-primary-button>

                            <x-loader target="update" content="Update" />



                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
