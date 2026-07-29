<div class=" w-full {{ $role === 'admin' || $role === 'premium' ? 'sticky bottom-0' : ''}} py-2 backdrop-blur px-4 sm:px-8 z-30 rounded-b-md">
    <div class="grid {{ $data->home_button === 'on' ? 'grid-cols-3' : 'grid-cols-2' }} gap-2 sm:gap-4 w-full max-w-[600px] mx-auto">
        @if ($data->home_button === 'on')    
            <a href="{{route('home')}}">
                <button
                    style="background-color: {{$template->contact_main_color}}"
                    class=" text-base w-full flex justify-center gap-1.5 items-center py-2 rounded-md text-white duration-300 relative">
                    <div class=" w-4 aspect-square">
                        <svg viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"><path d="m21.146 8.576-7.55-6.135a2.543 2.543 0 0 0-3.192 0L2.855 8.575a1.119 1.119 0 0 0-.416.873v11.543c0 .62.505 1.13 1.125 1.13h5.062c.62 0 1.125-.51 1.125-1.13v-7.306h4.499v7.306c0 .62.505 1.13 1.125 1.13h5.062c.62 0 1.125-.51 1.125-1.13V9.448a1.122 1.122 0 0 0-.416-.872zm-.71 12.421h-5.062V13.68c0-.62-.505-1.119-1.125-1.119H9.75c-.62 0-1.125.499-1.125 1.119v7.317H3.564V9.448l7.55-6.134a1.411 1.411 0 0 1 1.773 0l7.55 6.134v11.549z" fill="currentColor" class="fill-000000"></path></svg>
                    </div>
                    <p class=" hidden sm:block text-sm">Home</p>
                </button>
            </a>
        @endif
        <a href="tel:{{ $no_tlp ?? '' }}">
            <button
                style="background-color: {{$template->contact_second_color}}"
                class=" text-base w-full flex justify-center gap-1.5 items-center py-2 rounded-md text-white duration-300 relative">
                <div class=" w-4 aspect-square">
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><g data-name="1"><path d="M348.73 450.06a198.63 198.63 0 0 1-46.4-5.85c-52.43-12.65-106.42-44.74-152-90.36s-77.71-99.62-90.36-152c-13.32-55.1-3.82-102.24 26.72-132.78l8.72-8.72a42.2 42.2 0 0 1 59.62 0l50.11 50.1a42.18 42.18 0 0 1 0 59.62l-29.6 29.59c14.19 24.9 33.49 49.82 56.3 72.63s47.75 42.12 72.64 56.31l29.59-29.6a42.15 42.15 0 0 1 59.62 0l50.1 50.1a42.16 42.16 0 0 1 0 59.61l-8.73 8.72c-21.53 21.57-51.33 32.63-86.33 32.63ZM125.22 78a12 12 0 0 0-8.59 3.56l-8.73 8.72c-22.87 22.87-29.55 60-18.81 104.49 11.37 47.13 40.64 96.1 82.41 137.86s90.73 71 137.87 82.41c44.5 10.74 81.61 4.06 104.48-18.81l8.72-8.72a12.16 12.16 0 0 0 0-17.19l-50.09-50.1a12.16 12.16 0 0 0-17.19 0l-37.51 37.51a15 15 0 0 1-17.5 2.72c-30.75-15.9-61.75-39.05-89.65-66.95s-51-58.88-66.94-89.63a15 15 0 0 1 2.71-17.5l37.52-37.51a12.16 12.16 0 0 0 0-17.19l-50.1-50.11a12.07 12.07 0 0 0-8.6-3.56Z" fill="currentColor" class="fill-000000"></path><path d="M364.75 269.73a15 15 0 0 1-15-15 99.37 99.37 0 0 0-99.25-99.26 15 15 0 0 1 0-30c71.27 0 129.25 58 129.25 129.26a15 15 0 0 1-15 15Z" fill="currentColor" class="fill-000000"></path><path d="M428.15 269.73a15 15 0 0 1-15-15c0-89.69-73-162.66-162.65-162.66a15 15 0 0 1 0-30c106.23 0 192.65 86.43 192.65 192.66a15 15 0 0 1-15 15Z" fill="currentColor" class="fill-000000"></path></g></svg>
                </div>
                <p class=" hidden sm:block text-sm">Telephone</p>
            </button>
        </a>
        <a href="https://wa.me/{{ $no_tlp ?? '' }}">
            <button
                style="background-color: {{$template->contact_main_color}}"
                class=" text-base w-full flex justify-center gap-1.5 items-center py-2 rounded-md text-white duration-300 relative">
                <div class=" w-4 aspect-square">
                    <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                </div>
                <p class=" hidden sm:block text-sm">WhatsApp</p>
            </button>
        </a>
    </div>
</div>
<x-guest.product.detail-modal />
