@props(['route', 'active', 'slug'])
<a href="{{route($route, [ 'slug' => $slug])}}" class="{{ request()->routeIs($active) ? 'border-[#664c17] bg-[#DB9F24] text-white border-r-4' : 'text-neutral-500 hover:border-black hover:text-black hover:bg-neutral-100 hover:border-r-4' }} w-full flex flex-row gap-2 items-center p-3 rounded-l-md  font-semibold duration-300">
    {{$slot}}
</a>