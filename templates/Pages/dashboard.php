<?php
/**
 * MyPMH Dashboard
 * Includes Chart.js and Tailwind CSS
 */
?>
<div class="bg-pmh-yellow text-pmh-purple py-3 font-bold shadow-md mb-10 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] -mt-8">
    <marquee scrollamount="10" class="flex items-center">
        🔥 PROMOTION: New RAVEN Edition T-shirts are now available! Get yours today! | 
        📢 UPCOMING: Hadhari Global Volunteers Program - Registration opens next week! | 
        🛍️ PRE-ORDER: Exclusive MyPMH Tote Bags back in stock!
    </marquee>
</div>

<div class="relative w-full h-64 md:h-96 bg-gray-200 rounded-2xl overflow-hidden mb-8 shadow-lg group">
    <div class="absolute inset-0 transition-opacity duration-1000 opacity-100 bg-pmh-purple flex items-center justify-center text-white p-10">
        <div class="text-center">
            <h2 class="text-4xl font-extrabold mb-4">Upcoming: Hadhari Night 2025</h2>
            <p class="text-xl text-pmh-yellow">Date: 15th February 2025 | Venue: Kolej Jasmine</p>
            <button class="mt-6 px-6 py-2 bg-pmh-yellow text-pmh-purple font-bold rounded-full hover:bg-white transition-colors">Learn More</button>
        </div>
    </div>
    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
        <div class="w-3 h-3 bg-white rounded-full"></div>
        <div class="w-3 h-3 bg-white/50 rounded-full"></div>
        <div class="w-3 h-3 bg-white/50 rounded-full"></div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border-l-8 border-pmh-purple shadow-md hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Total Programs</p>
                <h3 class="text-3xl font-black text-pmh-purple mt-1" id="stat-total-programs">20</h3>
            </div>
            <i class="fas fa-calendar-check text-4xl text-gray-200"></i>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl border-l-8 border-pmh-yellow shadow-md hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Upcoming Events</p>
                <h3 class="text-3xl font-black text-pmh-purple mt-1">4</h3>
            </div>
            <i class="fas fa-clock text-4xl text-gray-200"></i>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl border-l-8 border-black shadow-md hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 uppercase">Total Orders</p>
                <h3 class="text-3xl font-black text-pmh-purple mt-1" id="stat-total-orders">30</h3>
            </div>
            <i class="fas fa-shopping-cart text-4xl text-gray-200"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-md">
        <h4 class="text-lg font-bold text-pmh-purple mb-4 flex items-center gap-2">
            <i class="fas fa-chart-bar"></i> Monthly Program Distribution 2025
        </h4>
        <div class="h-64">
            <canvas id="programChart"></canvas>
        </div>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-md">
        <h4 class="text-lg font-bold text-pmh-purple mb-4 flex items-center gap-2">
            <i class="fas fa-chart-pie"></i> Orders by Product Category
        </h4>
        <div class="h-64 flex justify-center">
            <canvas id="orderChart"></canvas>
        </div>
    </div>
</div>

<div class="bg-pmh-purple rounded-2xl p-8 text-white shadow-lg text-center">
    <h3 class="text-2xl font-bold mb-4">Quick Actions</h3>
    <div class="flex flex-wrap justify-center gap-4">
        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="px-8 py-3 bg-pmh-yellow text-pmh-purple font-bold rounded-xl hover:bg-white transition-all">Shop Merchandise</a>
        <a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="px-8 py-3 bg-white text-pmh-purple font-bold rounded-xl hover:bg-pmh-yellow transition-all">View All Programs</a>
        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="px-8 py-3 border-2 border-white text-white font-bold rounded-xl hover:bg-white hover:text-pmh-purple transition-all">History of PMH</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Program Bar Chart
    const ctxProgram = document.getElementById('programChart').getContext('2d');
    new Chart(ctxProgram, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Total Programs',
                data: [2, 3, 1, 5, 2, 4, 1, 0, 3, 4, 2, 3], // These would eventually come from the database
                backgroundColor: '#7c2a7c',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    // Order Pie Chart
    const ctxOrder = document.getElementById('orderChart').getContext('2d');
    new Chart(ctxOrder, {
        type: 'doughnut',
        data: {
            labels: ['Ivory Tshirt', 'Raven Tshirt', 'Tote Bags', 'Badges'],
            datasets: [{
                data: [15, 20, 10, 5],
                backgroundColor: ['#7c2a7c', '#edd134', '#000000', '#f3f4f6'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>