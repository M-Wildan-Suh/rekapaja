<div class=" mx-auto rounded-md bg-white min-h-screen relative">
    <div class=" space-y-6">
        <div class=" min-h-screen pt-6 relative space-y-4 bg-[#FCC737]">
            <div class=" w-full max-w-[640px] mx-auto pl-4 sm:pl-24 relative text-white pb-4">
                <div class=" absolute left-5 sm:left-20 top-5 w-60 sm:w-72 p-4 sm:py-5 bg-[#E73879] -rotate-6 rounded-sm">
                    <p class=" text-2xl font-black text-center">{{$data->name}}</p>
                    <p class=" text-center">{{$data->subtitle}}</p>
                </div>
                <div class=" absolute top-20 right-2 sm:right-24 w-28 sm:w-36 aspect-square bg-white rounded-full overflow-hidden rotate-6">
                    <img src="{{ $data->image }}" class=" w-full h-full object-cover " alt="">
                </div>
                <div class=" pt-36 sm:pt-40 pl-8">
                    <div class=" w-52 sm:w-64 bg-white aspect-video overflow-hidden rounded-sm">
                        <div class="w-full h-full">
                            <iframe src="{{$data->embed}}" frameborder="0" class="w-full h-full" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <x-guest.description color="#E73879" :data="$data" />
            
            <div class="w-full relative bg-[#E73879]">
                <div class=" w-full h-10 mb-4">
                    <svg class=" w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                        <path fill="#FCC737" d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path>
                        <path fill="#FCC737" opacity="0.33" d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z"></path>
                        <path fill="#FCC737" opacity="0.66" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z"></path>
                    </svg>
                </div>
                <div class=" w-full max-w-[640px] mx-auto grid grid-cols-1 gap-3 px-4 sm:px-0">
                    @foreach ($data->productHighlight as $item)
                        <div class=" bg-[#FCC737] w-full p-3 rounded-xl flex gap-2 text-white">
                            <div class=" min-w-24 h-24 aspect-square rounded-full border-2 overflow-hidden text-teal-400">
                                <img src="{{ $item->image }}" class="w-full h-full object-cover" alt="">
                            </div>
                            <div class=" flex flex-col justify-between gap-2">
                                <p class=" line-clamp-1 font-semibold">{{$item->title}}</p>
                                <x-guest.product.detail-button :item="$item" class="py-1.5 px-3 flex items-center gap-2 text-sm border-2 border-white rounded-md hover:bg-white/50 duration-300" />
                                <div class="flex gap-1">
                                    @for ($i = 0; $i < 5; $i++)
                                        <div class=" w-4 h-4 text-teal-400">
                                            <svg viewBox="0 0 58 58" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none" fill-rule="evenodd">
                                                    <path d="M30.757 1.144 38.2 16.948a1.968 1.968 0 0 0 1.475 1.123l16.644 2.534a2.08 2.08 0 0 1 1.086 3.502L45.362 36.408a2.115 2.115 0 0 0-.563 1.818l2.843 17.37a1.98 1.98 0 0 1-2.843 2.164l-14.887-8.201a1.88 1.88 0 0 0-1.824 0l-14.887 8.2a1.98 1.98 0 0 1-2.843-2.163l2.843-17.37a2.115 2.115 0 0 0-.563-1.818L.594 24.107a2.08 2.08 0 0 1 1.086-3.502l16.644-2.534a1.968 1.968 0 0 0 1.475-1.123l7.444-15.804a1.92 1.92 0 0 1 3.514 0Z" fill="#ffffff" class="fill-f6ab27"></path>
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
                <div class=" w-full h-10 mt-4">
                    <svg class=" rotate-180 w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                        <path fill="#FCC737" d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path>
                        <path fill="#FCC737" opacity="0.33" d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z"></path>
                        <path fill="#FCC737" opacity="0.66" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z"></path>
                    </svg>
                </div>
            </div>
            <div class="w-full max-w-[640px] mx-auto px-4 md:px-0 relative">
                @include('components.guest.gallery')
            </div>
            <x-guest.contact :role="$role" classa="text-white bg-[#F26B0F] border-[#F26B0F] hover:text-white hover:bg-[#d55805] hover:border-[#d55805]" classb="text-white bg-[#F26B0F] border-[#F26B0F] hover:text-white hover:bg-[#d55805] hover:border-[#d55805]" :data="$data" :notlp="$no_tlp"/>
        </div>
    </div>
</div>
