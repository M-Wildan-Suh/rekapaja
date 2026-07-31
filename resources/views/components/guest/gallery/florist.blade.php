<div class="py-8">

    <div class="swiper floristGallery">

        <div class="swiper-wrapper">

            @foreach($data->productGallery as $gallery)

                <div class="swiper-slide">

                    <div class="relative overflow-hidden rounded-[35px] shadow-2xl">

                        <img
                            src="{{ $gallery->image }}"
                            alt=""
                            class="w-full h-[420px] object-cover">

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                        <div class="absolute bottom-8 left-8 text-white">

                            <div class="w-14 h-1 rounded-full bg-white mb-4"></div>

                            <h2 class="text-3xl font-bold">
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

    slidesPerView:1.25,

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
            slidesPerView:1.5,
        },
        768:{
            slidesPerView:2.2,
        },
        1024:{
            slidesPerView:2.6,
        }
    }

});

</script>

<style>

.floristGallery{
    overflow:hidden;
    padding:20px 0 60px;
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
    width:55px;
    height:55px;
    border-radius:999px;
    background:rgba(255,255,255,.85);
    color:#555;
    backdrop-filter:blur(8px);
}

.floristGallery .swiper-button-prev::after,
.floristGallery .swiper-button-next::after{
    font-size:18px;
    font-weight:bold;
}

.floristGallery .swiper-pagination{
    margin-top:25px;
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