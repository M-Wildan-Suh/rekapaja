<div class="w-full max-w-[600px] mx-auto px-2 sm:px-0 py-2">
    <div class="swiper floristGallery">

        <div class="swiper-wrapper">

            @foreach($data->productGallery as $gallery)

                <div class="swiper-slide">

                    <div class="relative overflow-hidden rounded-[24px] shadow-xl bg-white">

                        <img
                            src="{{ $gallery->image }}"
                            alt=""
                            class="w-full h-[160px] sm:h-[180px] md:h-[190px] object-cover bg-[#FFF5F8]">

                    </div>

                </div>

            @endforeach

        </div>

        <div class="swiper-button-prev floristPrev"></div>
        <div class="swiper-button-next floristNext"></div>

    </div>

</div>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>

new Swiper(".floristGallery",{

    loop:true,

    centeredSlides:true,

    slidesPerView:2.05,
    spaceBetween:6,

    navigation:{
        nextEl:".floristNext",
        prevEl:".floristPrev",
    },

    breakpoints:{
        640:{
            slidesPerView:2.35,
            spaceBetween:8,
        },
        768:{
            slidesPerView:2.6,
            spaceBetween:8,
        },
        1024:{
            slidesPerView:2.85,
            spaceBetween:6,
        }
    }

});

</script>

<style>

.floristGallery{
    overflow:hidden;
    padding:12px 4px;
    width:100%;
}

.floristGallery .swiper-slide{
    height:auto;
    transform:scale(.84);
    opacity:.62;
    transition:transform .35s ease, opacity .35s ease;
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
