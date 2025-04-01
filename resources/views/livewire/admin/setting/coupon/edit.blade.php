<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Coupon;
use Illuminate\Validation\Rule;
new #[Layout('components.layouts.admin')] class extends Component{

public Coupon $coupon;
public string $name = '';
public string $code = '';
public float $discount_value;
public int $usage_limit;
public string $expires_at = '';

public string $couponId = '';
public string $status = '1'; // Default to Active ('1' = Active, '0' = Inactive)

public function mount(Coupon $coupon)
{
    $this->fill($coupon);
    $this->couponId = $this->coupon->id;
    $this->status = (string) $this->coupon->status; // Ensure status is treated as a string

}

public function update()
{
    // code,discount_value,usage_limit,expires_at
    $this->validate([
        'name' => [
            'required',
            'string',
            'min:3',
            Rule::unique('coupons')->ignore($this->couponId),
        ],
        'status' => 'required|in:1,0', // Ensure status is either '1' or '0' 
        'code' => 'required|min:3',
        'discount_value' => 'required',
        'usage_limit' => 'required|min:0',
    ], [
        'name.unique' => 'Coupon already exists.',
        'status.in' => 'Status should be either Active or Inactive.',
    ]);

    // ✅ Update Coupon Correctly
    $this->coupon->update([
        'name' => $this->name,
        'status' => (int) $this->status, // Convert back to integer for the database
        'code' => $this->code,
        'discount_value' => $this->discount_value,
        'usage_limit' => $this->usage_limit
    ]);

    // ✅ Dispatch Event & Notify
    $this->dispatch('coupon-updated');
}


}; ?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Coupon') }}
        </h2>

        <a href="{{ route('admin.setting.coupon.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
            View coupons
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
                            {{ __('Edit a Coupon') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure your Coupon name is short.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="coupon-updated" message='Coupon Updated' />

                    <form wire:submit="update" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="name" aria-placeholder="Coffee, Furniture ..."
                                placeholder="Coffee, Furniture ..." required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input wire:model="code" name="code" type="text" class="mt-1 block w-full"
                                autocomplete="code" required />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="discount_value" :value="__('Discount Value')" />
                            <x-text-input wire:model="discount_value" name="discount_value" type="number" step="0.01"  class="mt-1 block w-full"
                                autocomplete="name" required />
                            <x-input-error :messages="$errors->get('discount_value')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="usage_limit" :value="__('Usage Limit')" />
                            <x-text-input wire:model="usage_limit" name="usage_limit" type="number" class="mt-1 block w-full"
                                autocomplete="usage_limit" required />
                            <x-input-error :messages="$errors->get('usage_limit')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="expires_at" :value="__('Expires at')" />
                            <x-text-input wire:model="expires_at" name="expires_at" type="datetime-local" class="mt-1 block w-full"
                                autocomplete="expires_at" required />
                            <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
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
