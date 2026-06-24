<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Autentikasi'); ?> — AlkhoMart</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="font-sans antialiased bg-[#f8f9fc] text-slate-600 min-h-screen flex flex-col">
    
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-200 py-3 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <a class="flex items-center gap-2 text-2xl font-extrabold text-blue-600 hover:text-blue-700 transition" href="<?php echo e(route('pembeli.products')); ?>">
                    <i class="bi bi-wallet2"></i> AlkhoMart
                </a>
                
                <!-- Links -->
                <a class="px-3 py-2 rounded-lg font-semibold text-sm text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition" href="<?php echo e(route('pembeli.products')); ?>">
                    Catalog
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center p-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/layouts/auth.blade.php ENDPATH**/ ?>