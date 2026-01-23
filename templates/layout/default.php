<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyPMH: <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pmh-purple': '#7c2a7c',
                        'pmh-yellow': '#edd134',
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary-purple: #7c2a7c;
            --secondary-yellow: #edd134;
        }
        .sidebar { transition: transform 0.3s ease-in-out; z-index: 1000; }
        .sidebar.closed { transform: translateX(-100%); }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <?php 
        $action = $this->request->getParam('action');
        $isAuthPage = in_array($action, ['login', 'register']);
        
        // Capture user identity for role checking
        $identity = $this->request->getAttribute('identity');
        $isAdmin = $identity && $identity->get('role') === 'admin';
    ?>

    <?php if (!$isAuthPage): ?>
    <header class="bg-pmh-purple text-white p-4 shadow-lg flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-4">
            <button onclick="toggleSidebar()" class="text-2xl hover:text-pmh-yellow transition-colors">
                <i class="fas fa-bars"></i>
            </button>
            <div class="flex items-center gap-2">
                <span class="text-xl font-bold tracking-wider">MyPMH</span>
                <div class="w-8 h-8 bg-pmh-yellow rounded-full flex items-center justify-center text-pmh-purple font-bold">P</div>
            </div>
        </div>
        <div id="real-time" class="hidden md:block text-sm font-mono bg-purple-900/50 px-3 py-1 rounded-lg"></div>
    </header>

    <nav id="sidebar" class="sidebar closed fixed left-0 top-0 h-full w-64 bg-white shadow-2xl p-6 flex flex-col border-r border-gray-100">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-pmh-purple font-bold text-xl uppercase tracking-tight">Navigation</h2>
            <button onclick="toggleSidebar()" class="text-gray-400 hover:text-red-500 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <ul class="space-y-3 flex-grow overflow-y-auto">
            <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-chart-line w-6"></i> Dashboard</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-calendar-alt w-6"></i> All Programs</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-shopping-bag w-6"></i> Merchandise</a></li>
            
            <?php if ($isAdmin): ?>
                <li><a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'totalorder']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-clipboard-list w-6"></i> Total Orders</a></li>
            <?php endif; ?>

            <li><hr class="my-2 border-gray-100"></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-info-circle w-6"></i> About Us</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Applications', 'action' => 'joinus']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-user-plus w-6"></i> Join Us</a></li>
            <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="flex items-center gap-3 p-3 text-gray-700 hover:bg-pmh-purple hover:text-white rounded-xl transition-all font-medium"><i class="fas fa-envelope w-6"></i> Contact Us</a></li>
        </ul>

        <div class="border-t pt-4">
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="flex items-center gap-3 text-red-600 hover:bg-red-50 p-3 rounded-xl transition-all font-bold">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
    <?php endif; ?>

    <main class="flex-grow <?= !$isAuthPage ? 'container mx-auto px-4 py-8' : '' ?>">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <?php if (!$isAuthPage): ?>
    <footer class="bg-black text-white pt-16 pb-8 mt-auto border-t-4 border-[#7c2a7c]">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="space-y-6">
                    <h6 class="text-white font-bold uppercase tracking-widest mb-6 text-sm border-b border-gray-800 pb-2">About Us</h6>
                    <p class="text-gray-400 text-sm leading-relaxed text-justify">
                        Persatuan Mahasiswa Hadhari (PMH) is committed to empowering UiTM students through excellence, integrity, and spiritual heritage at the Puncak Perdana campus.
                    </p>
                    <div class="flex gap-5">
                        <a href="#" class="text-gray-400 hover:text-pmh-yellow transition-colors"><i class="fab fa-facebook-f fa-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pmh-yellow transition-colors"><i class="fab fa-instagram fa-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-pmh-yellow transition-colors"><i class="fab fa-tiktok fa-xl"></i></a>
                    </div>
                </div>

                <div>
                    <h6 class="text-white font-bold uppercase tracking-widest mb-6 text-sm border-b border-gray-800 pb-2">Quick Navigation</h6>
                    <ul class="space-y-3">
                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Dashboard</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> All Programs</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Merchandise Store</a></li>
                        
                        <?php if ($isAdmin): ?>
                            <li><a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'totalorder']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Total Orders</a></li>
                        <?php endif; ?>

                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> About Us</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Applications', 'action' => 'joinus']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Join Us</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Contact Us</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="text-white font-bold uppercase tracking-widest mb-6 text-sm border-b border-gray-800 pb-2">Support & Policy</h6>
                    <ul class="space-y-3">
                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Contact Support</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white text-sm transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[10px] text-pmh-yellow"></i> Terms of Service</a></li>
                    </ul>
                </div>

                <div>
                    <h6 class="text-white font-bold uppercase tracking-widest mb-6 text-sm border-b border-gray-800 pb-2">Contact Info</h6>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <i class="fas fa-map-marker-alt text-pmh-yellow mt-1"></i>
                            <span class="text-gray-400 text-sm">Level 1, Kolej Jasmine, UiTM Puncak Perdana, Shah Alam.</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <i class="fas fa-phone-alt text-pmh-yellow"></i>
                            <span class="text-gray-400 text-sm">+60 12-345 6789</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <i class="fas fa-envelope text-pmh-yellow"></i>
                            <span class="text-gray-400 text-sm">hello@mypmh.uitm.edu.my</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-900 flex flex-col md:flex-row justify-center items-center gap-4">
                <p class="text-gray-500 text-xs font-medium tracking-wide">
                    &copy; 2026 PERSATUAN MAHASISWA HADHARI (MYPMH). ALL RIGHTS RESERVED.
                </p>
            </div>
        </div>
    </footer>
    <?php endif; ?>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('closed');
        }

        window.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const menuBtn = document.querySelector('header button');
            if (!sidebar.contains(e.target) && !menuBtn.contains(e.target) && !sidebar.classList.contains('closed')) {
                sidebar.classList.add('closed');
            }
        });

        function updateTime() {
            const timeEl = document.getElementById('real-time');
            if (timeEl) {
                const now = new Date();
                timeEl.innerText = now.toLocaleString('en-MY', { 
                    dateStyle: 'medium', 
                    timeStyle: 'medium' 
                });
            }
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>