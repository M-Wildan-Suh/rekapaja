@if($data->productGallery->count())

<section data-business-gallery-section class="w-full max-w-xl mx-auto px-4 md:px-0 py-8">

    {{-- Gallery --}}
    <div class="relative">

        <div data-business-gallery="network" class="swiper networkGallery rounded-2xl overflow-hidden">

            <div class="swiper-wrapper">

                @foreach($data->productGallery as $gallery)

                    <div class="swiper-slide">

                        <div class="overflow-hidden rounded-2xl shadow-md bg-white">

                            <x-guest.lazyfancy-image
                                :image="$gallery->image"
                                class="w-full aspect-square object-cover hover:scale-105 duration-300"/>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- Prev --}}
        <button type="button"
            data-business-gallery-control class="gallery-prev absolute left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white duration-300">

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"/>

            </svg>

        </button>

        {{-- Next --}}
        <button type="button"
            data-business-gallery-control class="gallery-next absolute right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white duration-300">

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"/>

            </svg>

        </button>

    </div>

    {{-- Pagination --}}
    <div data-business-gallery-control class="gallery-pagination mt-5 flex justify-center"></div>

</section>



@endif
