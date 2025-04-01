@props([
    'disabled' => false,
    'options' => [], // Array of options ['value' => 'label']
    'selected' => null, // Pre-selected option
    'placeholder' => 'Select an option', // Default placeholder
])

<select
    @disabled($disabled)
    {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) }}
>
    @if($placeholder)
        <option value="" disabled {{ $selected ? '' : 'selected' }}>
            {{ $placeholder }}
        </option>
    @endif

    @foreach($options as $value => $label)
        <option value="{{ $value }}" @selected($selected == $value)>
            {{ $label }}
        </option>
    @endforeach
</select>


