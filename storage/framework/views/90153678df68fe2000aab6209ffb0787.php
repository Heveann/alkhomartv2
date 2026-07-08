<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Admin'); ?> — AlkhoMart Dashboard</title>

    <!-- Google Fonts (Metropolis replacement) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- DataTables Tailwind CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <style>
        /* ══════════════════════════════════════════
           SB Admin Pro Theme Variables & Utilities
           ══════════════════════════════════════════ */
        :root {
            --primary: #0061f2;
            --primary-hover: #0f52ba;
            --dark: #212832;
            --gray: #69707a;
            --gray-light: #64748b;
            --bg-body: #f2f6fc;
            --border-color: rgba(33, 40, 50, 0.125);
            --shadow-sm: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.15);
        }

        body {
            background-color: var(--bg-body) !important;
            color: var(--gray) !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            overflow-x: hidden;
        }

        /* Topnav */
        .sb-topnav {
            background-color: #fff;
            box-shadow: var(--shadow-sm);
            height: 4.5rem; /* 72px */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: fixed;
            top: 0;
            right: 0;
            left: 0; /* Default mobile */
            z-index: 1030;
            transition: left 0.3s ease-in-out;
        }

        /* Sidenav */
        .sb-sidenav-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
            width: 100vw;
        }
        .sb-sidenav {
            width: 15rem;
            background-color: #fff;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            flex-shrink: 0;
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
            z-index: 1040;
        }
        .sb-sidenav-brand {
            height: 4.5rem;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--dark);
            border-bottom: 1px solid var(--border-color);
            flex-shrink: 0;
            letter-spacing: -0.02em;
        }
        .sb-sidenav-brand i {
            color: var(--primary);
            margin-right: 0.6rem;
            font-size: 1.4rem;
        }
        .sb-sidenav-menu {
            flex-grow: 1;
            padding-bottom: 2rem;
        }
        .sb-sidenav-footer {
            padding: 1.5rem;
            background-color: rgba(33, 40, 50, 0.02);
            border-top: 1px solid var(--border-color);
            flex-shrink: 0;
        }

        /* Sidenav Links */
        .nav-heading {
            padding: 1.75rem 1rem 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--gray-light);
        }
        .nav-link {
            padding: 0.75rem 1rem;
            color: var(--gray);
            font-weight: 500;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.15s ease-in-out;
        }
        .nav-link:hover { color: var(--primary); }
        .nav-link.active { color: var(--primary); font-weight: 600; }
        .nav-link-icon {
            margin-right: 0.75rem;
            color: var(--gray-light);
            font-size: 1.1rem;
        }
        .nav-link:hover .nav-link-icon, .nav-link.active .nav-link-icon {
            color: var(--primary);
        }

        /* Main Content */
        .sb-main {
            flex-grow: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding-top: 4.5rem;
        }

        /* Cards */
        .card {
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid var(--border-color);
            border-radius: 0.35rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            display: flex;
            flex-direction: column;
        }
        .card-header {
            padding: 1rem 1.35rem;
            margin-bottom: 0;
            background-color: rgba(33, 40, 50, 0.03);
            border-bottom: 1px solid var(--border-color);
            font-weight: 500;
            color: var(--primary);
        }
        .card-body {
            flex: 1 1 auto;
            padding: 1.35rem;
        }

        /* Page Headers */
        .page-header {
            padding-top: 2rem;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: transparent;
        }
        .page-header-title {
            font-size: 1.75rem;
            font-weight: 500;
            color: var(--dark);
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }
        .page-header-icon {
            margin-right: 0.75rem;
            color: rgba(33, 40, 50, 0.5);
            font-size: 1.5rem;
        }
        .page-header-subtitle {
            font-size: 0.875rem;
            color: var(--gray);
            margin-top: 0;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            text-align: center;
            vertical-align: middle;
            user-select: none;
            padding: 0.4375rem 1rem;
            font-size: 0.875rem;
            line-height: 1.5;
            border-radius: 0.35rem;
            transition: all 0.15s ease-in-out;
            cursor: pointer;
            border: 1px solid transparent;
        }
        .btn i { margin-right: 0.375rem; }
        .btn-primary { background-color: var(--primary); border-color: var(--primary); color: #fff; }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); color: #fff;}
        .btn-success { background-color: #00ac69; border-color: #00ac69; color: #fff; }
        .btn-success:hover { background-color: #008a54; border-color: #008a54; color: #fff;}
        .btn-danger { background-color: #e81500; border-color: #e81500; color: #fff; }
        .btn-danger:hover { background-color: #bd1100; border-color: #bd1100; color: #fff;}
        .btn-light { background-color: #fff; border-color: var(--border-color); color: var(--dark); }
        .btn-light:hover { background-color: #f2f6fc; color: var(--primary); }

        /* Action Icons */
        .btn-action-success { color: #00ac69; border: 1px solid rgba(0, 172, 105, 0.25); background-color: #fff; }
        .btn-action-success:hover { background-color: rgba(0, 172, 105, 0.1); border-color: #00ac69; color: #008a54; }
        .btn-action-danger { color: #e81500; border: 1px solid rgba(232, 21, 0, 0.25); background-color: #fff; }
        .btn-action-danger:hover { background-color: rgba(232, 21, 0, 0.1); border-color: #e81500; color: #bd1100; }
        .btn-action-primary { color: #0061f2; border: 1px solid rgba(0, 97, 242, 0.25); background-color: #fff; }
        .btn-action-primary:hover { background-color: rgba(0, 97, 242, 0.1); border-color: #0061f2; color: #0f52ba; }

        /* Form Controls */
        .form-control, .form-select {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            font-weight: 400;
            line-height: 1;
            color: #69707a;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #c5ccd6;
            appearance: none;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-control:focus, .form-select:focus {
            color: #69707a;
            background-color: #fff;
            border-color: #80b0f9;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(0, 97, 242, 0.25);
        }

        /* Datatables Overrides for SB Admin Pro */
        div.dataTables_wrapper div.dt-controls {
            padding: 0 0 1rem 0 !important;
            background: transparent !important;
            border-bottom: none !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        div.dataTables_wrapper div.dataTables_length select {
            border: 1px solid #c5ccd6 !important;
            border-radius: 0.35rem !important;
            padding: 0.375rem 1.75rem 0.375rem 0.75rem !important;
        }
        div.dataTables_wrapper div.dataTables_filter input {
            border: 1px solid #c5ccd6 !important;
            border-radius: 0.35rem !important;
            padding: 0.375rem 0.75rem !important;
        }
        table.dataTable {
            width: 100% !important;
            min-width: 600px !important;
            margin-top: 0 !important;
            margin-bottom: 1rem !important;
            border-collapse: collapse !important;
        }
        table.dataTable thead th {
            background-color: rgba(33, 40, 50, 0.03) !important;
            color: var(--dark) !important;
            text-transform: none !important;
            font-size: 0.875rem !important;
            border-bottom: 2px solid var(--border-color) !important;
            padding: 0.75rem !important;
        }
        table.dataTable tbody td {
            font-size: 0.875rem !important;
            color: var(--gray) !important;
            border-bottom: 1px solid var(--border-color) !important;
            padding: 0.75rem !important;
            vertical-align: middle;
        }
        div.dataTables_wrapper div.dt-footer {
            padding: 1rem 0 0 0 !important;
            border-top: none !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .dataTables_paginate .paginate_button {
            padding: 0.375rem 0.75rem !important;
            margin: 0 2px !important;
            border: 1px solid transparent !important;
            border-radius: 0.35rem !important;
            background: transparent !important;
            color: var(--primary) !important;
        }
        .dataTables_paginate .paginate_button:hover {
            background-color: #e0e5ec !important;
            border-color: #e0e5ec !important;
            color: #0a58ca !important;
        }
        .dataTables_paginate .paginate_button.current, .dataTables_paginate .paginate_button.current:hover {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
            box-shadow: none !important;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.25em 0.5em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.35rem;
        }
        .badge-primary { background-color: var(--primary); }
        .badge-success { background-color: #00ac69; }
        .badge-danger { background-color: #e81500; }
        .badge-warning { background-color: #f4a100; color: #212832; }
        .badge-info { background-color: #00cfd5; }
        .badge-secondary { background-color: var(--gray); }

        /* Mobile Sidebar */
        .sb-sidenav-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(15, 23, 42, 0.5);
            z-index: 1035;
            backdrop-filter: blur(2px);
        }
        @media (max-width: 991.98px) {
            .sb-sidenav {
                position: fixed;
                top: 0;
                bottom: 0;
                z-index: 1040;
                transform: translateX(-100%);
            }
            .sb-sidenav-toggled .sb-sidenav {
                transform: translateX(0);
            }
        }
        @media (min-width: 992px) {
            .sb-sidenav-backdrop {
                display: none !important;
            }
            .sb-topnav {
                left: 15rem;
            }
            .sb-sidenav-toggled .sb-sidenav {
                transform: translateX(-100%);
                width: 0;
                overflow: hidden;
            }
            .sb-sidenav-toggled .sb-topnav {
                left: 0;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body x-data="{ toggled: false }" :class="toggled ? 'sb-sidenav-toggled' : ''">

    <!-- Mobile Backdrop -->
    <div x-show="toggled" @click="toggled = false" class="sb-sidenav-backdrop" x-transition.opacity style="display: none;" x-cloak></div>

    <!-- Topnav -->
    <nav class="sb-topnav">
        <div class="flex items-center">
            <button aria-label="Toggle sidebar" class="text-slate-500 hover:text-slate-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded mr-4 bg-transparent border-none p-0 cursor-pointer" @click="toggled = !toggled">
                <i class="bi bi-list text-2xl" style="margin:0;"></i>
            </button>

        </div>

        <!-- Navbar Right -->
        <ul class="flex items-center gap-4 m-0 p-0 list-none">
            <!-- Profile Dropdown -->
            <li class="relative" x-data="{ userMenuOpen: false }" @click.away="userMenuOpen = false">
                <button @click="userMenuOpen = !userMenuOpen" aria-label="Menu Pengguna" aria-haspopup="true" :aria-expanded="userMenuOpen" class="flex items-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded bg-transparent border-none cursor-pointer p-0">
                    <div class="hidden md:block text-right mr-2">
                        <div class="text-sm font-medium" style="color: var(--gray);"><?php echo e(auth()->user()->name ?? 'Administrator'); ?></div>
                    </div>
                    <div class="w-9 h-9 rounded-full text-white flex items-center justify-center font-bold" style="background-color: var(--primary);">
                        <i class="bi bi-person-fill"></i>
                    </div>
                </button>
                <div x-show="userMenuOpen" 
                     x-transition.duration.200ms
                     class="absolute right-0 top-full mt-2 w-48 bg-white border border-slate-100 rounded-md shadow-lg py-1 z-50"
                     style="display: none;">
                    <h6 class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider mb-0 border-b border-slate-100">
                        <div class="text-slate-800 font-bold mb-1"><?php echo e(auth()->user()->name); ?></div>
                        <?php echo e(auth()->user()->email); ?>

                    </h6>
                    <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition" style="text-decoration:none;">
                        <i class="bi bi-person mr-2 text-slate-400"></i> Profile
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:text-blue-600 hover:bg-slate-50 transition" style="text-decoration:none;">
                        <i class="bi bi-gear mr-2 text-slate-400"></i> Settings
                    </a>
                    <div class="border-t border-slate-100 my-1"></div>
                    <form action="<?php echo e(route('logout')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-slate-600 hover:text-blue-600 hover:bg-slate-50 bg-transparent border-none transition">
                            <i class="bi bi-box-arrow-right mr-2 text-slate-400"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Sidenav Container -->
    <div class="sb-sidenav-container">
        
        <!-- Sidenav -->
        <nav class="sb-sidenav">
            <div class="sb-sidenav-brand">
                <i class="bi bi-cart-check-fill"></i> AlkhoMart
            </div>
            <div class="sb-sidenav-menu">
                <div class="nav-heading">Core</div>
                <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                    <div class="nav-link-icon"><i class="bi bi-activity"></i></div>
                    Dashboard
                </a>
                <a class="nav-link <?php echo e(request()->routeIs('admin.kasir.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.kasir.index')); ?>">
                    <div class="nav-link-icon"><i class="bi bi-calculator"></i></div>
                    Point of Sale
                </a>

                <div class="nav-heading">Management</div>
                <a class="nav-link <?php echo e(request()->routeIs('admin.categories.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.categories.index')); ?>">
                    <div class="nav-link-icon"><i class="bi bi-tags"></i></div>
                    Kategori
                </a>
                <a class="nav-link <?php echo e(request()->routeIs('admin.products.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.products.index')); ?>">
                    <div class="nav-link-icon"><i class="bi bi-box-seam"></i></div>
                    Inventory
                </a>
                <a class="nav-link" href="<?php echo e(route('admin.produk-preview')); ?>" target="_blank">
                    <div class="nav-link-icon"><i class="bi bi-eye"></i></div>
                    Produk Preview
                </a>
                <a class="nav-link <?php echo e(request()->routeIs('admin.orders.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.orders.index')); ?>">
                    <div class="nav-link-icon"><i class="bi bi-receipt"></i></div>
                    Rekap Pesanan
                </a>
                <a class="nav-link <?php echo e(request()->routeIs('admin.laba.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.laba.index')); ?>">
                    <div class="nav-link-icon"><i class="bi bi-graph-up-arrow"></i></div>
                    Laba / Keuntungan
                </a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="sb-main bg-slate-50">
            <div class="px-4 sm:px-6 lg:px-8 py-4 w-full max-w-full mx-auto flex-grow">
                <?php echo $__env->yieldContent('content'); ?>
                <?php echo e($slot ?? ''); ?>

            </div>
            
            <!-- Footer -->
            <footer class="mt-auto py-4 bg-white border-t border-slate-200">
                <div class="px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm" style="color: var(--gray);">
                        <div>Copyright &copy; AlkhoMart <?php echo e(date('Y')); ?></div>
                        <div>
                            <a href="#" class="hover:underline" style="color: var(--primary); text-decoration:none;">Privacy Policy</a>
                            &middot;
                            <a href="#" class="hover:underline" style="color: var(--primary); text-decoration:none;">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    
    <!-- SweetAlert2 (Notyf Style) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-toast { padding: 12px 16px !important; }
        .swal2-toast .swal2-icon { margin: 0 12px 0 0 !important; width: 28px !important; height: 28px !important; }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                color: '#fff',
                iconColor: '#fff',
                customClass: {
                    popup: 'font-sans shadow-lg rounded-lg border-0',
                    title: 'font-medium text-sm m-0',
                    timerProgressBar: 'bg-white/30'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            <?php if(session('success')): ?>
                Toast.fire({
                    icon: 'success',
                    title: '<?php echo e(session('success')); ?>',
                    background: '#00ac69' // SB Admin Pro success
                });
            <?php endif; ?>

            <?php if(session('error')): ?>
                Toast.fire({
                    icon: 'error',
                    title: '<?php echo e(session('error')); ?>',
                    background: '#e81500' // SB Admin Pro danger
                });
            <?php endif; ?>
        });

        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e81500',
                cancelButtonColor: '#69707a',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'font-sans rounded-xl shadow-xl border-0',
                    title: 'font-bold',
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Global Status Update Confirmation
        function confirmStatusUpdate(event, form, text, confirmText, confirmColor, icon) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Aksi',
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#69707a',
                confirmButtonText: confirmText,
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'font-sans rounded-xl shadow-xl border-0',
                    title: 'font-bold',
                    confirmButton: 'btn text-white',
                    cancelButton: 'btn btn-light'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/layouts/admin.blade.php ENDPATH**/ ?>