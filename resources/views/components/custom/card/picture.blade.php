@if($uploadPicture === false)
    <div class="flex space-x-2">
        <x-custom.button.button wire:click="uploadPicture('true')" class="text-primary-900 bg-primary-200 border border-primary-300 focus:outline-none hover:bg-primary-100 focus:ring-4 focus:ring-primary-200 font-medium rounded px-3 py-2 text-xs dark:bg-primary-800 dark:text-white dark:border-primary-600 dark:hover:bg-primary-700 dark:hover:border-primary-600 dark:focus:ring-primary-700 duration-300">
            <svg class="w-4 h-4 mr-2 -ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 19">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15h.01M4 12H2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-3m-5.5 0V1.07M5.5 5l4-4 4 4"/>
            </svg>
            {{ __('Upload Picture') }}
        </x-custom.button.button>
        <x-custom.button.button wire:click="$dispatch('triggerDeleteProfilPicture',{{ $upload }})" class="text-red-900 bg-red-200 border border-red-300 focus:outline-none hover:bg-red-100 focus:ring-4 focus:ring-red-200 font-medium rounded px-3 py-2 text-xs dark:bg-red-800 dark:text-white dark:border-red-600 dark:hover:bg-red-700 dark:hover:border-red-600 dark:focus:ring-red-700 duration-300">
            {{ __('Delete') }}
        </x-custom.button.button>
    </div>
@else
    <div class="grid grid-cols-1 gap-4">
        <div class="col-span-1">
            <x-custom.forms.file id="image" wire:model.live="image" wire:loading.remove/>
        </div>
        <div wire:loading wire:target="image">
            <div class="col-span-1">
                <div class="text-center">
                    <div role="status">
                        <svg aria-hidden="true" class="inline w-8 h-8 text-natural-200 animate-spin dark:text-natural-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@include('layouts.partials.delete')
