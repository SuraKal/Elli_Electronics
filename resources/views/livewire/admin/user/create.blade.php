<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\Corporate;
use App\Models\Role;
use Illuminate\Validation\Rule;

new #[Layout('components.layouts.admin')] class extends Component {

    public string $name = '';
    public string $email = '';
    public ?string $phone = null;
    public $status = '';
    // public $user_type = '';

    public ?string $user_type = '';
    public array $user_type_List = [
        'regular' => 'Regular', 
        'corporate' => 'Corporate'
    ];


// regular,corporate
    public function create()
    {
        $this->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                Rule::unique('users'),
            ],
            'status' => 'required|in:active,inactive,suspended',
            'user_type' => 'required|in:regular,corporate',
            'email' => 'required|email',
            'phone' => 'string|nullable',
        ], [
            'name.unique' => 'User already exists.',
            'status.in' => 'Status should be either Active, Inactive or Suspended.',
            'user_type.in' => 'User Type should be either Regular User or a Corporate User.',
        ]);

        // ✅ Default Role (Customer)
        $roleToBeAssigned = Role::firstOrCreate(['name' => 'customer']);

        // ✅ Create New User
        $user = User::create([
            'name' => $this->name,
            'status' => $this->status,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => 'Deafult_password'
        ]);

        if($this->user_type == 'corporate'){
            Corporate::create([
                'user_id' => $user->id,
                'company_name' => $this->name,
                'contact_person' => $this->name,
                'contact_email' => $this->email,
                'address' => 'Addis Abeba, Ethiopia',
                'phone' => $this->phone,
            ]);

            $roleToBeAssigned = Role::firstOrCreate(['name' => 'corporate']);
            
        }

        $user->roles()->attach($roleToBeAssigned->id);

        // ✅ Dispatch Event & Notify
        $this->dispatch('user-created');
        $this->reset();
    }
};
?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>

        <a href="{{ route('admin.user.index') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500"
            wire:navigate>
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
                            {{ __('Create a New User') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Make sure the user name and email are unique.') }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="user-created" message="User Created" />

                    <form wire:submit="create" class="mt-6 space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input wire:model="name" name="name" type="text" class="mt-1 block w-full"
                                autocomplete="name" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input wire:model="email" name="email" type="email" class="mt-1 block w-full"
                                autocomplete="email" required placeholder="user@mail.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone"
                                :value="__('Phone number (If more than one, separate each with a comma)')" />
                            <x-text-input wire:model="phone" name="phone" type="text" class="mt-1 block w-full"
                                autocomplete="name" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>


                        <div>
                            <x-input-label for="status" :value="__('Status')" />

                            <x-select
                                :options="['active' => 'Active', 'inactive' => 'In Active', 'suspended' => 'Suspended']"
                                selected="active" placeholder="Choose Status" class="mt-1 block w-full"
                                wire:model="status" required />

                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>



                        {{-- <div>
                            <x-input-label for="user_type" :value="__('User Type')" />

                            <x-select :options="$user_type_List" placeholder="Choose Type" class="mt-1 block w-full"
                                wire:model="user_type" required />

                            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                        </div>
                        <!-- Conditional div -->
                        <div class="mt-4" @if($user_type==='Corporate' ) style="display:block" @else
                            style="display:none" @endif>
                            <x-input-label for="pending_details" :value="__('Pending Details')" />
                            <x-textarea wire:model="pending_details" id="pending_details" class="mt-1 block w-full" />
                        </div> --}}

                        {{-- ---------------------- --}}

                        <div>
                            <x-input-label for="user_type" :value="__('User Type')" />
                            <x-select :options="$user_type_List" placeholder="Choose Type" class="mt-1 block w-full"
                                wire:model="user_type" required />
                            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
                        </div>

                        <!-- Conditional div -->
                        {{-- <div class="mt-4" @if($user_type=='regular' ) style="display:none" @else
                            style="display:block" @endif>
                            <x-input-label for="tin" :value="__('Tin Number')" />
                            <x-textarea wire:model="tin" id="tin" class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->get('tin')" class="mt-2" />
                        </div> --}}





                        <div class="flex items-center gap-4">
                            <!-- Default Create Button -->
                            <x-primary-button class="ms-3" wire:loading.remove wire:target="create">
                                {{ __('Create') }}
                            </x-primary-button>

                            <x-loader target="create" content="Creating..." />
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
