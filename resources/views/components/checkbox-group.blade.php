@props([
    'disabled' => false,
    'options' => [], // Array of options ['value' => 'label']
    'selected' => [], // Array of selected values
    'wireModel' => null, // The wire:model property
])

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 mt-3 gap-4">
    @foreach($options as $value => $label)
        <label class="flex items-center space-x-2 cursor-pointer">
            <input type="checkbox" value="{{ $value }}"
                   wire:model.defer="{{ $wireModel }}"
                   @checked(in_array($value, $selected ?? []))
                   @disabled($disabled)
                   class="h-5 w-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
            <span class="text-gray-700">{{ $label }}</span>
        </label>
    @endforeach
</div>
