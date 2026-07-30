@if($data->productGallery->count())

<section class="w-full max-w-[600px] mx-auto px-4 md:px-0 py-8">

    {{-- Judul --}}
    <div class="mb-6">

        <h2 class="text-3xl font-bold text-slate-800">
             Produk
        </h2>

        <p class="mt-1 text-gray-500">
            Dokumentasi Produk Kami
        </p>

    </div>

    {{-- Gallery --}}
    <div class="relative">

        <div class="swiper networkGallery rounded-2xl overflow-hidden">

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
        <button
            class="gallery-prev absolute left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white duration-300">

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
        <button
            class="gallery-next absolute right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-blue-600 hover:text-white duration-300">

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
    <div class="gallery-pagination mt-5 flex justify-center"></div>

</section>

<script>
window.addEventListener('load', function () {

    new Swiper('.networkGallery', {

        slidesPerView: 1,
        spaceBetween: 12,
        loop: true,
        speed: 600,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },

        breakpoints: {

            640: {
                slidesPerView: 2,
                spaceBetween: 12,
            }

        },

        navigation: {
            nextEl: '.gallery-next',
            prevEl: '.gallery-prev',
        },

        pagination: {
            el: '.gallery-pagination',
            clickable: true,
        }

    });

});
</script>

@endif