<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use App\Models\Socialmedia;
// use Illuminate\Validation\Rule;
use Livewire\Attributes\Rule;


new #[Layout('components.layouts.admin')] class extends Component{

    public $socialmedias = [];

    #[Rule('nullable|url', message: 'Please enter a valid WhatsApp URL')]
public string $whatsapp;

#[Rule('nullable|url', message: 'Please enter a valid TikTok URL')]
public string $tiktok;

#[Rule('nullable|url', message: 'Please enter a valid Facebook URL')]
public string $facebook;

#[Rule('nullable|url', message: 'Please enter a valid Twitter URL')]
public string $twitter;

#[Rule('nullable|url', message: 'Please enter a valid LinkedIn URL')]
public string $linkedin;

#[Rule('nullable|url', message: 'Please enter a valid Instagram URL')]
public string $instagram;

#[Rule('nullable|url', message: 'Please enter a valid YouTube URL')]
public string $youtube;

#[Rule('nullable|url', message: 'Please enter a valid Pinterest URL')]
public string $pinterest;

#[Rule('nullable|url', message: 'Please enter a valid Amazon URL')]
public string $amazon;

#[Rule('nullable|url', message: 'Please enter a valid Snapchat URL')]
public string $snapchat;

#[Rule('nullable|url', message: 'Please enter a valid Google Plus URL')]
public string $googleplus;

#[Rule('nullable|url', message: 'Please enter a valid Vimeo URL')]
public string $vimeo;

#[Rule('nullable|url', message: 'Please enter a valid Flickr URL')]
public string $flickr;





    public function mount(){
        $this->socialmedias = Socialmedia::first()?->makeHidden(['id', 'created_at', 'updated_at']);;
        $this->whatsapp = $this->socialmedias->whatsapp ?? '';
        $this->tiktok = $this->socialmedias->tiktok ?? '';
        $this->facebook = $this->socialmedias->facebook ?? '';
        $this->twitter = $this->socialmedias->twitter ?? '';
        $this->linkedin = $this->socialmedias->linkedin ?? '';
        $this->instagram = $this->socialmedias->instagram ?? '';
        $this->youtube = $this->socialmedias->youtube ?? '';
        $this->pinterest = $this->socialmedias->pinterest ?? '';
        $this->amazon = $this->socialmedias->amazon ?? '';
        $this->snapchat = $this->socialmedias->snapchat ?? '';
        $this->googleplus = $this->socialmedias->googleplus ?? '';
        $this->vimeo = $this->socialmedias->vimeo ?? '';
        $this->flickr = $this->socialmedias->flickr ?? '';
        
    }

    public function updateSocialMedia(){
        $this->validate();
        $this->socialmedias->update([
            'whatsapp' => $this->whatsapp,
            'tiktok' => $this->tiktok,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'instagram' => $this->instagram,
            'youtube' => $this->youtube,
            'pinterest' => $this->pinterest,
            'amazon' => $this->amazon,
            'snapchat' => $this->snapchat,
            'googleplus' => $this->googleplus,
            'vimeo' => $this->vimeo,
            'flickr' => $this->flickr,
        ]);

        // ✅ Dispatch event and reset form
            $this->dispatch('social-created');
            // $this->reset();
    }








}; ?>

<x-slot name="header">
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Social Media Settings') }}
        </h2>



    </div>
</x-slot>


<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Adjust Link') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Ensure your link is for the right social media platform. Leave it empty if you don't have the account") }}
                        </p>
                    </header>

                    <x-action-message class="me-3" on="social-created" message='Links Updated' />


                    <form wire:submit="updateSocialMedia" class="mt-6 space-y-6">
                        @csrf
                        <div class="space-y-6">
                            @foreach ([
                                    'whatsapp' => 'WhatsApp',
                                    'tiktok' => 'TikTok',
                                    'facebook' => 'Facebook',
                                    'twitter' => 'Twitter',
                                    'linkedin' => 'LinkedIn',
                                    'instagram' => 'Instagram',
                                    'youtube' => 'YouTube',
                                    'pinterest' => 'Pinterest',
                                    'amazon' => 'Amazon',
                                    'snapchat' => 'Snapchat',
                                    'googleplus' => 'Google Plus',
                                    'vimeo' => 'Vimeo',
                                    'flickr' => 'Flickr'
                                ] as $platform => $label)
                                <div class="flex flex-col md:flex-row items-center gap-4">
                                    <label for="{{ $label }}" class="w-full md:w-1/3 text-gray-700">{{ $label }}
                                        Profile</label>
                                    <div class="w-full md:w-2/3 flex items-center gap-2">
                                        <div>
                                            <span class="text-xl text-gray-600">
                                                <i
                                                    class="fab fa-{{ $platform == 'googleplus' ? 'google-plus-g' : $platform }}"></i>
                                            </span>

                                        </div>
                                        
                                        <div class="w-full">
                                            <x-text-input wire:model="{{ $platform }}" name="{{ $platform }}"
                                            id="{{ $label }}" type="text" placeholder="Enter your {{ $label }} profile link"
                                            class="w-full" :value="$socialmedias[$platform] ?? ''"
                                            autocomplete="{{ $platform }}" />
                                            <x-input-error :messages="$errors->get($platform)" class="mt-2" />


                                        </div>
                                        

                                        
                                    </div>

                                </div>
                            @endforeach
                        </div>



                        <div class="flex items-center gap-4">
                            {{-- <x-primary-button>{{ __('Update') }}</x-primary-button> --}}
            <x-primary-button class="ms-3" wire:loading.remove wire:target="updateSocialMedia">
                {{ __('Update') }}
            </x-primary-button>



            <x-loader target="updateSocialMedia" content="Update"/>

                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>
