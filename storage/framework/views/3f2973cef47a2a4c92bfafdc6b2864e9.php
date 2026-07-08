<?php $__env->startSection('title', 'Kelola Kategori'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="{ showModal: <?php echo e($errors->any() && !old('_method') ? 'true' : 'false'); ?>, showEditModal: <?php echo e($errors->any() && old('_method') == 'PUT' ? 'true' : 'false'); ?> }" @open-edit-modal.window="showEditModal = true">
    
    <div class="page-header flex justify-between items-center">
        <div>
            <h1 class="page-header-title">
                <div class="page-header-icon"><i class="bi bi-tags"></i></div>
                Daftar Kategori
            </h1>
            <div class="page-header-subtitle">Kelola kategori produk toko Anda</div>
        </div>
        <button @click="showModal = true" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </button>
    </div>

    <!-- Table Data -->
    <div class="card">
        <div class="card-header flex items-center">
            <i class="bi bi-tags mr-2"></i> Kategori Produk
        </div>
        <div class="card-body p-0">
            <div class="overflow-x-auto p-4">
                <table id="categoriesTable" class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 75%">Nama Kategori</th>
                            <th style="width: 20%" class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showModal" @click="showModal = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/50" aria-hidden="true"></div>

            <div x-show="showModal" x-transition class="relative inline-block w-full max-w-md p-4 sm:p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg" role="dialog" aria-modal="true" aria-labelledby="modal-title-add">
                <div class="flex items-center justify-between mb-5">
                    <h3 id="modal-title-add" class="text-lg font-bold text-dark flex items-center">
                        <i class="bi bi-tag text-primary mr-2"></i> Tambah Kategori
                    </h3>
                    <button @click="showModal = false" aria-label="Tutup modal tambah kategori" class="text-slate-400 hover:text-slate-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded transition bg-transparent border-none">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-5">
                        <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?php echo e(old('name')); ?>" required placeholder="Contoh: Baju Pria">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-2 text-sm font-medium text-red-500"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="btn btn-light">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="showEditModal" @click="showEditModal = false" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/50" aria-hidden="true"></div>

            <div x-show="showEditModal" x-transition class="relative inline-block w-full max-w-md p-4 sm:p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg" role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">
                <div class="flex items-center justify-between mb-5">
                    <h3 id="modal-title-edit" class="text-lg font-bold text-dark flex items-center">
                        <i class="bi bi-pencil-square text-primary mr-2"></i> Edit Kategori
                    </h3>
                    <button @click="showEditModal = false" aria-label="Tutup modal edit kategori" class="text-slate-400 hover:text-slate-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 rounded transition bg-transparent border-none">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                
                <form id="editCategoryForm" method="POST" action="<?php echo e(old('_method') == 'PUT' && old('category_id') ? route('admin.categories.update', old('category_id')) : ''); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="category_id" id="editCategoryId" value="<?php echo e(old('category_id')); ?>">
                    <div class="mb-5">
                        <label class="block text-xs font-bold uppercase tracking-wider mb-2" style="color: var(--gray-light);">Nama Kategori <span class="text-red-500">*</span></label>
                        <input type="text" id="editCategoryName" name="name" class="form-control" value="<?php echo e(old('_method') == 'PUT' ? old('name') : ''); ?>" required placeholder="Contoh: Baju Pria">
                        <?php if($errors->has('name') && old('_method') == 'PUT'): ?>
                            <p class="mt-2 text-sm font-medium text-red-500"><?php echo e($errors->first('name')); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="showEditModal = false" class="btn btn-light">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    if ($.fn.DataTable.isDataTable('#categoriesTable')) {
        $('#categoriesTable').DataTable().destroy();
    }
    var table = $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('admin.categories.index')); ?>",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', className: 'font-medium text-dark' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-right' }
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampil _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Menampilkan 0 data",
                infoFiltered: "(disaring dari _MAX_ data)",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Lanjut",
                    previous: "Kembali"
                }
            },
            dom: '<"dt-controls"lf>t<"dt-footer"ip>'
        });
    function openEditCategory(id, name) {
        document.getElementById('editCategoryForm').action = '/admin/categories/' + id;
        document.getElementById('editCategoryId').value = id;
        document.getElementById('editCategoryName').value = name;
        window.dispatchEvent(new CustomEvent('open-edit-modal'));
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>