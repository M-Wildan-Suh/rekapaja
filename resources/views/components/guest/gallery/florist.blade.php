<div class="w-full max-w-[560px] mx-auto px-4 md:px-0 py-2">
    <div class="swiper floristGallery">

        <div class="swiper-wrapper">

            @foreach($data->productGallery as $gallery)

                <div class="swiper-slide">

                    <div class="relative overflow-hidden rounded-[28px] shadow-xl">

                        <img
                            src="{{ $gallery->image }}"
                            alt=""
                            class="w-full h-[240px] sm:h-[320px] object-cover">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                        <div class="absolute bottom-5 left-5 sm:bottom-7 sm:left-7 text-white">

                            <div class="w-10 sm:w-14 h-1 rounded-full bg-white mb-3 sm:mb-4"></div>

                            <h2 class="text-xl sm:text-2xl font-bold">
                                {{ $gallery->title ?? 'Beautiful Bouquet' }}
                            </h2>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="swiper-button-prev floristPrev"></div>
        <div class="swiper-button-next floristNext"></div>

        <div class="swiper-pagination floristPagination"></div>

    </div>

</div>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>

new Swiper(".floristGallery",{

    loop:true,

    centeredSlides:true,

    slidesPerView:1.1,

    spaceBetween:20,

    pagination:{
        el:".floristPagination",
        clickable:true,
    },

    navigation:{
        nextEl:".floristNext",
        prevEl:".floristPrev",
    },

    breakpoints:{
        640:{
            slidesPerView:1.2,
        },
        768:{
            slidesPerView:1.35,
        },
        1024:{
            slidesPerView:1.45,
        }
    }

});

</script>

<style>

.floristGallery{
    overflow:hidden;
    padding:12px 0 52px;
    width:100%;
}

.floristGallery .swiper-slide{
    transform:scale(.82);
    opacity:.45;
    transition:.4s;
}

.floristGallery .swiper-slide-active{
    transform:scale(1);
    opacity:1;
}

.floristGallery .swiper-button-prev,
.floristGallery .swiper-button-next{
    width:44px;
    height:44px;
    border-radius:999px;
    background:rgba(255,255,255,.85);
    color:#555;
    backdrop-filter:blur(8px);
}

.floristGallery .swiper-button-prev::after,
.floristGallery .swiper-button-next::after{
    font-size:14px;
    font-weight:bold;
}

.floristGallery .swiper-pagination{
    margin-top:18px;
    position:relative;
}

.floristGallery .swiper-pagination-bullet{
    width:10px;
    height:10px;
}

.floristGallery .swiper-pagination-bullet-active{
    width:28px;
    border-radius:999px;
    background:#ec4899;
}

</style>
