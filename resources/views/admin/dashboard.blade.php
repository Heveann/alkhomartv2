@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-header-title">
        <div class="page-header-icon"><i class="bi bi-activity"></i></div>
        Dashboard
    </h1>
    <div class="page-header-subtitle">Management Overview</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Card 1 -->
    <div class="card" style="border-left: 0.25rem solid var(--primary);">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: var(--primary);">Inventory (Total Units)</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">{{ $totalProduk }}</div>
                </div>
                <i class="bi bi-box-seam text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
    
    <!-- Card 2 -->
    <div class="card" style="border-left: 0.25rem solid #00ac69;">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: #00ac69;">Sales (Completed)</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">{{ $totalTransaksi }}</div>
                </div>
                <i class="bi bi-cart-check text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
    
    <!-- Card 3 -->
    <div class="card" style="border-left: 0.25rem solid #f4a100;">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: #f4a100;">Revenue (Gross)</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">IDR {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-currency-dollar text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
    
    <!-- Card 4 -->
    <div class="card" style="border-left: 0.25rem solid #00cfd5;">
        <div class="card-body">
            <div class="flex justify-between items-center">
                <div>
                    <div class="text-xs font-bold uppercase mb-1" style="color: #00cfd5;">Net Profit</div>
                    <div class="text-2xl font-bold" style="color: var(--dark);">IDR {{ number_format($totalLaba, 0, ',', '.') }}</div>
                </div>
                <i class="bi bi-graph-up text-3xl opacity-50" style="color: #c5ccd6;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Chart Area -->
<div class="card mb-6 overflow-hidden">
    <div class="card-header border-0 flex justify-between items-center" style="background-color: #6200ea; color: white; padding: 1.5rem;">
        <div>
            <h4 class="m-0 font-bold text-white text-xl">Revenue Breakdown</h4>
            <div class="text-sm" style="color: rgba(255,255,255,0.7);">Online vs Offline (Kasir) Sales</div>
        </div>
    </div>
    <div class="card-body p-0">
        <!-- Chart -->
        <div class="p-6" style="height: 400px;">
            <canvas id="revenueChart" width="100%" height="100%"></canvas>
        </div>
    </div>
    <div class="card-footer bg-white border-t border-slate-100 p-4 text-right">
        <a href="{{ route('admin.laba.index') }}" class="font-bold text-sm uppercase tracking-wider" style="color: #6200ea; text-decoration:none;">Open Report <i class="bi bi-chevron-right ml-1"></i></a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="card h-full">
            <div class="card-header flex justify-between items-center">
                <div><i class="bi bi-list-task mr-2"></i> Recent Transactions</div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead style="background-color: rgba(33, 40, 50, 0.03); border-bottom: 2px solid var(--border-color);">
                            <tr>
                                <th class="p-3 text-xs font-bold uppercase" style="color: var(--dark);">Transaction ID</th>
                                <th class="p-3 text-xs font-bold uppercase" style="color: var(--dark);">Customer</th>
                                <th class="p-3 text-xs font-bold uppercase text-right" style="color: var(--dark);">Amount</th>
                                <th class="p-3 text-xs font-bold uppercase text-center" style="color: var(--dark);">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr style="border-bottom: 1px solid var(--border-color);">
                                    <td class="p-3 text-sm font-medium" style="color: var(--dark);">{{ $order->kode_transaksi }}</td>
                                    <td class="p-3 text-sm">{{ $order->user?->name ?? 'Guest User' }}</td>
                                    <td class="p-3 text-sm font-medium text-right" style="color: var(--primary);">IDR {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td class="p-3 text-center">
                                        @if($order->status == 'selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @elseif($order->status == 'dibatalkan')
                                            <span class="badge badge-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-sm">No recent activities found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1">
        <div class="card h-full">
            <div class="card-header"><i class="bi bi-lightning-charge mr-2"></i> Quick Operations</div>
            <div class="card-body">
                <div class="grid gap-3 mb-4">
                    <a href="{{ route('admin.kasir.index') }}" class="btn btn-primary w-full">
                        <i class="bi bi-calculator-fill"></i> Launch POS Terminal
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light w-full">
                        <i class="bi bi-plus-lg"></i> Register New Inventory
                    </a>
                </div>

                <div class="mt-4 pt-4 border-t" style="border-color: var(--border-color);">
                    <div class="text-xs font-bold uppercase mb-3" style="color: var(--gray-light);">Today's Performance</div>
                    <div class="mb-3">
                        <div class="flex justify-between text-sm mb-1">
                            <span>Daily Goal</span>
                            <span class="font-bold" style="color: var(--dark);">75%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-2">
                            <div class="h-2 rounded-full" style="width: 75%; background-color: var(--primary);"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById("revenueChart");
        if (ctx) {
            var myBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($chartLabels) !!},
                    datasets: [
                        {
                            label: "Offline (Kasir)",
                            backgroundColor: "#b388ff",
                            hoverBackgroundColor: "#9568e4",
                            borderColor: "transparent",
                            maxBarThickness: 40,
                            data: {!! json_encode($chartDataOffline) !!},
                        },
                        {
                            label: "Online",
                            backgroundColor: "#6200ea",
                            hoverBackgroundColor: "#4a00b0",
                            borderColor: "transparent",
                            maxBarThickness: 40,
                            data: {!! json_encode($chartDataOnline) !!},
                        }
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 12,
                                color: '#a1aab2'
                            }
                        },
                        y: {
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                color: '#a1aab2',
                                callback: function(value, index, values) {
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            },
                            grid: {
                                color: "rgba(234, 236, 244, 0.5)",
                                zeroLineColor: "rgba(234, 236, 244, 0.5)",
                                drawBorder: false,
                            }
                        },
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyColor: "#858796",
                            titleMarginBottom: 10,
                            titleColor: '#6e707e',
                            titleFont: { size: 14 },
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                            callbacks: {
                                label: function(context) {
                                    var datasetLabel = context.dataset.label || '';
                                    return datasetLabel + ': Rp ' + context.parsed.y.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                            }
                        }
                    }
                }
            });
        }
</script>
@endpush
