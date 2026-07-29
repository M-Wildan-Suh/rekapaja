@props(['route', 'name', 'slug'])
<a href="{{ route($route, ['slug' => $slug]) }}">
    <div class="{{ request()->routeIs($route) ? 'bg-black' : 'bg-[#DB9F24]' }} py-2 w-full border text-center rounded-full font-medium hover:bg-black text-white duration-300">{{$name}}</div>
</a>