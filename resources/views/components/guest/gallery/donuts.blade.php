<div class="w-full max-w-[640px] mx-auto relative overflow-hidden py-6">
    <!-- Gallery Header -->
    <div class="text-center mb-6">
        <h3 class="text-2xl sm:text-3xl font-black text-gray-800 tracking-tight" style="color: {{ $template->accent_color ?? '#D9758F' }};">Manisnya Momen</h3>
        <p class="text-sm text-gray-500 mt-1 font-medium tracking-widest uppercase">Galeri Spesial Kami</p>
    </div>

    <!-- Swiper Container -->
    <div class="swiper modern-donut-gallery w-full px-4 sm:px-8 pb-10">
        <div class="swiper-wrapper">
            @foreach ($data->productGallery as $item)
                <div class="swiper-slide group relative w-[80%] sm:w-[60%] aspect-[4/5] sm:aspect-square rounded-[2rem] overflow-hidden shadow-2xl transition-all duration-500">
                    <x-guest.lazyfancy-image class="w-full h-full object-cover object-center transform group-hover:scale-110 transition-transform duration-700 ease-out" :image="$item->image" />
                    
                    <!-- Aesthetic Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <!-- Decorative Element on hover -->
                    <div class="absolute bottom-6 left-6 right-6 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 text-white">
                        <div class="w-10 h-1 bg-white/80 rounded-full mb-3"></div>
                        <p class="font-bold text-lg leading-tight shadow-sm">Delicious Treat</p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Sleek Pagination -->
        <div class="swiper-pagination !bottom-0"></div>

        <!-- Elegant Navigation Arrows (Glassmorphism) -->
        <div class="gallery-prev absolute top-1/2 -translate-y-1/2 left-2 sm:left-4 z-10 w-12 h-12 flex items-center justify-center rounded-full bg-white/30 backdrop-blur-md border border-white/50 text-white shadow-lg cursor-pointer hover:bg-white/50 hover:scale-110 transition-all duration-300">
            <svg class="w-6 h-6 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
        </div>
        <div class="gallery-next absolute top-1/2 -translate-y-1/2 right-2 sm:right-4 z-10 w-12 h-12 flex items-center justify-center rounded-full bg-white/30 backdrop-blur-md border border-white/50 text-white shadow-lg cursor-pointer hover:bg-white/50 hover:scale-110 transition-all duration-300">
            <svg class="w-6 h-6 drop-shadow-md" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
        </div>
    </div>

    <!-- Custom Swiper Styles -->
    <style>
        .modern-donut-gallery .swiper-slide {
            opacity: 0.5;
            transform: scale(0.85);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            filter: blur(2px);
        }
        .modern-donut-gallery .swiper-slide-active {
            opacity: 1;
            transform: scale(1);
            filter: blur(0px);
            z-index: 10;
        }
        .modern-donut-gallery .swiper-pagination-bullet {
            width: 8px;
            height: 8px;
            background: {{ $template->accent_color ?? '#D9758F' }};
            opacity: 0.3;
            transition: all 0.3s ease;
        }
        .modern-donut-gallery .swiper-pagination-bullet-active {
            width: 24px;
            border-radius: 4px;
            opacity: 1;
        }
    </style>

    <!-- Swiper Initialization -->
    <script>
        window.addEventListener('load', function() {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.modern-donut-gallery', {
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    loop: true,
                    speed: 800,
                    coverflowEffect: {
                        rotate: 0,
                        stretch: 0,
                        depth: 100,
                        modifier: 2,
                        slideShadows: false,
                    },
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.gallery-next',
                        prevEl: '.gallery-prev',
                    },
                });
            }
        });
    </script>
</div>
