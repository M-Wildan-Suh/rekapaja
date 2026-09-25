<div data-business-live-editor data-restore-draft="{{ session()->hasOldInput() ? 'true' : 'false' }}" data-preview-url="{{ route('product.template.preview', $product) }}" class="w-full relative">
    <form id="business-design" action="{{ route('product.template.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <input type="hidden" name="active_tab" value="design">
        @foreach (['background', 'header', 'gallery', 'article', 'product', 'contact'] as $section)
            @include('components.admin.template.' . $section)
        @endforeach
    </form>
    @include('components.admin.template.youtube')
    <p data-preview-status role="status" aria-live="polite" class="sr-only"></p>
    <div data-business-preview class="w-full antialiased">
        @include('components.guest.business-page', $landingPage)
    </div>
</div>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DynaPuff:wdth,wght@75..100,400..700&family=Dancing+Script:wght@400..700&family=Patrick+Hand&display=swap">
