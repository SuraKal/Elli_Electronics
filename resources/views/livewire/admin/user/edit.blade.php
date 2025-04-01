<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Corporate;
use App\Models\Role;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component {

    public int $userId;
    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public string $status = '';
    public string $user_type = '';

    public function mount(User $user)
    {
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->status = $user->status;
        $this->user_type = $user->corporate()->exists() ? 'corporate' : 'regular';
        // dd($this->user_type);
    }

    public function update()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('users')->ignore($this->userId),
            ],
            'status' => 'required|in:active,inactive,suspended',
            'user_type' => 'required|in:regular,corporate',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->userId),
            ],
            'phone' => 'string|nullable',
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'status' => $this->status,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

        if ($this->user_type === 'corporate') {
            Corporate::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $this->name,
                    'contact_person' => $this->name,
                    'contact_email' => $this->email,
                    'address' => 'Addis Abeba, Ethiopia',
                    'phone' => $this->phone,
                ]
            );
        } else {
            Corporate::where('user_id', $user->id)->delete();
        }

        $role = Role::firstOrCreate(['name' => $this->user_type === 'corporate' ? 'corporate' : 'customer']);
        $user->roles()->sync([$role->id]);

        $this->dispatch('user-updated');
    }
};
?>


<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
        <a href="{{ route('admin.user.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
            View users
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
                            {{ __('Edit User Information') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Ensure the updated information is correct.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="user-updated" message="User Updated" />

                    <form wire:submit="update" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:model="email" name="email" type="email" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input wire:model="phone" name="phone" type="text" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <x-select :options="['active' => 'Active', 'inactive' => 'In Active', 'suspended' => 'Suspended']"
                                class="mt-1 block w-full" wire:model="status" required />
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="user_type" :value="__('User Type')" />
                            <x-select :options="['regular' => 'Regular', 'corporate' => 'Corporate']"
                                class="mt-1 block w-full" wire:model="user_type" required />
                            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
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

