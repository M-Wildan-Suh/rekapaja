@php
    $donutBg = $template->bg_main_color ?? '#FFFAFB';
    $donutTextDark = $template->desc_main_color ?? '#2D2D2D';
    $donutAccent = $template->accent_color ?? '#E57384';
    $donutAccentLight = $template->product_second_color ?? '#FFF0F3';
@endphp

<section class="relative w-full min-h-[90vh] flex items-center justify-center overflow-hidden py-20">
    <!-- Premium Ambient Background -->
    <div class="absolute inset-0 z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-pulse" style="background-color: {{ $donutAccentLight }}; animation-duration: 8s;"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[60vw] h-[60vw] rounded-full mix-blend-multiply filter blur-[120px] opacity-30 animate-pulse" style="background-color: {{ $donutAccent }}; animation-duration: 12s; animation-delay: 2s;"></div>
        <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px]"></div>
    </div>

    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12 lg:px-16 flex flex-col lg:flex-row items-center gap-16">
        
        <!-- Text Content -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center text-center lg:text-left space-y-8">
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full bg-white/70 backdrop-blur-xl border border-white/50 shadow-sm self-center lg:self-start transform transition hover:scale-105 duration-300">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75" style="background-color: {{ $donutAccent }};"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3" style="background-color: {{ $donutAccent }};"></span>
                </span>
                <span class="text-xs sm:text-sm font-bold tracking-[0.2em] uppercase text-gray-800">Premium Choice</span>
            </div>
            
            <div class="space-y-4">
                <h1 class="text-5xl sm:text-6xl lg:text-8xl font-black tracking-tighter leading-[0.95]" style="color: {{ $donutTextDark }};">
                    {{ $data->name }}
                </h1>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-light tracking-tight opacity-90" style="color: {{ $donutAccent }};">
                    {{ $data->subtitle ?: 'Elegansi dalam setiap detail.' }}
                </h2>
            </div>
            
            <p class="text-lg sm:text-xl text-gray-600 leading-relaxed font-light max-w-xl mx-auto lg:mx-0">
                {{ $data->description ?? 'Menghadirkan kualitas terbaik dengan sentuhan profesional. Temukan pengalaman luar biasa yang dirancang khusus untuk Anda.' }}
            </p>

            <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                <div class="group px-6 py-3 rounded-2xl bg-white/60 backdrop-blur-md border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 cursor-default">
                    <div class="p-2 rounded-full bg-white/80 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5" style="color: {{ $donutAccent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800 uppercase tracking-wider">Top Quality</span>
                </div>
                <div class="group px-6 py-3 rounded-2xl bg-white/60 backdrop-blur-md border border-white/60 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 cursor-default">
                    <div class="p-2 rounded-full bg-white/80 shadow-sm group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5" style="color: {{ $donutAccent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-800 uppercase tracking-wider">Trusted</span>
                </div>
            </div>
        </div>

        <!-- Image Content -->
        <div class="w-full lg:w-1/2 relative flex justify-center lg:justify-end mt-12 lg:mt-0">
            <!-- Decorative Elements -->
            <div class="absolute top-[-5%] right-[-5%] w-32 h-32 border border-white/40 rounded-full z-0"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-48 h-48 border border-white/40 rounded-full z-0"></div>

            <div class="relative w-full max-w-[500px] aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl group border-[8px] border-white/50 backdrop-blur-sm z-10">
                <div class="absolute inset-0 bg-gradient-to-tr from-black/40 via-transparent to-transparent z-10 mix-blend-overlay"></div>
                <img src="{{ $data->image ?? 'https://images.unsplash.com/photo-1551024601-bec78aea704b?q=80&w=800&auto=format&fit=crop' }}" alt="{{ $data->name }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110">
                
                <!-- Glassmorphism Floating Badge -->
                <div class="absolute bottom-8 left-8 right-8 z-20 bg-white/20 backdrop-blur-2xl border border-white/40 rounded-3xl p-6 text-white shadow-2xl transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-700 ease-out">
                    <p class="text-xs font-bold uppercase tracking-[0.3em] opacity-90 mb-2">Explore</p>
                    <p class="font-light text-xl leading-snug">{{ $data->subtitle ?: 'Kualitas tanpa kompromi.' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
