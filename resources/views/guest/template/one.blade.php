<div class="pt-20 px-2">
    <div class=" w-full max-w-[1080px] mx-auto rounded-md bg-white relative">
        <div class=" w-full space-y-1 text-neutral-600">
            <div class=" grid grid-cols-1 md:grid-cols-3">
                <div class=" md:col-span-2 w-full max-w-screen space-y-2 py-4 p-4 pb-0 sm:pb-8 sm:p-8 sm:pr-0">
                    <div x-data="imageGallery()" class="w-full space-y-2 relative">
                        {{-- Show Image or Embed --}}
                        <div class="w-full aspect-video rounded-md overflow-hidden">
                            <template x-if="currentImage.includes('youtube.com')">
                                <!-- YouTube Embed -->
                                <div class="w-full h-full">
                                    <iframe :src="currentImage" frameborder="0" class="w-full h-full" allowfullscreen></iframe>
                                </div>
                            </template>
                            <template x-if="!currentImage.includes('youtube.com')">
                                <!-- Image Display -->
                                <img :src="currentImage" class="w-full h-full object-center object-cover" alt="">
                            </template>
                        </div>
                        
                        <div class="swiper h-full rounded">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper flex">
                                <template x-for="(image, index) in images" :key="index">
                                    <div class="swiper-slide flex-shrink-0 aspect-video rounded relative overflow-hidden cursor-pointer"
                                        @click="changeImage(image)">
                                        <template x-if="image.includes('youtube.com')">
                                            <!-- YouTube Embed Thumbnail -->
                                            <div class="w-full h-full relative">
                                                <div class=" absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                                    <div class=" w-8 aspect-square">
                                                        <svg enable-background="new 0 0 32 32" id="Layer_1" version="1.0" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M31.67,9.179c0,0-0.312-2.353-1.271-3.389c-1.217-1.358-2.58-1.366-3.205-1.443C22.717,4,16.002,4,16.002,4   h-0.015c0,0-6.715,0-11.191,0.347C4.171,4.424,2.809,4.432,1.591,5.79C0.633,6.826,0.32,9.179,0.32,9.179S0,11.94,0,14.701v2.588   c0,2.763,0.32,5.523,0.32,5.523s0.312,2.352,1.271,3.386c1.218,1.358,2.815,1.317,3.527,1.459C7.677,27.919,15.995,28,15.995,28   s6.722-0.012,11.199-0.355c0.625-0.08,1.988-0.088,3.205-1.446c0.958-1.034,1.271-3.386,1.271-3.386s0.32-2.761,0.32-5.523v-2.588   C31.99,11.94,31.67,9.179,31.67,9.179z" fill="#E02F2F"/><polygon fill="#FFFFFF" points="12,10 12,22 22,16  "/></g><g/><g/><g/><g/><g/><g/></svg>
                                                    </div>
                                                </div>
                                                <img :src="getThumbnail(image)" class="w-full h-full object-center object-cover" alt="">
                                            </div>
                                        </template>
                                        <template x-if="!image.includes('youtube.com')">
                                            <!-- Image Display -->
                                            <img :src="image" class="w-full h-full object-center object-cover" alt="">
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <div class="prev absolute top-0 flex items-center p-0.5 left-0 z-10 h-full bg-black/40">
                                <div class=" text-white w-4 h-4">
                                    <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><polyline fill="none" points="160 208 80 128 160 48" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="12"/></svg>
                                </div>
                            </div>
                            <div class="next absolute top-0 flex items-center p-0.5 right-0 z-10 h-full bg-black/40">
                                <div class=" text-white w-4 h-4">
                                    <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="256" width="256"/><polyline fill="none" points="96 48 176 128 96 208" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="12"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <script>
                        window.addEventListener('load', function() {
                            const swiper = new Swiper('.swiper', {
                                // Optional parameters
                                direction: 'horizontal',
                                slidesPerView: 3,
                                spaceBetween: 8,
                                loop: false,
                                speed: 500,
                                breakpoints: {
                                    640: {
                                        slidesPerView: 4,
                                        spaceBetween: 8,
                                    },
                                    1024: {
                                        slidesPerView: 6,
                                        spaceBetween: 8,
                                    },
                                },
                                // Navigation arrows
                                navigation: {
                                    nextEl: '.next',
                                    prevEl: '.prev',
                                },
                            });
                        });
                    
                        function imageGallery() {
                            return {
                                images: [
                                    "{{$data->embed}}", // YouTube Embed as the first item
                                    "{{ asset('storage/images/product/' . $data->image) }}",
                                    @foreach ($data->productGallery as $gallery)
                                        "{{ asset('storage/images/product/gallery/' . $gallery->image) }}",
                                    @endforeach
                                ],
                                currentImage: "{{$data->embed}}", // Set YouTube as the first displayed item
                                changeImage(image) {
                                    this.currentImage = image;
                                },
                                getThumbnail(url) {
                                    // Extract YouTube video ID and return the thumbnail URL
                                    const videoId = url.split('embed/')[1];
                                    return `https://img.youtube.com/vi/${videoId}/0.jpg`;
                                }
                            };
                        }
                    </script>
                    
                </div>
                <div class=" flex flex-col justify-center gap-4 py-4 sm:py-8">
                    <div class=" w-full space-y-4 px-4 sm:px-8">
                        <p class=" text-center md:text-left text-2xl font-semibold text-neutral-800">{{$data->name}}</p>
                    </div>
                    <div class=" space-y-2 px-4 sm:px-8">
                        <p class=" text-center md:text-left">Mulai dari <span class=" font-bold text-red-500">Rp. {{ str_replace(',', '.', number_format($data->price))}}</span></p>
                        <p class="  text-justify sm:text-left">{!! nl2br(e($data->description == '' ? 'Description' : $data->description)) !!}</p>
                    </div>
                </div>
                <div class=" md:col-span-3 w-full grid grid-cols-2 gap-2 sticky bottom-0 bg-white/30 py-2 px-4 sm:px-8 backdrop-blur-md z-30 rounded-b-md">
                    <a href="{{route('home')}}">
                        <button
                            class=" text-base w-full py-1 sm:py-2 border rounded-md text-white bg-blue-500 border-blue-500 hover:text-white hover:bg-blue-950 hover:border-blue-950 hover:font-black duration-300 relative">
                            <div class=" absolute w-5 aspect-square top-1.5 sm:top-2.5 left-2">
                                <svg viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24"><path d="m21.146 8.576-7.55-6.135a2.543 2.543 0 0 0-3.192 0L2.855 8.575a1.119 1.119 0 0 0-.416.873v11.543c0 .62.505 1.13 1.125 1.13h5.062c.62 0 1.125-.51 1.125-1.13v-7.306h4.499v7.306c0 .62.505 1.13 1.125 1.13h5.062c.62 0 1.125-.51 1.125-1.13V9.448a1.122 1.122 0 0 0-.416-.872zm-.71 12.421h-5.062V13.68c0-.62-.505-1.119-1.125-1.119H9.75c-.62 0-1.125.499-1.125 1.119v7.317H3.564V9.448l7.55-6.134a1.411 1.411 0 0 1 1.773 0l7.55 6.134v11.549z" fill="currentColor" class="fill-000000"></path></svg>
                            </div>
                            Home
                        </button>
                    </a>
                    <a href="https://wa.me/{{ $no_tlp ?? '' }}">
                        <button
                            class=" text-base w-full py-1 sm:py-2 border rounded-md bg-[#25d366] text-white border-[#25d366] hover:text-white hover:bg-[#1b4b2c] hover:border-[#1b4b2c] hover:font-black duration-300 relative">
                            <div class=" absolute w-5 aspect-square top-1.5 sm:top-2.5 left-2">
                                <svg viewBox="0 0 56.693 56.693" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 56.693 56.693"><path d="M46.38 10.714C41.73 6.057 35.544 3.492 28.954 3.489c-13.579 0-24.63 11.05-24.636 24.633a24.589 24.589 0 0 0 3.289 12.316L4.112 53.204l13.06-3.426a24.614 24.614 0 0 0 11.772 2.999h.01c13.577 0 24.63-11.052 24.635-24.635.002-6.582-2.558-12.772-7.209-17.428zM28.954 48.616h-.009a20.445 20.445 0 0 1-10.421-2.854l-.748-.444-7.75 2.033 2.07-7.555-.488-.775a20.427 20.427 0 0 1-3.13-10.897c.004-11.29 9.19-20.474 20.484-20.474a20.336 20.336 0 0 1 14.476 6.005 20.352 20.352 0 0 1 5.991 14.485c-.004 11.29-9.19 20.476-20.475 20.476z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path><path d="M40.185 33.281c-.615-.308-3.642-1.797-4.206-2.003-.564-.205-.975-.308-1.385.308-.41.617-1.59 2.003-1.949 2.414-.359.41-.718.462-1.334.154-.615-.308-2.599-.958-4.95-3.055-1.83-1.632-3.065-3.648-3.424-4.264-.36-.617-.038-.95.27-1.257.277-.276.615-.719.923-1.078.308-.36.41-.616.616-1.027.205-.41.102-.77-.052-1.078-.153-.308-1.384-3.338-1.897-4.57-.5-1.2-1.008-1.038-1.385-1.057-.359-.018-.77-.022-1.18-.022s-1.077.154-1.642.77c-.564.616-2.154 2.106-2.154 5.135 0 3.03 2.206 5.957 2.513 6.368.308.41 4.341 6.628 10.516 9.294a35.341 35.341 0 0 0 3.509 1.297c1.474.469 2.816.402 3.877.244 1.183-.177 3.642-1.49 4.155-2.927.513-1.438.513-2.67.359-2.927-.154-.257-.564-.41-1.18-.719z" fill-rule="evenodd" clip-rule="evenodd" fill="currentColor" class="fill-000000"></path></svg>
                            </div>
                            WhatApp
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>