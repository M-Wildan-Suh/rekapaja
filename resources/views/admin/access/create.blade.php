<x-app-layout title="Admin - Tambah Akses">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Akses') }}
        </h2>
    </x-slot>

    <div class="py-4 px-4">
        <div class="max-w-xl mx-auto">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class=" p-4 md:p-6 text-gray-900">
                    <form action="{{route('access.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class=" w-full space-y-6">
                            <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
                                <label for="user">User</label>
                                <select name="user" class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" id="user" required>
                                    @foreach ($user as $item)
                                        <option value="{{$item->id}}" @selected((string) old('user') === (string) $item->id)>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class=" flex flex-col gap-2 text-sm sm:text-base font-medium">
                                <label for="product">Usaha</label>
                                <select name="product" class="text-sm sm:text-base w-full border-gray-300 focus:border-[#ff7100] focus:ring-[#ff7100] rounded-md shadow-sm" id="productr" required>
                                    @if (empty($product) || $product->isEmpty())
                                        <option value="" disabled selected>Data tidak tersedia</option>
                                    @endif
                                    @foreach ($product as $item)
                                        <option value="{{$item->id}}" @selected((string) old('product') === (string) $item->id)>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                @if (empty($product) || $product->isEmpty())
                                    <button disabled class=" opacity-60 cursor-not-allowed font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                                @else
                                    <button class=" font-bold w-full py-2 bg-[#ff7100] hover:bg-[#b95300] duration-300 text-white rounded-md text-center">Simpan</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
