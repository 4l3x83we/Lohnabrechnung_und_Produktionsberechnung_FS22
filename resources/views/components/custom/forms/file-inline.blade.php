@error($id ?? '')
<div class="sm:flex sm:items-center">
    <div class="sm:w-1/3">
        <label for="{{ $id ?? '' }}" class="block mb-2 sm:mb-0 text-sm font-medium text-red-700 dark:text-red-50 text-left">{{ $text ?? '' }}@if($stern ?? false)
                <span class="text-white">*</span>
            @endif</label>
    </div>
    <div class="sm:w-2/3">
        <div class="relative">
            <input type="file" value="{{ old($id ?? '') }}" id="{{ $id ?? '' }}" name="{{ $id ?? '' }}" {{ $attributes->merge(['class' => 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-xs rounded focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full dark:text-red-600 dark:placeholder-red-500 dark:border-red-500']) }}>
            <span class="text-xs text-red-600 dark:text-red-500">
            {{ $message }}
        </span>
        </div>
    </div>
</div>
@else
<div class="sm:flex sm:items-center">
    <div class="sm:w-1/3">
        <label for="{{ $id ?? '' }}" class="block mb-2 sm:mb-0 text-sm font-medium text-gray-900 dark:text-white text-left">{{ $text ?? '' }}@if($stern ?? false)
                <span class="text-red-500">*</span>
            @endif</label>
    </div>
    <div class="sm:w-2/3">
        <div class="relative">
            <input type="file" id="{{ $id ?? '' }}" name="{{ $id ?? '' }}" placeholder="{{ $text ?? '' }}" {{ $attributes->merge(['class' => 'block w-full text-xs text-gray-900 border border-gray-300 rounded cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400']) }}>
        </div>
    </div>
</div>
@enderror
