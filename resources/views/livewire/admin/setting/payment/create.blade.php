<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

new #[Layout('components.layouts.admin')] class extends Component {
    use WithFileUploads;

    public string $method = '';
    public $logo = '';
    public $status = '';
    public string $acc_name = '';
    public string $acc_number = '';

    public function rules()
    {
        return [
            'method' => 'required|string',
            'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'status' => 'required|in:1,0',
            'acc_name' => 'required|string',
            'acc_number' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'status.in' => 'Status should be either Active or Inactive.',
        ];
    }

    public function store()
    {
        $this->validate();
        
        $payment_image = '';
        if ($this->logo) {
            $payment_image = 'storage/' . $this->logo->store('images/payment_logos/', 'public');
        }else{
            $payment_image = 'static/images/placeholders/placeholder.jpg';
        }
        
        Payment::create([
            'method' => $this->method,
            'status' => $this->status,
            'logo' => $payment_image,
            'acc_name' => $this->acc_name,
            'acc_number' => $this->acc_number,
        ]);

        $this->dispatch('payment-created');
        $this->reset();
    }
};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
        <a href="{{ route('admin.setting.payment.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500" wire:navigate>
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
                            {{ __('Create a payment') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your payment credentials are correct.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="payment-created" message='Payment Added' />
                    
                    <form wire:submit="store" class="mt-6 space-y-6">
                        <div>
                            <x-input-label for="method" :value="__('Method')" />
                            <x-text-input wire:model="method" name="method" type="text" class="mt-1 block w-full" placeholder="Awash, CBE" required />
                            <x-input-error :messages="$errors->get('method')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="acc_name" :value="__('Account name')" />
                            <x-text-input wire:model="acc_name" name="acc_name" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('acc_name')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="acc_number" :value="__('Account number')" />
                            <x-text-input wire:model="acc_number" name="acc_number" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('acc_number')" class="mt-2" />
                        </div>
                        
                        <div>
                            <x-input-label for="logo" :value="__('Logo (Must be < 2MB)')" />
                            <x-text-input wire:model="logo" name="logo" type="file" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                            <div wire:loading wire:target="logo" class="text-sm text-blue-500">Uploading...</div>
                        </div>
                        
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select :options="['1' => 'Active', '0' => 'Inactive']" placeholder="Choose Status" class="mt-1 block w-full" wire:model="status" required />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="store">
                                {{ __('Create') }}
                            </x-primary-button>
                            <x-loader target="store" content="Create" />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>