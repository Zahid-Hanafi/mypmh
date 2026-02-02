<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | MyPMH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pmh-purple': '#7c2a7c',
                        'pmh-purple-dark': '#5a1f5a',
                        'pmh-yellow': '#edd134'
                    },
                    fontFamily: { 'sans': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        :root { --primary-purple: #7c2a7c; --secondary-yellow: #edd134; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        @keyframes pulse-glow { 0%, 100% { box-shadow: 0 0 20px rgba(237, 209, 52, 0.3); } 50% { box-shadow: 0 0 40px rgba(237, 209, 52, 0.6); } }
        .float-animation { animation: float 6s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 3s ease-in-out infinite; }
        .glass { background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); }
    </style>
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-gray-900 via-pmh-purple-dark to-gray-900">
    
    <!-- Decorative Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-pmh-purple rounded-full opacity-20 blur-3xl float-animation"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pmh-yellow rounded-full opacity-10 blur-3xl float-animation" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-pmh-purple rounded-full opacity-10 blur-3xl"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-0">
            
            <!-- Left: Branding -->
            <div class="hidden lg:flex flex-col justify-center items-center text-white p-12">
                <div class="text-center">
                    <!-- Animated Logo -->
                    <div class="w-28 h-28 bg-gradient-to-br from-pmh-yellow to-yellow-400 rounded-3xl flex items-center justify-center mb-8 mx-auto shadow-2xl pulse-glow transform hover:scale-105 transition-transform">
                        <span class="text-pmh-purple text-4xl font-extrabold">PMH</span>
                    </div>
                    <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">MyPMH</h1>
                    <p class="text-purple-200 text-xl mb-2">Persatuan Mahasiswa Hadhari</p>
                    <p class="text-pmh-yellow font-medium">UiTM Kampus Puncak Perdana</p>
                    
                    <!-- Features -->
                    <div class="mt-12 space-y-4 text-left max-w-xs mx-auto">
                        <div class="glass rounded-xl p-4 flex items-center gap-4 transform hover:scale-105 transition-all">
                            <div class="w-12 h-12 bg-pmh-yellow/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-calendar-check text-pmh-yellow text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Programs & Events</p>
                                <p class="text-sm text-purple-200">Join exclusive activities</p>
                            </div>
                        </div>
                        <div class="glass rounded-xl p-4 flex items-center gap-4 transform hover:scale-105 transition-all">
                            <div class="w-12 h-12 bg-pmh-yellow/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-shopping-bag text-pmh-yellow text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Merchandise</p>
                                <p class="text-sm text-purple-200">Shop official gear</p>
                            </div>
                        </div>
                        <div class="glass rounded-xl p-4 flex items-center gap-4 transform hover:scale-105 transition-all">
                            <div class="w-12 h-12 bg-pmh-yellow/20 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-pmh-yellow text-xl"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-white">Community</p>
                                <p class="text-sm text-purple-200">Connect with members</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Login Form -->
            <div class="flex items-center justify-center">
                <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 lg:p-10">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                            <span class="text-pmh-yellow text-xl font-bold">PMH</span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">MyPMH</h1>
                    </div>

                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                        <p class="text-gray-500 mt-2">Sign in to continue to your dashboard</p>
                    </div>

                    <?= $this->Flash->render() ?>
                    
                    <?= $this->Form->create(null, ['class' => 'space-y-6']) ?>
                        <?php $this->Form->unlockField('role'); ?>
                        
                        <!-- Role Selection -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Sign in as</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="role" value="student" checked class="peer hidden">
                                    <div class="border-2 border-gray-200 rounded-2xl p-5 text-center transition-all peer-checked:border-pmh-purple peer-checked:bg-purple-50 group-hover:border-purple-300">
                                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3 peer-checked:bg-pmh-purple transition-all group-hover:bg-purple-100">
                                            <i class="fas fa-user-graduate text-2xl text-gray-400 peer-checked:text-white"></i>
                                        </div>
                                        <p class="font-semibold text-gray-700">Student</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer group">
                                    <input type="radio" name="role" value="admin" class="peer hidden">
                                    <div class="border-2 border-gray-200 rounded-2xl p-5 text-center transition-all peer-checked:border-pmh-purple peer-checked:bg-purple-50 group-hover:border-purple-300">
                                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3 peer-checked:bg-pmh-purple transition-all group-hover:bg-purple-100">
                                            <i class="fas fa-user-shield text-2xl text-gray-400 peer-checked:text-white"></i>
                                        </div>
                                        <p class="font-semibold text-gray-700">Admin</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Matric Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Matric Number</label>
                            <div class="relative">
                                <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <?= $this->Form->control('matric_no', [
                                    'label' => false,
                                    'placeholder' => '2025XXXXXX',
                                    'class' => 'w-full pl-12 pr-4 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none text-lg'
                                ]) ?>
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <?= $this->Form->control('password', [
                                    'label' => false,
                                    'type' => 'password',
                                    'id' => 'password',
                                    'placeholder' => '••••••••',
                                    'class' => 'w-full pl-12 pr-12 py-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none text-lg'
                                ]) ?>
                                <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pmh-purple transition-colors">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-end mt-2">
                             <a href="<?= $this->Url->build(['action' => 'forgotPassword']) ?>" class="text-sm font-medium text-pmh-purple hover:text-pmh-purple-dark hover:underline">
                                Forgot Password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-300 transition-all transform hover:scale-[1.02] text-lg">
                            Sign In
                        </button>
                    <?= $this->Form->end() ?>

                    <!-- Register Link -->
                    <div class="mt-8 text-center">
                        <p class="text-gray-500">
                            Don't have an account?
                            <a href="<?= $this->Url->build(['action' => 'register']) ?>" class="text-pmh-purple font-semibold hover:underline ml-1">
                                Create Account
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="relative text-center py-6 text-purple-300 text-sm">
        &copy; 2026 Persatuan Mahasiswa Hadhari. All rights reserved.
    </div>

    <script>
        function togglePassword() {
            const field = document.getElementById('password');
            const icon = document.getElementById('password-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>