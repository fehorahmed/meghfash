<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia><?php echo e(config('app.name', websiteTitle())); ?></title>

        <link rel="apple-touch-icon" href="<?php echo e(asset(general()->favicon())); ?>"/>
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset(general()->favicon())); ?>"/>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <?php if(isset($page['props']['meta'])): ?>
        <?php if($meta=$page['props']['meta']): ?>
        <meta  name="title" property="og:title" content="<?php echo e($meta['title'] ?? config('app.name')); ?>">
        <meta inertia name="description" property="og:description" content="<?php echo e($meta['description'] ?? 'Default description here.'); ?>">
        <meta name="keyword" property="og:keyword" content="<?php echo e($meta['keywords'] ?? ''); ?>">
        <meta name="image" property="og:image" content="<?php echo e($meta['image'] ?? asset('default-image.jpg')); ?>">
        <meta name="url" property="og:url" content="<?php echo e($meta['url'] ?? url()->current()); ?>">
        <link rel="canonical" href="<?php echo e($meta['url'] ?? url()->current()); ?>">

        <?php if(isset($meta['structuredData'])): ?>
       <script type="application/ld+json">
            <?php echo json_encode($meta['structuredData'], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); ?>

        </script>
        <?php endif; ?>
    
        
        <?php endif; ?>
        <?php endif; ?>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=67873bd52495a9001261e143&product=sop' async='async'></script>
        

        <?php echo general()->script_head; ?>

   

        <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?>
        <?php echo app('Illuminate\Foundation\Vite')->reactRefresh(); ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"]); ?>
        <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
    </head>
    <body class="font-sans antialiased">
        <?php echo general()->script_body; ?>

        <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
    </body>
</html>
<?php /**PATH /home/meghfash/demo.meghfashion.com/resources/views/app.blade.php ENDPATH**/ ?>