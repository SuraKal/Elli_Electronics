<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component
{
    use WithFileUploads;

    public string $contact_phone = '';
    public string $contact_email = '';
    public string $address = '';
    public $logo = '';
    public $previous_logo = '';
    public $settings = [];

    // ✅ Validation Rules
    protected $rules = [
        'contact_phone' => 'required|string',
        'contact_email' => 'required|email',
        'address' => 'required|string',
        'logo' => 'nullable|mimes:jpg,jpeg,png|max:2048',
    ];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->settings = Setting::first();

        $this->contact_phone = $this->settings->contact_phone ?? '';
        $this->contact_email = $this->settings->contact_email ?? '';
        $this->address = $this->settings->address ?? '';
        $this->previous_logo = $this->settings->logo ?? '';
    }

    /**
     * Update Contact Information.
     */
    public function updateContactProfileInformation()
    {
        // ✅ Run Validation
        $this->validate();

        // ✅ Handle Image Upload
        if ($this->logo) {
            // Delete the previous logo if it exists
            if ($this->previous_logo && Storage::disk('public')->exists(str_replace('storage/', '', $this->previous_logo))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $this->previous_logo));
            }

            // Store new logo
            $admin_image = 'storage/' . $this->logo->store('images/logo/', 'public');
        } else {
            $admin_image = $this->previous_logo;
        }




        // ✅ Update Settings Correctly
        $this->settings->update([
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'address' => $this->address,
            'logo' => $admin_image
        ]);

        // ✅ Dispatch Event & Reset Logo Input
        $this->dispatch('contact-updated');
        $this->logo = ''; // Reset file input without resetting other fields
    }

};
?>


<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Contact Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update details that is shown to users.") }}
        </p>
    </header>

    <x-action-message class="me-3" on="contact-updated" message='Changes Saved' />

    <form wire:submit="updateContactProfileInformation" class="mt-6 space-y-6">
        <div>
            <x-input-label for="contact_phone" :value="__('Contact Phone')" />
            <x-text-input wire:model="contact_phone" id="contact_phone" name="contact_phone" type="text"
                class="mt-1 block w-full" required autofocus autocomplete="contact_phone" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_phone')" />
        </div>

        <div>
            <x-input-label for="contact_email" :value="__('Contact Email (Separate by comma)')" />
            <x-text-input wire:model="contact_email" id="contact_email" name="contact_email" type="email"
                class="mt-1 block w-full" required autocomplete="contact_email" />
            <x-input-error class="mt-2" :messages="$errors->get('contact_email')" />

        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input wire:model="address" id="address" name="address" type="text" class="mt-1 block w-full"
                required autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="logo" :value="__('Logo(Must be < 2MB) - Only if you want to update it')" />
            <x-text-input wire:model="logo" name="logo" type="file" class="mt-1 block w-full" autocomplete="logo" />
            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
            <div wire:loading wire:target="logo" class="text-sm text-blue-500">Uploading...</div>

        </div>

        <div>
            <!-- Default Login Button -->
            <x-primary-button class="ms-3" wire:loading.remove wire:target="updateContactProfileInformation">
                {{ __('Update') }}
            </x-primary-button>



            <x-loader target="updateContactProfileInformation" content="Update"/>
        </div>
    </form>
</section>
