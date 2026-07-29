@if ($data->description)
@php
    $donutDescBg = $template->desc_main_color ?? '#FFF0F3';
    $donutDescText = $template->desc_text_color ?? '#4A4A4A';
    $donutAccent = $template->accent_color ?? '#E57384';
@endphp

<div class="w-full max-w-7xl mx-auto my-24 px-6 md:px-12 lg:px-16 relative">
    <!-- Decorative background elements -->
    <div class="absolute left-[10%] top-1/2 -translate-y-1/2 w-[300px] h-[300px] rounded-full mix-blend-multiply filter blur-[80px] opacity-20 pointer-events-none" style="background-color: {{ $donutAccent }};"></div>
    
    <div class="relative w-full rounded-[3.5rem] p-10 md:p-16 lg:p-24 overflow-hidden border border-white/50 shadow-2xl backdrop-blur-xl group transition-all duration-700 hover:shadow-3xl" style="background-color: {{ $donutDescBg }}80; box-shadow: 0 25px 50px -12px {{ $donutDescBg }}50;">
        
        <div class="absolute inset-0 bg-white/40 group-hover:bg-white/50 transition-colors duration-700"></div>
        <div class="absolute -top-32 -right-32 w-[500px] h-[500px] rounded-full mix-blend-overlay filter blur-[100px] opacity-30 transition-all duration-1000 group-hover:opacity-40" style="background-color: {{ $donutAccent }};"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-center lg:items-start gap-12 lg:gap-24">
            
            <div class="w-full lg:w-5/12 flex flex-col items-center lg:items-start text-center lg:text-left">
                <div class="w-16 h-16 mb-8 rounded-[1.25rem] flex items-center justify-center bg-white/70 backdrop-blur-md shadow-lg border border-white/60 transform -rotate-6 group-hover:rotate-0 transition-transform duration-500" style="color: {{ $donutAccent }};">
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                </div>
                <div class="space-y-4">
                    <h3 class="text-sm font-black uppercase tracking-[0.3em] opacity-60" style="color: {{ $donutDescText }};">Tentang Kami</h3>
                    <h2 class="text-4xl lg:text-5xl font-black tracking-tighter leading-[1.1]" style="color: {{ $donutDescText }};">
                        Filosofi di Balik <br/><span style="color: {{ $donutAccent }}">{{ $data->name }}</span>
                    </h2>
                </div>
            </div>
            
            <div class="w-full lg:w-7/12 flex items-center relative">
                <!-- Vertical divider line for large screens -->
                <div class="hidden lg:block absolute left-[-3rem] top-[10%] bottom-[10%] w-[1px] bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
                
                <p class="text-lg lg:text-xl xl:text-2xl leading-relaxed lg:leading-[1.8] font-light opacity-90 relative" style="color: {{ $donutDescText }};">
                    <span class="absolute -top-6 -left-6 text-6xl opacity-10 font-serif">"</span>
                    {!! nl2br(e($data->description)) !!}
                    <span class="absolute -bottom-10 -right-4 text-6xl opacity-10 font-serif rotate-180">"</span>
                </p>
            </div>
            
        </div>
    </div>
</div>
@endif
