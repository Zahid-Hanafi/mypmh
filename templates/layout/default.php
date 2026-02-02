<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyPMH: <?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pmh-purple': '#7c2a7c',
                        'pmh-purple-dark': '#5a1f5a',
                        'pmh-purple-light': '#9a3d9a',
                        'pmh-yellow': '#edd134',
                        'pmh-yellow-light': '#f5e066'
                    },
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <style>
        :root {
            --primary-purple: #7c2a7c;
            --secondary-yellow: #edd134;
            --black: #000000;
            --white: #ffffff;
        }
        .sidebar { 
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            z-index: 1000; 
        }
        .sidebar.closed { 
            transform: translateX(-100%); 
        }
        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
        html { 
            scroll-behavior: smooth; 
        }
        .nav-link {
            position: relative;
            overflow: hidden;
        }
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: #edd134;
            transform: scaleY(0);
            transition: transform 0.2s ease;
        }
        .nav-link:hover::before, .nav-link.active::before {
            transform: scaleY(1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out;
        }
    </style>
</head>
<body class="font-sans bg-gradient-to-br from-gray-50 via-white to-gray-100 flex flex-col min-h-screen">

    <?php 
        $action = $this->request->getParam('action');
        $isAuthPage = in_array($action, ['login', 'register']);
        $identity = $this->request->getAttribute('identity');
        $isAdmin = $identity && $identity->get('role') === 'admin';
        $userName = $identity ? $identity->get('full_name') : 'User';
    ?>

    <?php if (!$isAuthPage): ?>
    <!-- Header -->
    <header class="bg-white/80 backdrop-blur-lg border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Left: Menu + Logo -->
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-all text-gray-600 lg:hidden">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-xl flex items-center justify-center shadow-lg shadow-purple-200 group-hover:shadow-purple-300 transition-all">
                            <span class="text-pmh-yellow font-bold text-sm">PMH</span>
                        </div>
                        <div class="hidden sm:block">
                            <span class="text-xl font-bold text-gray-900">MyPMH</span>
                            <p class="text-[10px] text-gray-400 -mt-1">Student Portal</p>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <nav class="hidden lg:flex items-center gap-1">
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-pmh-purple hover:bg-purple-50 rounded-lg transition-all">Dashboard</a>
                    <a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-pmh-purple hover:bg-purple-50 rounded-lg transition-all">Programs</a>
                    <?php if ($isAdmin): ?>
                    <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'totalorder']) ?>" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-pmh-purple hover:bg-purple-50 rounded-lg transition-all">Orders</a>
                    <?php else: ?>
                    <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-pmh-purple hover:bg-purple-50 rounded-lg transition-all">Merchandise</a>
                    <?php endif; ?>
                </nav>
                
                <!-- Right: User Menu -->
                <div class="flex items-center gap-3">
                    <div id="real-time" class="hidden md:flex items-center gap-2 text-xs text-gray-400 bg-gray-50 px-3 py-2 rounded-lg">
                        <i class="fas fa-clock"></i>
                        <span></span>
                    </div>

                    <!-- User Dropdown -->
                    <div class="relative" id="userDropdown">
                        <button onclick="toggleUserMenu()" class="flex items-center gap-3 pl-3 pr-4 py-2 rounded-xl hover:bg-gray-50 transition-all">
                            <div class="w-9 h-9 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-full flex items-center justify-center ring-2 ring-purple-100">
                                <span class="text-white text-sm font-bold"><?= strtoupper(substr($userName, 0, 1)) ?></span>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-700"><?= h($userName) ?></p>
                                <p class="text-[10px] text-gray-400"><?= $isAdmin ? 'Administrator' : 'Student' ?></p>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 text-xs hidden sm:block"></i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="font-semibold text-gray-900"><?= h($userName) ?></p>
                                <p class="text-sm text-gray-500"><?= $isAdmin ? 'Admin' : 'Student' ?></p>
                            </div>
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-user-circle w-5"></i> My Profile
                            </a>
                            <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chart-line w-5"></i> Dashboard
                            </a>
                            <?php if (!$isAdmin): ?>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <p class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">Information</p>
                                <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-info-circle w-5"></i> About Us
                                </a>
                                <a href="<?= $this->Url->build(['controller' => 'Applications', 'action' => 'joinus']) ?>" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-user-plus w-5"></i> Join Us
                                </a>
                                <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 transition-colors">
                                    <i class="fas fa-envelope w-5"></i> Contact Us
                                </a>
                            </div>
                            <?php endif; ?>
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fas fa-sign-out-alt w-5"></i> Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Sidebar Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="sidebar-overlay fixed inset-0 bg-black/50 z-40 opacity-0 pointer-events-none lg:hidden"></div>

    <!-- Mobile Sidebar -->
    <nav id="sidebar" class="sidebar closed fixed left-0 top-0 h-full w-80 bg-white shadow-2xl flex flex-col lg:hidden">
        <!-- Sidebar Header -->
        <div class="p-6 border-b border-gray-100 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-pmh-yellow rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-pmh-purple font-bold">PMH</span>
                    </div>
                    <div>
                        <p class="font-bold text-white text-lg">MyPMH</p>
                        <p class="text-xs text-purple-200"><?= $isAdmin ? 'Administrator' : 'Student Portal' ?></p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 text-white hover:bg-white/20 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <!-- User Info -->
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-full flex items-center justify-center">
                    <span class="text-white font-bold"><?= strtoupper(substr($userName, 0, 1)) ?></span>
                </div>
                <div>
                    <p class="font-semibold text-gray-900"><?= h($userName) ?></p>
                    <p class="text-sm text-gray-500"><?= $isAdmin ? 'Admin' : 'Student' ?></p>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <div class="flex-grow overflow-y-auto p-4">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Menu</p>
            <ul class="space-y-1">
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                        <i class="fas fa-chart-line w-5"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                        <i class="fas fa-calendar-alt w-5"></i> All Programs
                    </a>
                </li>
                
                <?php if ($isAdmin): ?>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'totalorder']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                            <i class="fas fa-clipboard-list w-5"></i> Total Orders
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                            <i class="fas fa-shopping-bag w-5"></i> Merchandise
                        </a>
                    </li>
                    
                    <li class="pt-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Information</p>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                            <i class="fas fa-info-circle w-5"></i> About Us
                        </a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Applications', 'action' => 'joinus']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                            <i class="fas fa-user-plus w-5"></i> Join Us
                        </a>
                    </li>
                    <li>
                        <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                            <i class="fas fa-envelope w-5"></i> Contact Us
                        </a>
                    </li>
                <?php endif; ?>
                
                <li class="pt-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3 px-3">Account</p>
                </li>
                <li>
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="nav-link flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-purple-50 hover:text-pmh-purple rounded-xl transition-all font-medium">
                        <i class="fas fa-user-circle w-5"></i> My Profile
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout -->
        <div class="p-4 border-t border-gray-100">
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="flex items-center justify-center gap-3 px-4 py-3 bg-red-50 text-red-600 rounded-xl font-semibold hover:bg-red-100 transition-all">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="flex-grow <?= !$isAuthPage ? 'py-6 lg:py-10' : '' ?> animate-fade-in">
        <?php if (!$isAuthPage): ?>
        <div class="container mx-auto px-4 lg:px-8">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <?php else: ?>
            <?= $this->fetch('content') ?>
        <?php endif; ?>
    </main>

    <?php if (!$isAuthPage): ?>
    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-auto">
        <div class="container mx-auto px-4 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-pmh-yellow to-yellow-400 rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-pmh-purple font-bold">PMH</span>
                        </div>
                        <div>
                            <span class="text-xl font-bold">MyPMH</span>
                            <p class="text-xs text-gray-400">Student Portal</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm leading-relaxed mb-4">
                        Persatuan Mahasiswa Hadhari - Empowering UiTM students through excellence and integrity.
                    </p>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-pmh-purple transition-all hover:scale-110">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-pmh-purple transition-all hover:scale-110">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center hover:bg-pmh-purple transition-all hover:scale-110">
                            <i class="fab fa-tiktok"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h6 class="font-semibold mb-4 text-pmh-yellow">Quick Links</h6>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> Dashboard</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Programs', 'action' => 'allprogram']) ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> All Programs</a></li>
                        <?php if (!$isAdmin): ?>
                        <li><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'listmerchandise']) ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> Merchandise</a></li>
                        <?php endif; ?>
                        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> My Profile</a></li>
                    </ul>
                </div>

                <!-- Information -->
                <div>
                    <h6 class="font-semibold mb-4 text-pmh-yellow">Information</h6>
                    <ul class="space-y-3 text-sm">
                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'aboutus']) ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> About Us</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'contactus']) ?>" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-[8px] text-pmh-yellow"></i> Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h6 class="font-semibold mb-4 text-pmh-yellow">Contact Us</h6>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-pmh-yellow mt-1"></i>
                            <span>Level 1, Kolej Jasmine, UiTM Puncak Perdana</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-pmh-yellow"></i>
                            <span>+60 12-345 6789</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-pmh-yellow"></i>
                            <span>hello@mypmh.uitm.edu.my</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-10 pt-8 text-center">
                <p class="text-gray-500 text-sm">
                    &copy; 2026 Persatuan Mahasiswa Hadhari (MyPMH). All rights reserved.
                </p>
            </div>
        </div>
    </footer>
    <?php endif; ?>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('closed');
            
            if (sidebar.classList.contains('closed')) {
                overlay.classList.add('opacity-0', 'pointer-events-none');
            } else {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
            }
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Close user menu when clicking outside
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const menu = document.getElementById('userMenu');
            if (dropdown && menu && !dropdown.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        function updateTime() {
            const timeEl = document.querySelector('#real-time span');
            if (timeEl) {
                const now = new Date();
                timeEl.innerText = now.toLocaleString('en-MY', { 
                    dateStyle: 'medium', 
                    timeStyle: 'short' 
                });
            }
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>