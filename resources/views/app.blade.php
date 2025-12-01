<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', websiteTitle()) }}</title>

        <link rel="apple-touch-icon" href="{{asset(general()->favicon())}}"/>
        <link rel="shortcut icon" type="image/x-icon" href="{{asset(general()->favicon())}}"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @if(isset($page['props']['meta']))
        @if($meta=$page['props']['meta'])
        <meta  name="title" property="og:title" content="{{ $meta['title'] ?? config('app.name') }}">
        <meta inertia name="description" property="og:description" content="{{ $meta['description'] ?? 'Default description here.' }}">
        <meta name="keyword" property="og:keyword" content="{{ $meta['keywords'] ?? '' }}">
        <meta name="image" property="og:image" content="{{ $meta['image'] ?? asset('default-image.jpg') }}">
        <meta name="url" property="og:url" content="{{ $meta['url'] ?? url()->current() }}">
        <link rel="canonical" href="{{ $meta['url'] ?? url()->current() }}">

        @if(isset($meta['structuredData']))
        <script type="application/ld+json">
            {!! json_encode($meta['structuredData'], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT) !!}
        </script>
        @endif
    
        
        @endif
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=67873bd52495a9001261e143&product=sop' async='async'></script>
        

        {!!general()->script_head!!}
   

        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
        
        <style>
            section.product__section.section--padding.pb-0.homeProduct
            {
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        {!!general()->script_body!!}
        @inertia
    </body>
</html>
