<div x-data="{ isOpen: false }" class=" flex sticky bottom-0 z-40">
    <div class=" w-full mb-2 sm:mb-4 left-0 px-4 ">
        <div class=" w-full max-w-xl rounded-full bg-[#F8FAFC] shadow-md shadow-black/20 py-2 text-xs sm:text-sm grid grid-cols-3 mx-auto">
            <a href="{{route('home')}}" class=" flex flex-col items-center gap-1 text-[#ff7100]">
                <button type="button" aria-label="Home" class=" w-[18px] sm:w-6 aspect-square">
                    <svg aria-hidden="true" class="e-font-icon-svg e-fas-home" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"></path></svg>
                </button>
                <p>Beranda</p>
            </a>
            <a href="{{ route('allproduct') }}" class=" flex flex-col items-center gap-1 text-[#ff7100]">
                <button type="button" aria-label="Bisnis" class=" w-[18px] sm:w-6 aspect-square">
                    <svg aria-hidden="true" class="e-font-icon-svg e-fas-boxes" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M560 288h-80v96l-32-21.3-32 21.3v-96h-80c-8.8 0-16 7.2-16 16v192c0 8.8 7.2 16 16 16h224c8.8 0 16-7.2 16-16V304c0-8.8-7.2-16-16-16zm-384-64h224c8.8 0 16-7.2 16-16V16c0-8.8-7.2-16-16-16h-80v96l-32-21.3L256 96V0h-80c-8.8 0-16 7.2-16 16v192c0 8.8 7.2 16 16 16zm64 64h-80v96l-32-21.3L96 384v-96H16c-8.8 0-16 7.2-16 16v192c0 8.8 7.2 16 16 16h224c8.8 0 16-7.2 16-16V304c0-8.8-7.2-16-16-16z"></path></svg>
                </button>
                <p>Bisnis</p>
            </a>
            {{-- <a href="{{ route('alltemplate') }}" class=" flex flex-col items-center gap-1 text-[#ff7100]">
                <button type="button" aria-label="Buka menu" class=" w-[18px] sm:w-6 aspect-square">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><path d="M12 4H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 8H6V6h6ZM26 4h-6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 8h-6V6h6ZM12 18H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2Zm0 8H6v-6h6ZM26 18h-6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2Zm0 8h-6v-6h6Z" fill="currentColor" class="fill-000000"></path><path data-name="<Transparent Rectangle>" d="M0 0h32v32H0z" fill="none"></path></svg>
                </button>
                <p>Template</p>
            </a> --}}
            <a href="{{ route('premium.package') }}" class=" flex flex-col items-center gap-1 text-[#ff7100]">
                <button type="button" aria-label="Join" class=" w-[18px] sm:w-6 aspect-square">
                    <svg aria-hidden="true" class="e-font-icon-svg e-far-arrow-alt-circle-right" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path fill="currentColor" d="M504 256C504 119 393 8 256 8S8 119 8 256s111 248 248 248 248-111 248-248zm-448 0c0-110.5 89.5-200 200-200s200 89.5 200 200-89.5 200-200 200S56 366.5 56 256zm72 20v-40c0-6.6 5.4-12 12-12h116v-67c0-10.7 12.9-16 20.5-8.5l99 99c4.7 4.7 4.7 12.3 0 17l-99 99c-7.6 7.6-20.5 2.2-20.5-8.5v-67H140c-6.6 0-12-5.4-12-12z"></path></svg>
                </button>
                <p>Join</p>
            </a>
            {{-- <a href="https://wa.me/{{ $no_tlp ?? '' }}" class=" flex flex-col items-center gap-1 text-[#ff7100]">
                <button type="button" aria-label="Buka menu" class=" w-[18px] sm:w-6 aspect-square">
                    <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                </button>
                <p>WhatApp</p>
            </a> --}}
            {{-- @auth
                <form method="POST" class=" w-full" action="{{ route('logout') }}">
                    <div class=" flex flex-col items-center gap-1 text-[#ff7100]">
                        @csrf
                        <button id="logout" class=" w-[18px] sm:w-6 aspect-square">
                            <svg viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"><g id="_icons"><path d="M20.9 11.6c-.1-.1-.1-.2-.2-.3l-3-3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l1.3 1.3H13c-.6 0-1 .4-1 1s.4 1 1 1h4.6l-1.3 1.3c-.4.4-.4 1 0 1.4.2.2.5.3.7.3s.5-.1.7-.3l3-3c.1-.1.2-.2.2-.3.1-.3.1-.5 0-.8z" fill="currentColor" class="fill-000000"></path><path d="M15.5 18.1c-1.1.6-2.3.9-3.5.9-3.9 0-7-3.1-7-7s3.1-7 7-7c1.2 0 2.4.3 3.5.9.5.3 1.1.1 1.4-.4.3-.5.1-1.1-.4-1.4C15.1 3.4 13.6 3 12 3c-5 0-9 4-9 9s4 9 9 9c1.6 0 3.1-.4 4.5-1.2.5-.3.6-.9.4-1.4-.3-.4-.9-.6-1.4-.3z" fill="currentColor" class="fill-000000"></path></g></svg>
                        </button>
                        <label for="logout">Logout</label>
                    </div>
                </form>
            @else
                <a href="{{ route('create.product') }}" class=" flex flex-col items-center gap-1 text-[#ff7100]">
                    <button type="button" aria-label="Buka menu" class=" w-[18px] sm:w-6 aspect-square">
                        <svg viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"><g id="_icons"><path d="M20.9 11.6c-.1-.1-.1-.2-.2-.3l-3-3c-.4-.4-1-.4-1.4 0s-.4 1 0 1.4l1.3 1.3H13c-.6 0-1 .4-1 1s.4 1 1 1h4.6l-1.3 1.3c-.4.4-.4 1 0 1.4.2.2.5.3.7.3s.5-.1.7-.3l3-3c.1-.1.2-.2.2-.3.1-.3.1-.5 0-.8z" fill="currentColor" class="fill-000000"></path><path d="M15.5 18.1c-1.1.6-2.3.9-3.5.9-3.9 0-7-3.1-7-7s3.1-7 7-7c1.2 0 2.4.3 3.5.9.5.3 1.1.1 1.4-.4.3-.5.1-1.1-.4-1.4C15.1 3.4 13.6 3 12 3c-5 0-9 4-9 9s4 9 9 9c1.6 0 3.1-.4 4.5-1.2.5-.3.6-.9.4-1.4-.3-.4-.9-.6-1.4-.3z" fill="currentColor" class="fill-000000"></path></g></svg>
                    </button>
                    <p>Join</p>
                </a>
            @endauth --}}
        </div>
    </div>
</div>