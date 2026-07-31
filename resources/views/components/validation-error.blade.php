<div class=" fixed bottom-24 right-4 sm:right-8 w-auto flex flex-col items-end gap-4">
    @foreach ($errors->all() as $error)
        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms 
            class=" flex gap-4 items-center px-4 py-1 text-sm sm:text-base rounded-xl overflow-hidden bg-red-100 border border-red-400 text-red-700">
            <div class="">{{$error}}</div>
            <button @click="show = false" class=" text-red-700 hover:text-red-900">
                <div class=" w-4 h-4">
                    <svg
                        height="512px" id="Layer_1" class=" w-full h-full" version="1.1"
                        viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink">
                        <path fill="currentColor"
                            d="M437.5,386.6L306.9,256l130.6-130.6c14.1-14.1,14.1-36.8,0-50.9c-14.1-14.1-36.8-14.1-50.9,0L256,205.1L125.4,74.5  c-14.1-14.1-36.8-14.1-50.9,0c-14.1,14.1-14.1,36.8,0,50.9L205.1,256L74.5,386.6c-14.1,14.1-14.1,36.8,0,50.9  c14.1,14.1,36.8,14.1,50.9,0L256,306.9l130.6,130.6c14.1,14.1,36.8,14.1,50.9,0C451.5,423.4,451.5,400.6,437.5,386.6z" />
                    </svg>
                </div>
            </button>
        </div>
    @endforeach
</div>