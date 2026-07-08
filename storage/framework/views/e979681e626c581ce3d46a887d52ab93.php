<?php $__env->startSection('title', 'Login Akun'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full max-w-[900px] bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] overflow-hidden flex flex-col md:flex-row min-h-[500px]">
    
    <!-- Left Side: Image Background -->
    <div class="hidden md:flex w-full md:w-1/2 bg-slate-50 justify-center items-center p-8 md:p-12">
        <img src="<?php echo e(asset('storage/img/login.png')); ?>" alt="" aria-hidden="true" class="w-full max-w-[350px] h-auto object-contain drop-shadow-lg">
    </div>

    <!-- Right Side: Login Form -->
    <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
        
        <!-- Logo & Title -->
        <div class="flex flex-col items-center mb-8">
            <div class="mb-3">
                <svg width="32" height="32" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="18" height="18" fill="#0d6efd" rx="4"/>
                    <rect y="22" width="18" height="18" fill="#212529" rx="4"/>
                    <rect x="22" width="18" height="18" fill="#6f42c1" rx="4"/>
                    <rect x="22" y="22" width="18" height="18" fill="#0dcaf0" rx="4"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Login Akun</h2>
        </div>

        <!-- Tabs -->
        <div class="flex border-b border-slate-200 mb-8 w-full justify-center gap-12 px-4">
            <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold pb-3 border-b-2 border-[#6f42c1] text-slate-800 px-2">
                Login
            </a>
            <a href="<?php echo e(route('register')); ?>" class="text-sm font-semibold pb-3 border-b-2 border-transparent text-slate-400 hover:text-slate-600 hover:border-slate-300 transition px-2">
                Daftar
            </a>
        </div>

        <!-- Form -->
        <form method="POST" action="<?php echo e(route('login')); ?>" class="w-full max-w-[320px] mx-auto">
            <?php echo csrf_field(); ?>
            
            <div class="mb-4">
                <label for="email" class="block text-xs font-semibold text-slate-500 mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required autofocus
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder:text-slate-400 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-red-500/20 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="Masukkan email Anda">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="mb-6 relative" x-data="{ show: false }">
                <label for="password" class="block text-xs font-semibold text-slate-500 mb-1.5">Password</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" name="password" id="password" required
                        class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-lg text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition shadow-sm placeholder:text-slate-400 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-red-500/20 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Masukkan password Anda">
                    <button type="button" @click="show = !show" :aria-pressed="show" aria-label="Tampilkan password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded">
                        <i class="bi" :class="show ? 'bi-eye' : 'bi-eye-slash'"></i>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-xs text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <button type="submit" class="w-full py-2.5 bg-gradient-to-r from-[#6f42c1] to-[#0d6efd] hover:from-[#59339d] hover:to-[#0a58ca] text-white font-semibold text-sm rounded-lg shadow-md hover:shadow-lg transition transform hover:-translate-y-px">
                Masuk
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/auth/login.blade.php ENDPATH**/ ?>