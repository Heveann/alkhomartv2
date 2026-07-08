<?php $__env->startSection('title', 'Manage Products'); ?>
<?php $__env->startSection('topbar-title', 'Manage Products'); ?>

<?php $__env->startPush('styles'); ?>

<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.10.5/dist/autoNumeric.min.js"></script>
<style>
    /* ── Metric cards ── */
    .metric-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / .04);
        transition: box-shadow .2s, transform .2s;
    }
    .metric-card:hover {
        box-shadow: 0 4px 16px 0 rgb(0 0 0 / .07);
        transform: translateY(-1px);
    }
    .metric-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .metric-label {
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-bottom: 4px;
    }
    .metric-value {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.1;
        letter-spacing: -.02em;
    }
    .metric-sub {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 4px;
    }

    /* ── Table card ── */
    .table-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / .04);
        overflow: hidden;
    }
    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        background: #2563eb;
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background .18s, box-shadow .18s, transform .12s;
        box-shadow: 0 2px 8px 0 rgb(37 99 235 / .25);
    }
    .btn-add:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px 0 rgb(37 99 235 / .35);
        transform: translateY(-1px);
        color: #fff;
        text-decoration: none;
    }

    /* ══ DataTables — full-width, no floats ══ */

    /* The outer wrapper MUST fill the card */
    div.dataTables_wrapper {
        width: 100% !important;
        box-sizing: border-box !important;
    }

    /* Controls row: Show X entries ←→ Search */
    div.dataTables_wrapper div.dt-controls {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: wrap !important;
        gap: 1rem !important;
        padding: 14px 24px !important;
        background: #fafafa !important;
        border-bottom: 1px solid #f1f5f9 !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    div.dataTables_wrapper div.dataTables_length,
    div.dataTables_wrapper div.dataTables_filter {
        float: none !important;
        margin: 0 !important;
        padding: 0 !important;
        background: transparent !important;
        border: none !important;
        width: auto !important;
        display: flex !important;
        align-items: center !important;
        font-size: 13px !important;
        color: #64748b !important;
    }
    div.dataTables_wrapper div.dataTables_length select {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 6px 28px 6px 10px !important;
        font-size: 13px !important;
        color: #334155 !important;
        outline: none !important;
        margin: 0 6px !important;
        cursor: pointer !important;
    }
    div.dataTables_wrapper div.dataTables_filter input {
        background: #f8fafc !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 7px 14px !important;
        font-size: 13px !important;
        color: #334155 !important;
        width: 220px !important;
        outline: none !important;
        margin-left: 8px !important;
        transition: border-color .18s, box-shadow .18s !important;
    }
    div.dataTables_wrapper div.dataTables_filter input:focus {
        border-color: #93c5fd !important;
        box-shadow: 0 0 0 3px rgb(59 130 246 / .12) !important;
    }

    /* Table itself */
    table.dataTable {
        width: 100% !important;
        min-width: 800px !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }
    table.dataTable thead th {
        background: #f8fafc !important;
        color: #64748b !important;
        font-size: 11px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: .07em !important;
        padding: 14px 20px !important;
        border-bottom: 1px solid #e2e8f0 !important;
        white-space: nowrap !important;
        text-align: left !important;
    }
    table.dataTable thead th.sorting:before,
    table.dataTable thead th.sorting:after,
    table.dataTable thead th.sorting_asc:before,
    table.dataTable thead th.sorting_asc:after,
    table.dataTable thead th.sorting_desc:before,
    table.dataTable thead th.sorting_desc:after {
        opacity: .4 !important;
    }
    table.dataTable tbody td {
        padding: 14px 20px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        font-size: 13.5px !important;
        color: #334155 !important;
        vertical-align: middle !important;
    }
    table.dataTable tbody tr:last-child td { border-bottom: none !important; }
    table.dataTable tbody tr:hover td { background: #f8fafc !important; }

    /* Table scroll wrapper */
    div.dataTables_wrapper div.dataTables_scroll,
    div.dataTables_wrapper .table-scroll {
        overflow-x: auto !important;
        width: 100% !important;
    }

    /* Footer: info left, paginate right */
    div.dataTables_wrapper div.dt-footer {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        flex-wrap: wrap !important;
        gap: 1rem !important;
        padding: 12px 24px !important;
        border-top: 1px solid #f1f5f9 !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }
    div.dataTables_wrapper div.dataTables_info {
        float: none !important;
        padding: 0 !important;
        font-size: 13px !important;
        color: #64748b !important;
    }
    div.dataTables_wrapper div.dataTables_paginate {
        float: none !important;
        padding: 0 !important;
    }
    .dataTables_paginate .paginate_button {
        display: inline-flex !important;
        align-items: center !important;
        padding: 5px 11px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        margin: 0 2px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        background: #fff !important;
        cursor: pointer !important;
        transition: all .15s !important;
        text-decoration: none !important;
    }
    .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }
    .dataTables_paginate .paginate_button.current,
    .dataTables_paginate .paginate_button.current:hover {
        background: #2563eb !important;
        border-color: #2563eb !important;
        color: #fff !important;
        box-shadow: 0 2px 6px 0 rgb(37 99 235 / .3) !important;
    }
    .dataTables_paginate .paginate_button.disabled,
    .dataTables_paginate .paginate_button.disabled:hover {
        opacity: .4 !important;
        cursor: not-allowed !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header flex justify-between items-center">
    <div>
        <h1 class="page-header-title">
            <div class="page-header-icon"><i class="bi bi-box-seam"></i></div>
            Inventory
        </h1>
        <div class="page-header-subtitle">Manage products and catalog</div>
    </div>
</div>


<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-7">

    
    <div class="metric-card">
        <div class="metric-icon" style="background:#eff6ff; color:#2563eb;">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div>
            <div class="metric-label">Total Products</div>
            <div class="metric-value"><?php echo e(number_format($totalProducts)); ?></div>
            <div class="metric-sub">SKUs in catalog</div>
        </div>
    </div>

    
    <div class="metric-card">
        <div class="metric-icon" style="background:#fff7ed; color:#ea580c;">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div>
            <div class="metric-label">Low Stock Alerts</div>
            <div class="metric-value" style="color: <?php echo e($lowStockCount > 0 ? '#dc2626' : '#16a34a'); ?>">
                <?php echo e(number_format($lowStockCount)); ?>

            </div>
            <div class="metric-sub">Items with ≤ 10 units</div>
        </div>
    </div>

    
    <div class="metric-card">
        <div class="metric-icon" style="background:#f0fdf4; color:#16a34a;">
            <i class="bi bi-currency-exchange"></i>
        </div>
        <div>
            <div class="metric-label">Inventory Value</div>
            <div class="metric-value" style="font-size:20px;">
                Rp <?php echo e(number_format($totalValue, 0, ',', '.')); ?>

            </div>
            <div class="metric-sub">Selling price × stock</div>
        </div>
    </div>

</div>


<div class="table-card">

    
    <div class="table-card-header">
        <div class="table-card-title">
            <span style="width:32px;height:32px;background:#eff6ff;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;">
                <i class="bi bi-grid-1x2-fill" style="color:#2563eb;font-size:14px;"></i>
            </span>
            Product Catalog
            <span class="ml-2 px-2.5 py-0.5 bg-slate-100 text-slate-500 text-xs font-semibold rounded-full" id="totalBadge">—</span>
        </div>
        <button type="button" class="btn-add" id="btnAddProduct" onclick="openAddProductModal()">
            <i class="bi bi-plus-lg"></i> Add Product
        </button>
    </div>

    
    <div style="width:100%;overflow-x:auto;">
        <table id="productsTable" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th style="text-align:right">Selling Price</th>
                    <th style="text-align:right">Cost Price</th>
                    <th style="text-align:center">Stock</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

</div>


<div id="modalAddProduct" style="display:none;position:fixed;inset:0;z-index:9999;">
    
    <div id="modalBackdrop"
         onclick="closeAddProductModal()"
         style="position:absolute;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(4px);transition:opacity .25s;"></div>

    
    <div id="modalPanel"
         style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
                width:min(680px,95vw);max-height:90vh;display:flex;flex-direction:column;overflow:hidden;
                background:#fff;border-radius:20px;box-shadow:0 24px 80px rgba(0,0,0,.18);
                transition:transform .25s,opacity .25s;">

        
        <div style="display:flex;align-items:center;justify-content:space-between;padding:clamp(16px, 4vw, 20px) clamp(16px, 5vw, 28px);border-bottom:1px solid #f1f5f9;">
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="width:38px;height:38px;background:#eff6ff;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;">
                    <i class="bi bi-box-seam-fill" style="color:#2563eb;font-size:16px;"></i>
                </span>
                <div>
                    <h3 id="addProductModalTitle" style="margin:0;font-size:16px;font-weight:800;color:#0f172a;letter-spacing:-.02em;">Tambah Produk Baru</h3>
                    <div style="font-size:12px;color:#94a3b8;font-weight:500;">Isi form untuk menambahkan produk ke katalog</div>
                </div>
            </div>
            <button type="button" aria-label="Tutup modal" onclick="closeAddProductModal()"
                    style="width:36px;height:36px;border-radius:10px;border:1px solid #e2e8f0;background:#f8fafc;
                           display:inline-flex;align-items:center;justify-content:center;cursor:pointer;
                           color:#64748b;font-size:18px;transition:all .15s;"
                    onmouseover="this.style.background='#fee2e2';this.style.color='#dc2626';this.style.borderColor='#fca5a5';"
                    onmouseout="this.style.background='#f8fafc';this.style.color='#64748b';this.style.borderColor='#e2e8f0';">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        
        <div style="padding:clamp(16px, 5vw, 24px) clamp(16px, 5vw, 28px);overflow-y:auto;flex:1;">
            <?php if($errors->any()): ?>
                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start;">
                    <i class="bi bi-exclamation-circle-fill" style="color:#dc2626;margin-top:2px;flex-shrink:0;"></i>
                    <div>
                        <div style="font-weight:700;color:#991b1b;font-size:13px;margin-bottom:4px;">Terdapat kesalahan:</div>
                        <ul style="margin:0;padding-left:16px;font-size:13px;color:#dc2626;">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data" id="formAddProduct">
                <?php echo csrf_field(); ?>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Nama Produk <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="nama_produk"
                           value="<?php echo e(old('nama_produk')); ?>"
                           placeholder="Masukkan nama produk"
                           required
                           style="width:100%;padding:11px 16px;background:#f8fafc;border:1px solid <?php echo e($errors->has('nama_produk') ? '#fca5a5' : '#e2e8f0'); ?>;border-radius:12px;font-size:14px;color:#334155;font-weight:500;outline:none;box-sizing:border-box;transition:border-color .15s,box-shadow .15s;"
                           onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                           onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                </div>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Kategori <span style="color:#94a3b8;font-weight:500;text-transform:none;">(Opsional)</span></label>
                    <select name="category_id"
                            style="width:100%;padding:11px 16px;background:#f8fafc;border:1px solid <?php echo e($errors->has('category_id') ? '#fca5a5' : '#e2e8f0'); ?>;border-radius:12px;font-size:14px;color:#334155;font-weight:500;outline:none;box-sizing:border-box;cursor:pointer;"
                            onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                            onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                        <option value="">-- Tanpa Kategori --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>" <?php echo e(old('category_id') == $cat->id ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Harga Jual <span style="color:#ef4444;">*</span></label>
                        <div style="display:flex;">
                            <span style="display:inline-flex;align-items:center;padding:0 14px;background:#f1f5f9;border:1px solid #e2e8f0;border-right:none;border-radius:12px 0 0 12px;font-size:13px;color:#64748b;font-weight:700;">Rp</span>
                            <input type="text" id="add_harga_display" inputmode="numeric"
                                   value="<?php echo e(old('harga') ? number_format(old('harga'), 0, ',', '.') : ''); ?>"
                                   placeholder="0" required
                                   style="flex:1;padding:11px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:0 12px 12px 0;font-size:14px;color:#334155;font-weight:500;outline:none;min-width:0;"
                                   onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                                   onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                            <input type="hidden" name="harga" id="add_harga_raw" value="<?php echo e(old('harga')); ?>">
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Harga Modal <span style="color:#ef4444;">*</span></label>
                        <div style="display:flex;">
                            <span style="display:inline-flex;align-items:center;padding:0 14px;background:#f1f5f9;border:1px solid #e2e8f0;border-right:none;border-radius:12px 0 0 12px;font-size:13px;color:#64748b;font-weight:700;">Rp</span>
                            <input type="text" id="add_harga_modal_display" inputmode="numeric"
                                   value="<?php echo e(old('harga_modal') ? number_format(old('harga_modal'), 0, ',', '.') : ''); ?>"
                                   placeholder="0" required
                                   style="flex:1;padding:11px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:0 12px 12px 0;font-size:14px;color:#334155;font-weight:500;outline:none;min-width:0;"
                                   onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                                   onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                            <input type="hidden" name="harga_modal" id="add_harga_modal_raw" value="<?php echo e(old('harga_modal')); ?>">
                        </div>
                    </div>
                </div>


                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Stok Awal <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="stok" value="<?php echo e(old('stok', 0)); ?>" placeholder="0" min="0" required
                           style="width:50%;padding:11px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;font-size:14px;color:#334155;font-weight:500;outline:none;box-sizing:border-box;"
                           onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                           onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                </div>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Gambar Produk (Bisa lebih dari 1)</label>
                    <div style="border:2px dashed #e2e8f0;border-radius:14px;padding:20px;text-align:center;cursor:pointer;transition:border-color .15s;"
                         id="dropZone"
                         onclick="document.getElementById('gambarInput').click()"
                         ondragover="event.preventDefault();this.style.borderColor='#93c5fd';"
                         ondragleave="this.style.borderColor='#e2e8f0';"
                         ondrop="handleDrop(event)">
                        <div id="dropPlaceholder">
                            <i class="bi bi-cloud-arrow-up" style="font-size:28px;color:#cbd5e1;display:block;margin-bottom:6px;"></i>
                            <div style="font-size:13px;color:#94a3b8;font-weight:500;">Klik untuk pilih gambar atau drag & drop</div>
                            <div style="font-size:11px;color:#cbd5e1;margin-top:4px;">Bisa pilih lebih dari 1 file — Maks. 2MB</div>
                        </div>
                    </div>
                    <div id="imagePreviewWrap" style="display:none;grid-template-columns:repeat(auto-fill,minmax(80px,1fr));gap:10px;margin-top:12px;"></div>
                    <input type="file" name="gambar[]" id="gambarInput" accept="image/*" multiple style="display:none;" onchange="handleGambarInput(this)">
                </div>

                
                <div style="margin-bottom:8px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Ukuran & Stok <span style="font-weight:500;color:#cbd5e1;">(Opsional)</span></label>
                        <button type="button" onclick="addSizeRowModal()"
                                style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#fff;border:1px solid #bfdbfe;border-radius:10px;color:#2563eb;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.background='#eff6ff';"
                                onmouseout="this.style.background='#fff';">
                            <i class="bi bi-plus-lg"></i> Tambah Ukuran
                        </button>
                    </div>
                    <div id="sizesContainerModal" style="display:flex;flex-direction:column;gap:10px;"></div>
                    <p style="font-size:12px;color:#94a3b8;margin-top:8px;"><i class="bi bi-info-circle me-1"></i>Tambahkan ukuran (S, M, L, XL) beserta stok jika produk memiliki varian.</p>
                </div>
            </form>
        </div>

        
        <div style="display:flex;flex-wrap:wrap;justify-content:flex-end;gap:10px;padding:16px clamp(16px, 5vw, 28px);border-top:1px solid #f1f5f9;background:#fafafa;border-radius:0 0 20px 20px;">
            <button type="button" onclick="closeAddProductModal()"
                    style="padding:10px 22px;background:#f1f5f9;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#475569;cursor:pointer;transition:background .15s;"
                    onmouseover="this.style.background='#e2e8f0';"
                    onmouseout="this.style.background='#f1f5f9';">Batal</button>
            <button type="submit" form="formAddProduct"
                    style="padding:10px 24px;background:#2563eb;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#fff;cursor:pointer;transition:background .15s;box-shadow:0 2px 8px rgba(37,99,235,.25);"
                    onmouseover="this.style.background='#1d4ed8';"
                    onmouseout="this.style.background='#2563eb';">
                <i class="bi bi-floppy me-2"></i>Simpan Produk
            </button>
        </div>
    </div>
</div>


<div id="modalEditProduct" role="dialog" aria-modal="true" aria-labelledby="editProductModalTitle" style="display:none;position:fixed;inset:0;z-index:9999;">
    
    <div onclick="closeEditModal()"
         style="position:absolute;inset:0;background:rgba(15,23,42,.45);backdrop-filter:blur(4px);"></div>

    
    <div id="modalEditPanel"
         style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
                width:min(680px,95vw);max-height:90vh;display:flex;flex-direction:column;overflow:hidden;
                background:#fff;border-radius:20px;box-shadow:0 24px 80px rgba(0,0,0,.18);">

        
        <div style="display:flex;align-items:center;justify-content:space-between;padding:clamp(16px, 4vw, 20px) clamp(16px, 5vw, 28px);border-bottom:1px solid #f1f5f9;">
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="width:38px;height:38px;background:#f0fdf4;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;">
                    <i class="bi bi-pencil-square" style="color:#16a34a;font-size:16px;"></i>
                </span>
                <div>
                    <h3 id="editProductModalTitle" style="margin:0;font-size:16px;font-weight:800;color:#0f172a;letter-spacing:-.02em;">Edit Produk</h3>
                    <div style="font-size:12px;color:#94a3b8;font-weight:500;">Perbarui data produk di katalog</div>
                </div>
            </div>
            <button type="button" aria-label="Tutup modal" onclick="closeEditModal()"
                    style="width:36px;height:36px;border-radius:10px;border:1px solid #e2e8f0;background:#f8fafc;
                           display:inline-flex;align-items:center;justify-content:center;cursor:pointer;
                           color:#64748b;font-size:18px;transition:all .15s;"
                    onmouseover="this.style.background='#fee2e2';this.style.color='#dc2626';this.style.borderColor='#fca5a5';"
                    onmouseout="this.style.background='#f8fafc';this.style.color='#64748b';this.style.borderColor='#e2e8f0';">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        
        <div id="editModalLoader" style="padding:60px 28px;text-align:center;flex:1;">
            <div style="width:36px;height:36px;border:3px solid #e2e8f0;border-top-color:#2563eb;border-radius:50%;animation:spin .7s linear infinite;margin:0 auto 12px;"></div>
            <div style="font-size:13px;color:#94a3b8;font-weight:500;">Memuat data produk...</div>
        </div>

        
        <div id="editModalBody" style="padding:clamp(16px, 5vw, 24px) clamp(16px, 5vw, 28px);display:none;flex:1;overflow-y:auto;">
            <form id="formEditProduct" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Nama Produk <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="nama_produk" id="edit_nama_produk" required
                           style="width:100%;padding:11px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;font-size:14px;color:#334155;font-weight:500;outline:none;box-sizing:border-box;"
                           onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                           onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                </div>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Kategori <span style="color:#94a3b8;font-weight:500;text-transform:none;">(Opsional)</span></label>
                    <select name="category_id" id="edit_category_id"
                            style="width:100%;padding:11px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;font-size:14px;color:#334155;font-weight:500;outline:none;box-sizing:border-box;cursor:pointer;"
                            onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                            onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                        <option value="">-- Tanpa Kategori --</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px;">
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Harga Jual <span style="color:#ef4444;">*</span></label>
                        <div style="display:flex;">
                            <span style="display:inline-flex;align-items:center;padding:0 14px;background:#f1f5f9;border:1px solid #e2e8f0;border-right:none;border-radius:12px 0 0 12px;font-size:13px;color:#64748b;font-weight:700;">Rp</span>
                            <input type="text" id="edit_harga_display" inputmode="numeric"
                                   style="flex:1;padding:11px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:0 12px 12px 0;font-size:14px;color:#334155;font-weight:500;outline:none;min-width:0;"
                                   onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                                   onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';"
                                   oninput="formatRibuanInput(this, 'edit_harga_raw')">
                            <input type="hidden" name="harga" id="edit_harga_raw">
                        </div>
                    </div>
                    <div>
                        <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Harga Modal <span style="color:#ef4444;">*</span></label>
                        <div style="display:flex;">
                            <span style="display:inline-flex;align-items:center;padding:0 14px;background:#f1f5f9;border:1px solid #e2e8f0;border-right:none;border-radius:12px 0 0 12px;font-size:13px;color:#64748b;font-weight:700;">Rp</span>
                            <input type="text" id="edit_harga_modal_display" inputmode="numeric"
                                   style="flex:1;padding:11px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:0 12px 12px 0;font-size:14px;color:#334155;font-weight:500;outline:none;min-width:0;"
                                   onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                                   onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';"
                                   oninput="formatRibuanInput(this, 'edit_harga_modal_raw')">
                            <input type="hidden" name="harga_modal" id="edit_harga_modal_raw">
                        </div>
                    </div>
                </div>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Stok <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="stok" id="edit_stok" min="0" required
                           style="width:50%;padding:11px 16px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;font-size:14px;color:#334155;font-weight:500;outline:none;box-sizing:border-box;"
                           onfocus="this.style.borderColor='#93c5fd';this.style.boxShadow='0 0 0 3px rgba(59,130,246,.12)';"
                           onblur="this.style.boxShadow='none';this.style.borderColor='#e2e8f0';">
                </div>

                
                <div style="margin-bottom:18px;">
                    <label style="display:block;font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;">Gambar Produk</label>
                    <div id="editCurrentImg" style="display:none;margin-bottom:12px;gap:12px;flex-wrap:wrap;">
                        <!-- Populated by JS -->
                    </div>
                    <div style="border:2px dashed #e2e8f0;border-radius:14px;padding:18px;text-align:center;cursor:pointer;transition:border-color .15s;"
                         onclick="document.getElementById('editGambarInput').click()"
                         ondragover="event.preventDefault();this.style.borderColor='#93c5fd';"
                         ondragleave="this.style.borderColor='#e2e8f0';"
                         ondrop="handleEditDrop(event)">
                        <div id="editDropPlaceholder">
                            <i class="bi bi-cloud-arrow-up" style="font-size:24px;color:#cbd5e1;display:block;margin-bottom:4px;"></i>
                            <div style="font-size:12px;color:#94a3b8;">Klik atau drag gambar baru (opsional)</div>
                        </div>
                    </div>
                    <div id="editImagePreviewWrap" style="display:none;grid-template-columns:repeat(auto-fill,minmax(80px,1fr));gap:10px;margin-top:12px;"></div>
                    <input type="file" name="gambar[]" id="editGambarInput" accept="image/*" multiple style="display:none;" onchange="handleEditGambarInput(this)">
                    <p style="font-size:12px;color:#94a3b8;margin-top:6px;"><i class="bi bi-info-circle me-1"></i>Pilih file baru untuk menambah gambar ke produk ini.</p>
                </div>

                
                <div style="margin-bottom:8px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <label style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.06em;">Ukuran & Stok <span style="font-weight:500;color:#cbd5e1;">(Opsional)</span></label>
                        <button type="button" onclick="addSizeRowEdit()"
                                style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;background:#fff;border:1px solid #bfdbfe;border-radius:10px;color:#2563eb;font-size:12px;font-weight:700;cursor:pointer;transition:all .15s;"
                                onmouseover="this.style.background='#eff6ff';"
                                onmouseout="this.style.background='#fff';">
                            <i class="bi bi-plus-lg"></i> Tambah Ukuran
                        </button>
                    </div>
                    <div id="sizesContainerEdit" style="display:flex;flex-direction:column;gap:10px;"></div>
                </div>
            </form>
        </div>

        
        <div style="display:flex;flex-wrap:wrap;justify-content:flex-end;gap:10px;padding:16px clamp(16px, 5vw, 28px);border-top:1px solid #f1f5f9;background:#fafafa;border-radius:0 0 20px 20px;">
            <button type="button" onclick="closeEditModal()"
                    style="padding:10px 22px;background:#f1f5f9;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#475569;cursor:pointer;transition:background .15s;"
                    onmouseover="this.style.background='#e2e8f0';"
                    onmouseout="this.style.background='#f1f5f9';">Batal</button>
            <button type="submit" form="formEditProduct"
                    style="padding:10px 24px;background:#16a34a;border:none;border-radius:10px;font-size:13px;font-weight:700;color:#fff;cursor:pointer;transition:background .15s;box-shadow:0 2px 8px rgba(22,163,74,.25);"
                    onmouseover="this.style.background='#15803d';"
                    onmouseout="this.style.background='#16a34a';">
                <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    if ($.fn.DataTable.isDataTable('#productsTable')) {
        $('#productsTable').DataTable().destroy();
    }
    var table = $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "<?php echo e(route('admin.products.index')); ?>",
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '40px',
                render: function(data) {
                    return '<span style="color:#94a3b8;font-size:12px;font-weight:600;">' + data + '</span>';
                }
            },
            {
                data: 'gambar',
                name: 'gambar',
                orderable: false,
                searchable: false,
                width: '60px'
            },
            {
                data: 'nama_produk',
                name: 'nama_produk',
                render: function(data) {
                    return '<span style="font-weight:600;color:#0f172a;">' + data + '</span>';
                }
            },
            {
                data: 'category_name',
                name: 'category.name',
                render: function(data) {
                    return '<span style="display:inline-flex;align-items:center;padding:2px 10px;border-radius:6px;font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;">' + (data || '—') + '</span>';
                }
            },
            {
                data: 'harga',
                name: 'harga',
                className: 'text-right',
                render: function(data) {
                    return '<span style="font-weight:700;color:#0f172a;">' + data + '</span>';
                }
            },
            {
                data: 'harga_modal',
                name: 'harga_modal',
                className: 'text-right',
                render: function(data) {
                    return '<span style="font-weight:500;color:#64748b;">' + data + '</span>';
                }
            },
            {
                data: 'stok',
                name: 'stok',
                className: 'text-center'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-right'
            }
        ],
        language: {
            search: '',
            searchPlaceholder: 'Search products...',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'No products found',
            infoFiltered: '(filtered from _MAX_ total)',
            paginate: {
                previous: '<i class="bi bi-chevron-left"></i> Prev',
                next:     'Next <i class="bi bi-chevron-right"></i>'
            },
            processing: '<div class="flex items-center justify-center gap-3 py-8 text-slate-400"><div class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin"></div> Loading...</div>',
            zeroRecords: '<div class="py-12 text-center text-slate-400"><i class="bi bi-inbox text-4xl block mb-2"></i>No products found</div>'
        },
        createdRow: function(row, data, dataIndex) {
            if (data.stok_raw <= 0) {
                $(row).css('background-color', '#fef2f2'); // bg-red-50
                // Also optionally add a slight red tint to td borders if needed, but background is enough.
            } else if (data.stok_raw <= 10) {
                $(row).css('background-color', '#fffbeb'); // bg-amber-50
            }
        },
        drawCallback: function(settings) {
            // Update the badge count
            const info = this.api().page.info();
            $('#totalBadge').text(info.recordsTotal + ' total');
        },
        order: [[2, 'asc']],
        pageLength: 10,
        dom: '<"dt-controls"lf>t<"dt-footer"ip>',
    });

// ── Modal Add Product ──────────────────────────────
function openAddProductModal() {
    const modal = document.getElementById('modalAddProduct');
    const panel = document.getElementById('modalPanel');
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    // Animate in
    panel.style.opacity = '0';
    panel.style.transform = 'translate(-50%, -48%)';
    requestAnimationFrame(() => {
        panel.style.transition = 'opacity .22s ease, transform .22s ease';
        panel.style.opacity = '1';
        panel.style.transform = 'translate(-50%, -50%)';
    });
}

function closeAddProductModal() {
    const modal = document.getElementById('modalAddProduct');
    const panel = document.getElementById('modalPanel');
    panel.style.opacity = '0';
    panel.style.transform = 'translate(-50%, -48%)';
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 200);
}

// Close on Escape key — tutup modal yang sedang aktif
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (document.getElementById('modalEditProduct').style.display === 'block') {
            closeEditModal();
        } else {
            closeAddProductModal();
        }
    }
});

// ── Accumulator Tambah Gambar ──
var addFilesAccumulator = new DataTransfer();

function syncAddPreview() {
    const wrap = document.getElementById('imagePreviewWrap');
    wrap.innerHTML = '';
    const files = addFilesAccumulator.files;
    
    if (files.length > 0) {
        document.getElementById('dropPlaceholder').style.display = 'none';
        wrap.style.display = 'grid';
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = 'position:relative;display:inline-block;';
                div.innerHTML = `
                    <img src="${e.target.result}" style="width:100%;aspect-ratio:1;border-radius:10px;object-fit:cover;border:1px solid #e2e8f0;">
                    <button type="button" onclick="event.stopPropagation(); removeAddImage(${index})" style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#ef4444;color:#fff;border:none;border-radius:50%;font-size:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 4px rgba(0,0,0,.1);"><i class="bi bi-x-lg"></i></button>
                `;
                wrap.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        document.getElementById('dropPlaceholder').style.display = 'block';
        wrap.style.display = 'none';
    }
}

function removeAddImage(index) {
    const dt = new DataTransfer();
    const files = addFilesAccumulator.files;
    for(let i=0; i<files.length; i++) {
        if (i !== index) dt.items.add(files[i]);
    }
    addFilesAccumulator = dt;
    document.getElementById('gambarInput').files = addFilesAccumulator.files;
    syncAddPreview();
}

function handleGambarInput(input) {
    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(file => {
            addFilesAccumulator.items.add(file);
        });
        input.files = addFilesAccumulator.files;
        syncAddPreview();
    }
}

function handleDrop(event) {
    event.preventDefault();
    document.getElementById('dropZone').style.borderColor = '#e2e8f0';
    Array.from(event.dataTransfer.files).forEach(file => {
        if (file.type.startsWith('image/')) addFilesAccumulator.items.add(file);
    });
    document.getElementById('gambarInput').files = addFilesAccumulator.files;
    syncAddPreview();
}

// Ukuran rows
var sizeIndexModal = 0;
function addSizeRowModal() {
    const container = document.getElementById('sizesContainerModal');
    const row = document.createElement('div');
    row.style.cssText = 'display:flex;gap:10px;align-items:center;';
    row.className = 'size-row-modal';
    const idx = sizeIndexModal++;
    row.innerHTML = `
        <input type="text" name="sizes[${idx}][size]"
               placeholder="Ukuran (S, M, L...)"
               style="flex:1;padding:10px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;font-weight:500;outline:none;"
               onfocus="this.style.borderColor='#93c5fd';" onblur="this.style.borderColor='#e2e8f0';" required>
        <input type="number" name="sizes[${idx}][stock]"
               placeholder="Stok" min="0"
               style="width:110px;padding:10px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;font-weight:500;outline:none;"
               onfocus="this.style.borderColor='#93c5fd';" onblur="this.style.borderColor='#e2e8f0';" required>
        <button type="button" onclick="this.closest('.size-row-modal').remove()"
                style="width:38px;height:38px;flex-shrink:0;background:#fff;border:1px solid #e2e8f0;border-radius:10px;
                       display:inline-flex;align-items:center;justify-content:center;cursor:pointer;color:#94a3b8;transition:all .15s;"
                onmouseover="this.style.background='#fef2f2';this.style.color='#dc2626';this.style.borderColor='#fca5a5';"
                onmouseout="this.style.background='#fff';this.style.color='#94a3b8';this.style.borderColor='#e2e8f0';">
            <i class="bi bi-trash3" style="pointer-events:none;"></i>
        </button>`;
    container.appendChild(row);
}


// ── AutoNumeric config ─────────────────────────────
var anOptions = {
    digitGroupSeparator: '.',
    decimalCharacter: ',',
    decimalPlaces: 0,
    currencySymbol: '',
    minimumValue: '0',
    unformatOnSubmit: true,   // kirim angka murni saat form di-submit
};

// Instance AutoNumeric untuk field tambah produk
var anAddHarga      = null;
var anAddHargaModal = null;

// Instance AutoNumeric untuk field edit produk
var anEditHarga      = null;
var anEditHargaModal = null;

// ── Modal Edit Produk ──────────────────────────────
var editDataBaseUrl = '<?php echo e(url('admin/products')); ?>';

function openEditModal(productId) {
    const modal   = document.getElementById('modalEditProduct');
    const panel   = document.getElementById('modalEditPanel');
    const loader  = document.getElementById('editModalLoader');
    const body    = document.getElementById('editModalBody');

    // Reset
    loader.style.display = 'block';
    body.style.display   = 'none';
    resetEditForm();

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    panel.style.opacity = '0';
    panel.style.transform = 'translate(-50%, -48%)';
    requestAnimationFrame(() => {
        panel.style.transition = 'opacity .22s ease, transform .22s ease';
        panel.style.opacity    = '1';
        panel.style.transform  = 'translate(-50%, -50%)';
    });

    // Fetch data produk
    fetch(`${editDataBaseUrl}/${productId}/edit-data`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        // Isi form
        document.getElementById('formEditProduct').action = data.update_url;
        document.getElementById('edit_nama_produk').value = data.nama_produk;
        document.getElementById('edit_category_id').value = data.category_id;
        document.getElementById('edit_stok').value        = data.stok;

        // Harga dengan AutoNumeric
        if (anEditHarga) {
            anEditHarga.set(data.harga);
        } else {
            document.getElementById('edit_harga_display').value = data.harga;
        }
        if (anEditHargaModal) {
            anEditHargaModal.set(data.harga_modal);
        } else {
            document.getElementById('edit_harga_modal_display').value = data.harga_modal;
        }

        // Gambar
        const imgWrap = document.getElementById('editCurrentImg');
        imgWrap.innerHTML = '';
        if (data.images && data.images.length > 0) {
            data.images.forEach(img => {
                const imgDiv = document.createElement('div');
                imgDiv.style.cssText = 'position:relative;display:inline-block;';
                imgDiv.innerHTML = `
                    <img src="${img.url}" style="width:64px;height:64px;border-radius:10px;object-fit:cover;border:1px solid #e2e8f0;">
                    <button type="button" onclick="deleteImage(${data.id}, ${img.id}, this)" style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#ef4444;color:#fff;border:none;border-radius:50%;font-size:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 4px rgba(0,0,0,.1);"><i class="bi bi-x-lg"></i></button>
                `;
                imgWrap.appendChild(imgDiv);
            });
            imgWrap.style.display = 'flex';
        } else {
            imgWrap.style.display = 'none';
        }

        // Ukuran
        const container = document.getElementById('sizesContainerEdit');
        container.innerHTML = '';
        sizeIndexEdit = 0;
        if (data.sizes && data.sizes.length > 0) {
            data.sizes.forEach(s => addSizeRowEdit(s.size, s.stock));
        }

        loader.style.display = 'none';
        body.style.display   = 'block';
    })
    .catch(err => {
        console.error('[Edit Modal] Fetch error:', err);
        loader.innerHTML = '<p style="color:#dc2626;font-weight:600;">Gagal memuat data. Coba lagi.</p>';
    });
}

function closeEditModal() {
    const modal = document.getElementById('modalEditProduct');
    const panel = document.getElementById('modalEditPanel');
    panel.style.opacity   = '0';
    panel.style.transform = 'translate(-50%, -48%)';
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 200);
}

function resetEditForm() {
    if (anEditHarga)      anEditHarga.clear();
    if (anEditHargaModal) anEditHargaModal.clear();
    document.getElementById('edit_nama_produk').value = '';
    document.getElementById('edit_category_id').value = '';
    document.getElementById('edit_stok').value        = '';
    document.getElementById('editGambarInput').value  = '';
    document.getElementById('editDropPlaceholder').style.display  = 'block';
    document.getElementById('editImagePreviewWrap').style.display = 'none';
    document.getElementById('sizesContainerEdit').innerHTML = '';
    editFilesAccumulator = new DataTransfer();
    syncEditPreview();
    sizeIndexEdit = 0;
}

// ── Accumulator Edit Gambar Baru ──
var editFilesAccumulator = new DataTransfer();

function syncEditPreview() {
    const wrap = document.getElementById('editImagePreviewWrap');
    wrap.innerHTML = '';
    const files = editFilesAccumulator.files;
    
    if (files.length > 0) {
        document.getElementById('editDropPlaceholder').style.display = 'none';
        wrap.style.display = 'grid';
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = 'position:relative;display:inline-block;';
                div.innerHTML = `
                    <img src="${e.target.result}" style="width:100%;aspect-ratio:1;border-radius:10px;object-fit:cover;border:1px solid #e2e8f0;">
                    <button type="button" onclick="event.stopPropagation(); removeEditImage(${index})" style="position:absolute;top:-6px;right:-6px;width:20px;height:20px;background:#ef4444;color:#fff;border:none;border-radius:50%;font-size:10px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 4px rgba(0,0,0,.1);"><i class="bi bi-x-lg"></i></button>
                `;
                wrap.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    } else {
        document.getElementById('editDropPlaceholder').style.display = 'block';
        wrap.style.display = 'none';
    }
}

function removeEditImage(index) {
    const dt = new DataTransfer();
    const files = editFilesAccumulator.files;
    for(let i=0; i<files.length; i++) {
        if (i !== index) dt.items.add(files[i]);
    }
    editFilesAccumulator = dt;
    document.getElementById('editGambarInput').files = editFilesAccumulator.files;
    syncEditPreview();
}

function handleEditGambarInput(input) {
    if (input.files && input.files.length > 0) {
        Array.from(input.files).forEach(file => {
            editFilesAccumulator.items.add(file);
        });
        input.files = editFilesAccumulator.files;
        syncEditPreview();
    }
}

function handleEditDrop(event) {
    event.preventDefault();
    document.getElementById('editDropPlaceholder').parentElement.style.borderColor = '#e2e8f0';
    Array.from(event.dataTransfer.files).forEach(file => {
        if (file.type.startsWith('image/')) editFilesAccumulator.items.add(file);
    });
    document.getElementById('editGambarInput').files = editFilesAccumulator.files;
    syncEditPreview();
}

function deleteImage(productId, imageId, btn) {
    if (!confirm('Hapus gambar ini?')) return;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
    btn.disabled = true;
    fetch(`${editDataBaseUrl}/${productId}/images/${imageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            btn.parentElement.remove();
        } else {
            alert('Gagal menghapus gambar');
            btn.innerHTML = '<i class="bi bi-x-lg"></i>';
            btn.disabled = false;
        }
    }).catch(err => {
        alert('Terjadi kesalahan jaringan');
        btn.innerHTML = '<i class="bi bi-x-lg"></i>';
        btn.disabled = false;
    });
}

// Ukuran rows (edit)
var sizeIndexEdit = 0;
function addSizeRowEdit(sizeVal = '', stockVal = '') {
    const container = document.getElementById('sizesContainerEdit');
    const row = document.createElement('div');
    row.style.cssText = 'display:flex;gap:10px;align-items:center;';
    row.className = 'size-row-edit';
    const idx = sizeIndexEdit++;
    row.innerHTML = `
        <input type="text" name="sizes[${idx}][size]" value="${escAttr(sizeVal)}"
               placeholder="Ukuran (S, M, L...)"
               style="flex:1;padding:10px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;font-weight:500;outline:none;"
               onfocus="this.style.borderColor='#93c5fd';" onblur="this.style.borderColor='#e2e8f0';">
        <input type="number" name="sizes[${idx}][stock]" value="${parseInt(stockVal)||0}"
               placeholder="Stok" min="0"
               style="width:110px;padding:10px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;font-size:13px;color:#334155;font-weight:500;outline:none;"
               onfocus="this.style.borderColor='#93c5fd';" onblur="this.style.borderColor='#e2e8f0';">
        <button type="button" onclick="this.closest('.size-row-edit').remove()"
                style="width:38px;height:38px;flex-shrink:0;background:#fff;border:1px solid #e2e8f0;border-radius:10px;
                       display:inline-flex;align-items:center;justify-content:center;cursor:pointer;color:#94a3b8;transition:all .15s;"
                onmouseover="this.style.background='#fef2f2';this.style.color='#dc2626';this.style.borderColor='#fca5a5';"
                onmouseout="this.style.background='#fff';this.style.color='#94a3b8';this.style.borderColor='#e2e8f0';">
            <i class="bi bi-trash3" style="pointer-events:none;"></i>
        </button>`;
    container.appendChild(row);
}

function escAttr(str) {
    return String(str).replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}

// Init AutoNumeric
    // ── Field Tambah Produk ──
    var addHargaEl      = document.getElementById('add_harga_display');
    var addHargaModalEl = document.getElementById('add_harga_modal_display');

    if (addHargaEl) {
        anAddHarga = new AutoNumeric(addHargaEl, anOptions);
        // Pasang hidden field sync via event
        addHargaEl.addEventListener('autoNumeric:formatted', function() {
            document.getElementById('add_harga_raw').value = anAddHarga.getNumber();
        });
        addHargaEl.addEventListener('input', function() {
            document.getElementById('add_harga_raw').value = anAddHarga.getNumber() || 0;
        });
    }
    if (addHargaModalEl) {
        anAddHargaModal = new AutoNumeric(addHargaModalEl, anOptions);
        addHargaModalEl.addEventListener('input', function() {
            document.getElementById('add_harga_modal_raw').value = anAddHargaModal.getNumber() || 0;
        });
    }

    // ── Field Edit Produk ──
    var editHargaEl      = document.getElementById('edit_harga_display');
    var editHargaModalEl = document.getElementById('edit_harga_modal_display');

    if (editHargaEl) {
        anEditHarga = new AutoNumeric(editHargaEl, anOptions);
        editHargaEl.addEventListener('input', function() {
            document.getElementById('edit_harga_raw').value = anEditHarga.getNumber() || 0;
        });
    }
    if (editHargaModalEl) {
        anEditHargaModal = new AutoNumeric(editHargaModalEl, anOptions);
        editHargaModalEl.addEventListener('input', function() {
            document.getElementById('edit_harga_modal_raw').value = anEditHargaModal.getNumber() || 0;
        });
    }

    // Sinkron hidden field sebelum submit tambah produk
    document.getElementById('formAddProduct').addEventListener('submit', function() {
        if (anAddHarga)      document.getElementById('add_harga_raw').value      = anAddHarga.getNumber() || 0;
        if (anAddHargaModal) document.getElementById('add_harga_modal_raw').value = anAddHargaModal.getNumber() || 0;
    });

    // Sinkron hidden field sebelum submit edit produk
    document.getElementById('formEditProduct').addEventListener('submit', function() {
        if (anEditHarga)      document.getElementById('edit_harga_raw').value      = anEditHarga.getNumber() || 0;
        if (anEditHargaModal) document.getElementById('edit_harga_modal_raw').value = anEditHargaModal.getNumber() || 0;
    });

// Auto-buka modal jika ada error validasi dari server
<?php if($errors->any()): ?>
    openAddProductModal();
<?php endif; ?>

// Keyframe spin untuk loader
var styleEl = document.createElement('style');
styleEl.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
document.head.appendChild(styleEl);

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\ecommerce-alkhomart\resources\views/admin/products/index.blade.php ENDPATH**/ ?>