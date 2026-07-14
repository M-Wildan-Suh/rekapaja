<div class=" mx-auto rounded-md bg-white min-h-screen relative">
    <div class=" space-y-6">
        <div class=" min-h-screen pt-6 sm:pt-12 relative space-y-6 bg-gradient-to-b from-blue-500 to-purple-600">
            <div class=" flex flex-col justify-center items-center px-4 gap-4 relative text-white">
                <div class=" w-32 p-1 aspect-square bg-white rounded-full overflow-hidden">
                    <img src="{{ $data->image }}" class=" w-full h-full object-cover rounded-full " alt="">
                </div>
                <p class=" text-2xl font-black text-center">{{$data->name}}</p>
                <p class=" text-center">{{$data->subtitle}}</p>
            </div>
            <div class=" w-full max-w-[640px] mx-auto px-4 md:px-0">
                <div class=" w-full grid grid-cols-3 gap-4">
                    <div class=" w-full h-full rounded-md bg-[#FF0000] flex items-center justify-center p-[10%]">
                        <div class=" w-full aspect-square">
                            <svg viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><rect height="512" rx="64" ry="64" width="512" fill="#ff0000" fill-opacity="1" fill-rule="nonzero" stroke="none" class="fill-cf2200"></rect><path d="M371.289 348.587h-21.956l.103-12.751c0-5.667 4.653-10.303 10.342-10.303h1.4c5.698 0 10.364 4.636 10.364 10.303l-.253 12.75zm-82.342-27.325c-5.57 0-10.125 3.742-10.125 8.325V391.6c0 4.573 4.556 8.307 10.125 8.307 5.59 0 10.15-3.734 10.15-8.307v-62.013c0-4.587-4.56-8.325-10.15-8.325zm133.72-34.689v117.974c0 28.297-24.543 51.453-54.534 51.453H143.871c-30.004 0-54.538-23.156-54.538-51.453V286.573c0-28.297 24.534-51.457 54.538-51.457h224.262c29.991 0 54.534 23.16 54.534 51.457zM158.83 417.356V293.084l27.8.01V274.68l-74.107-.111v18.102l23.134.067v124.618h23.19zm83.333-105.76h-23.177v66.36c0 9.6.582 14.4-.045 16.093-1.884 5.147-10.355 10.609-13.657.555-.56-1.76-.067-7.07-.076-16.19l-.093-66.818h-23.05l.072 65.764c0 10.08-.227 17.6.08 21.018.564 6.03.364 13.066 5.96 17.08 10.426 7.515 30.413-1.12 35.413-11.858l-.044 13.702 18.613.022V311.596zm74.147 75.99-.049-55.23c0-21.05-15.764-33.658-37.142-16.627l.093-41.062-23.155.035-.111 141.734 19.035-.28 1.734-8.827c24.337 22.324 39.63 7.031 39.595-19.742zm72.538-7.32-17.382.094c0 .689-.045 1.484-.045 2.351v9.698c0 5.187-4.289 9.413-9.497 9.413h-3.405c-5.218 0-9.502-4.226-9.502-9.413v-25.507h39.795v-14.978c0-10.946-.28-21.888-1.186-28.146-2.845-19.796-30.631-22.938-44.667-12.805-4.409 3.165-7.773 7.4-9.729 13.094-1.978 5.693-2.955 13.47-2.955 23.35v32.93c.004 54.746 66.502 47.009 58.568-.08zm-89.147-178.79c1.196 2.906 3.054 5.262 5.574 7.04 2.488 1.75 5.675 2.63 9.484 2.63 3.342 0 6.302-.902 8.88-2.764 2.569-1.853 4.733-4.622 6.498-8.315l-.436 9.093h25.836V99.289H335.2V184.8c0 4.631-3.813 8.422-8.476 8.422-4.635 0-8.462-3.79-8.462-8.422V99.289h-21.226v74.107c0 9.44.168 15.733.448 18.924a32.158 32.158 0 0 0 2.218 9.156zm-78.293-62.054c0-10.546.88-18.782 2.627-24.72 1.76-5.915 4.92-10.67 9.497-14.258 4.565-3.604 10.41-5.408 17.516-5.408 5.978 0 11.098 1.173 15.378 3.47 4.297 2.312 7.609 5.312 9.91 9.014 2.343 3.716 3.934 7.533 4.783 11.44.867 3.96 1.293 9.933 1.293 17.991v27.787c0 10.19-.409 17.689-1.2 22.449-.786 4.773-2.475 9.2-5.089 13.35-2.582 4.107-5.91 7.179-9.946 9.139-4.08 1.977-8.747 2.946-14.018 2.946-5.889 0-10.849-.813-14.938-2.51-4.102-1.69-7.27-4.236-9.529-7.619-2.28-3.386-3.884-7.51-4.853-12.32-.973-4.804-1.436-12.03-1.436-21.662v-29.089zm20.235 43.645c0 6.222 4.632 11.302 10.272 11.302 5.644 0 10.253-5.08 10.253-11.302v-58.49c0-6.213-4.609-11.293-10.253-11.293-5.64 0-10.272 5.08-10.272 11.294v58.489zM170.142 212.6h24.374l.044-84.267 28.8-72.186h-26.658l-15.31 53.617L165.861 56H139.48l30.64 72.373.044 84.227z" fill="#ffffff" fill-opacity="1" class="fill-ffffff"></path></svg>
                        </div>
                    </div>
                    <div class=" col-span-2 w-full aspect-video rounded-md overflow-hidden bg-white">
                        <div class="w-full h-full">
                            <iframe src="{{$data->embed}}" frameborder="0" class="w-full h-full" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <x-guest.description color="white" :data="$data" text="text-black"/>
            @include('components.guest.qris-section')

            <div class="w-full max-w-[640px] mx-auto px-4 md:px-0 relative">
                <div class=" w-full">
                    <div class=" grid grid-cols-1 gap-3">
                        @foreach ($data->productHighlight as $item)
                            <div class=" bg-white w-full p-3 flex gap-2 text-black {{ $loop->index % 2 == 0 ? 'flex-row rounded-l-[80px] rounded-r-3xl' : ' rounded-l-3xl rounded-r-[80px] flex-row-reverse text-right' }}">
                                <div class=" min-w-24 h-24 aspect-square rounded-full border-2 overflow-hidden border-blue-500">
                                    <img src="{{ $item->image }}" class="w-full h-full object-cover" alt="">
                                </div>
                                <div class=" flex flex-col justify-between gap-2">
                                    <p class=" line-clamp-1 sm:text-lg font-semibold">{{$item->title}}</p>
                                    <x-guest.product.detail-button :item="$item" class="py-1.5 px-3 flex items-center gap-2 text-sm border-2 border-black rounded-md hover:bg-black/10 duration-300 self-start" />
                                    <div class="flex gap-1 {{ $loop->index % 2 == 0 ? '' : 'justify-end' }}">
                                        @for ($i = 0; $i < 5; $i++)
                                            <div class=" w-4 sm:w-5 aspect-square text-yellow-400">
                                                <svg viewBox="0 0 58 58" xmlns="http://www.w3.org/2000/svg">
                                                    <g fill="none" fill-rule="evenodd">
                                                        <path d="M30.757 1.144 38.2 16.948a1.968 1.968 0 0 0 1.475 1.123l16.644 2.534a2.08 2.08 0 0 1 1.086 3.502L45.362 36.408a2.115 2.115 0 0 0-.563 1.818l2.843 17.37a1.98 1.98 0 0 1-2.843 2.164l-14.887-8.201a1.88 1.88 0 0 0-1.824 0l-14.887 8.2a1.98 1.98 0 0 1-2.843-2.163l2.843-17.37a2.115 2.115 0 0 0-.563-1.818L.594 24.107a2.08 2.08 0 0 1 1.086-3.502l16.644-2.534a1.968 1.968 0 0 0 1.475-1.123l7.444-15.804a1.92 1.92 0 0 1 3.514 0Z" fill="#facc15" class="fill-f6ab27"></path>
                                                        <path d="M17.148 38.872a6.124 6.124 0 0 0-1.654-5.264L6.07 23.983l12.857-1.957a5.966 5.966 0 0 0 4.49-3.37L29 6.802l5.581 11.85a5.969 5.969 0 0 0 4.492 3.374l12.857 1.957-9.426 9.627a6.125 6.125 0 0 0-1.652 5.264l2.184 13.348-11.194-6.167a5.88 5.88 0 0 0-5.683 0l-11.195 6.167 2.184-13.35Z" fill="currentColor" class="fill-f4cd1e"></path>
                                                    </g>
                                                </svg>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w-full max-w-[640px] mx-auto px-4 md:px-0 relative">
                @include('components.guest.gallery')
            </div>

            <x-guest.contact :role="$role" classa="text-white bg-blue-500 border-blue-500 hover:text-white hover:bg-blue-700 hover:border-blue-700" classb="bg-purple-500 text-white border-purple-500 hover:text-white hover:bg-purple-700 hover:border-purple-700" :data="$data" :notlp="$no_tlp"/>
        </div>
    </div>
</div>
