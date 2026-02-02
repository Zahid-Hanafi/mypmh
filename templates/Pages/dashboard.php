<?php
/**
 * MyPMH Dashboard - Enhanced UI
 */
$totalPrograms = $totalPrograms ?? 0;
$upcomingPrograms = $upcomingPrograms ?? 0;
$totalOrders = $totalOrders ?? 0;
$monthlyPrograms = $monthlyPrograms ?? [0,0,0,0,0,0,0,0,0,0,0,0];
$categoryLabels = $categoryLabels ?? [];
$categoryData = $categoryData ?? [];
$upcomingProgramsList = $upcomingProgramsList ?? [];
?>

<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="text-gray-500 mt-1">Welcome back! Here's what's happening with MyPMH.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-medium text-gray-700 hover:bg-gray-50 hover:border-gray-300 transition-all">
            <i class="fas fa-calendar-alt text-pmh-purple"></i> 
            <span class="hidden sm:inline">View Programs</span>
        </a>
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white rounded-xl font-medium hover:shadow-lg hover:shadow-purple-200 transition-all">
            <i class="fas fa-shopping-bag"></i> 
            <span class="hidden sm:inline">Shop Now</span>
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
    <!-- Total Programs -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-pmh-purple/20 transition-all relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-pmh-purple/10 to-transparent rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-xl flex items-center justify-center shadow-lg shadow-purple-200">
                    <i class="fas fa-calendar-check text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">All time</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Programs</p>
            <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalPrograms ?></p>
        </div>
    </div>

    <!-- Upcoming -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-pmh-yellow/20 transition-all relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-pmh-yellow/20 to-transparent rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-pmh-yellow to-yellow-400 rounded-xl flex items-center justify-center shadow-lg shadow-yellow-200">
                    <i class="fas fa-clock text-pmh-purple text-lg"></i>
                </div>
                <span class="text-xs font-medium text-pmh-yellow bg-yellow-50 px-2 py-1 rounded-lg">Active</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Upcoming Events</p>
            <p class="text-3xl font-bold text-gray-900 mt-1"><?= $upcomingPrograms ?></p>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="group bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-gray-300 transition-all relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-gray-200/50 to-transparent rounded-full -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-gray-800 to-black rounded-xl flex items-center justify-center shadow-lg shadow-gray-300">
                    <i class="fas fa-shopping-cart text-white text-lg"></i>
                </div>
                <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg">Orders</span>
            </div>
            <p class="text-sm font-medium text-gray-500">Total Orders</p>
            <p class="text-3xl font-bold text-gray-900 mt-1"><?= $totalOrders ?></p>
        </div>
    </div>

    <!-- Profile Card -->
    <div class="group bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-2xl p-6 shadow-sm hover:shadow-xl transition-all relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
        <div class="relative text-white">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-pmh-yellow rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-pmh-purple text-lg"></i>
                </div>
            </div>
            <p class="text-sm font-medium text-purple-200">My Account</p>
            <p class="text-lg font-bold mt-1">View Profile</p>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="absolute inset-0"></a>
        </div>
    </div>
</div>

<!-- Featured Banner -->
<?php if (!empty($upcomingProgramsList)): ?>
<div class="bg-gradient-to-r from-pmh-purple via-pmh-purple-dark to-pmh-purple rounded-2xl p-6 lg:p-10 mb-8 relative overflow-hidden">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 w-64 h-64 bg-pmh-yellow opacity-10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    <div class="absolute right-10 bottom-0 opacity-10">
        <i class="fas fa-calendar-alt text-[150px] text-white"></i>
    </div>
    
    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        <div class="text-white">
            <span class="inline-flex items-center gap-2 bg-pmh-yellow text-pmh-purple text-xs font-bold px-4 py-1.5 rounded-full mb-4">
                <i class="fas fa-star"></i> UPCOMING EVENT
            </span>
            <h2 class="text-2xl lg:text-3xl font-bold mb-3"><?= h($upcomingProgramsList[0]->name) ?></h2>
            <div class="flex flex-wrap gap-4 text-purple-200">
                <span class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-pmh-yellow"></i>
                    <?= $upcomingProgramsList[0]->date->format('d F Y') ?>
                </span>
                <span class="flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-pmh-yellow"></i>
                    <?= h($upcomingProgramsList[0]->venue) ?>
                </span>
            </div>
        </div>
        <a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="inline-flex items-center justify-center gap-2 bg-pmh-yellow text-pmh-purple px-8 py-4 rounded-xl font-bold hover:bg-white transition-all shadow-lg hover:shadow-xl whitespace-nowrap">
            View All Programs <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-gray-900">Monthly Programs</h3>
                <p class="text-sm text-gray-500">2025 Program Distribution</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-bar text-pmh-purple"></i>
            </div>
        </div>
        <div id="programChart" class="h-64"></div>
    </div>

    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="font-bold text-gray-900">Orders by Category</h3>
                <p class="text-sm text-gray-500">Product distribution</p>
            </div>
            <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-chart-pie text-pmh-yellow"></i>
            </div>
        </div>
        <div id="orderChart" class="h-64"></div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
    <h3 class="font-bold text-gray-900 mb-6">Quick Actions</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-pmh-purple hover:bg-purple-50 transition-all">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-pmh-purple group-hover:shadow-lg transition-all">
                <i class="fas fa-shopping-bag text-pmh-purple group-hover:text-white transition-colors"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">Merchandise</p>
                <p class="text-sm text-gray-500">Shop products</p>
            </div>
        </a>

        <a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-pmh-yellow hover:bg-yellow-50 transition-all">
            <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-pmh-yellow group-hover:shadow-lg transition-all">
                <i class="fas fa-calendar-alt text-pmh-yellow group-hover:text-pmh-purple transition-colors"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">Programs</p>
                <p class="text-sm text-gray-500">View events</p>
            </div>
        </a>

        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-pmh-purple hover:bg-purple-50 transition-all">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center group-hover:bg-pmh-purple group-hover:shadow-lg transition-all">
                <i class="fas fa-user-circle text-pmh-purple group-hover:text-white transition-colors"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">My Profile</p>
                <p class="text-sm text-gray-500">Edit details</p>
            </div>
        </a>

        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="group flex items-center gap-4 p-4 rounded-xl border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition-all">
            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center group-hover:bg-gray-900 group-hover:shadow-lg transition-all">
                <i class="fas fa-info-circle text-gray-600 group-hover:text-white transition-colors"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-900">About PMH</p>
                <p class="text-sm text-gray-500">Learn more</p>
            </div>
        </a>
    </div>
</div>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const monthlyProgramData = <?= json_encode($monthlyPrograms) ?>;
    const categoryLabels = <?= json_encode($categoryLabels) ?>;
    const categoryData = <?= json_encode($categoryData) ?>;

    new ApexCharts(document.querySelector("#programChart"), {
        series: [{ name: 'Programs', data: monthlyProgramData }],
        chart: { type: 'bar', height: 250, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
        plotOptions: { bar: { borderRadius: 8, columnWidth: '50%' } },
        colors: ['#7c2a7c'],
        dataLabels: { enabled: false },
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            labels: { style: { colors: '#9ca3af', fontSize: '11px' } },
            axisBorder: { show: false }, axisTicks: { show: false }
        },
        yaxis: { labels: { style: { colors: '#9ca3af' } } },
        grid: { borderColor: '#f3f4f6', strokeDashArray: 4 },
        tooltip: { theme: 'light' }
    }).render();

    new ApexCharts(document.querySelector("#orderChart"), {
        series: categoryData.length > 0 ? categoryData : [1],
        chart: { type: 'donut', height: 250, fontFamily: 'Inter, sans-serif' },
        labels: categoryLabels.length > 0 ? categoryLabels : ['No orders'],
        colors: ['#7c2a7c', '#edd134', '#a855f7', '#ffea60', '#9333ea', '#ffdd00'],
        plotOptions: { pie: { donut: { size: '70%', labels: { show: true, total: { show: true, label: 'Total', fontSize: '12px' } } } } },
        legend: { position: 'bottom', fontSize: '12px' },
        dataLabels: { enabled: false },
        tooltip: { theme: 'light' }
    }).render();
</script>