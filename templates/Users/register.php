<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | MyPMH</title>
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
        .float-animation { animation: float 6s ease-in-out infinite; }
    </style>
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-gray-900 via-pmh-purple-dark to-gray-900">
    
    <!-- Decorative Background -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-pmh-purple rounded-full opacity-20 blur-3xl float-animation"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pmh-yellow rounded-full opacity-10 blur-3xl float-animation" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative min-h-screen flex items-center justify-center p-4 lg:p-8">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-5 gap-8">
            
            <!-- Left: Branding -->
            <div class="hidden lg:flex lg:col-span-2 flex-col justify-center items-center text-white p-8">
                <div class="text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-pmh-yellow to-yellow-400 rounded-3xl flex items-center justify-center mb-6 mx-auto shadow-2xl">
                        <span class="text-pmh-purple text-3xl font-extrabold">PMH</span>
                    </div>
                    <h1 class="text-4xl font-bold mb-3 bg-gradient-to-r from-white to-purple-200 bg-clip-text text-transparent">Join MyPMH</h1>
                    <p class="text-purple-200 text-lg">Become part of our community</p>
                    
                    <div class="mt-10 text-left space-y-3">
                        <div class="flex items-center gap-3 text-purple-200">
                            <i class="fas fa-check-circle text-pmh-yellow"></i>
                            <span>Access exclusive programs</span>
                        </div>
                        <div class="flex items-center gap-3 text-purple-200">
                            <i class="fas fa-check-circle text-pmh-yellow"></i>
                            <span>Shop official merchandise</span>
                        </div>
                        <div class="flex items-center gap-3 text-purple-200">
                            <i class="fas fa-check-circle text-pmh-yellow"></i>
                            <span>Connect with members</span>
                        </div>
                        <div class="flex items-center gap-3 text-purple-200">
                            <i class="fas fa-check-circle text-pmh-yellow"></i>
                            <span>Develop leadership skills</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Registration Form -->
            <div class="lg:col-span-3 flex items-center justify-center">
                <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-pmh-purple to-pmh-purple-dark rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                            <span class="text-pmh-yellow text-lg font-bold">PMH</span>
                        </div>
                    </div>

                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
                        <p class="text-gray-500 mt-1">Fill in your details to get started</p>
                    </div>

                    <?= $this->Flash->render() ?>
                    
                    <?= $this->Form->create($user, ['class' => 'space-y-5', 'id' => 'registerForm']) ?>
                        <!-- Full Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <?= $this->Form->control('full_name', [
                                    'label' => false,
                                    'placeholder' => 'Enter your full name',
                                    'class' => 'w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                                ]) ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Matric No -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Matric No.</label>
                                <div class="relative">
                                    <i class="fas fa-id-card absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <?= $this->Form->control('matric_no', [
                                        'label' => false,
                                        'placeholder' => '2025XXXXXX',
                                        'class' => 'w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                                    ]) ?>
                                </div>
                            </div>
                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Phone No.</label>
                                <div class="relative">
                                    <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <?= $this->Form->control('phone_no', [
                                        'label' => false,
                                        'placeholder' => '01X-XXXXXXX',
                                        'class' => 'w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                                    ]) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <?= $this->Form->control('email', [
                                    'label' => false,
                                    'placeholder' => 'email@student.uitm.edu.my',
                                    'class' => 'w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
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
                                    'class' => 'w-full pl-12 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none'
                                ]) ?>
                                <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pmh-purple">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <div class="mt-2 grid grid-cols-2 gap-1 text-xs">
                                <p class="text-gray-400 flex items-center gap-1" id="req-length"><i class="fas fa-circle text-[5px]"></i> Min. 8 chars</p>
                                <p class="text-gray-400 flex items-center gap-1" id="req-upper"><i class="fas fa-circle text-[5px]"></i> 1 uppercase</p>
                                <p class="text-gray-400 flex items-center gap-1" id="req-number"><i class="fas fa-circle text-[5px]"></i> 1 number</p>
                                <p class="text-gray-400 flex items-center gap-1" id="req-symbol"><i class="fas fa-circle text-[5px]"></i> 1 symbol</p>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
                            <div class="relative">
                                <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="••••••••" required
                                    class="w-full pl-12 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none">
                                <button type="button" onclick="togglePassword('confirm_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-pmh-purple">
                                    <i class="fas fa-eye" id="confirm_password-icon"></i>
                                </button>
                            </div>
                            <p class="text-xs text-red-500 mt-1 hidden" id="password-match-error"><i class="fas fa-exclamation-circle mr-1"></i> Passwords do not match</p>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full py-4 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-300 transition-all transform hover:scale-[1.02]">
                            Create Account
                        </button>
                    <?= $this->Form->end() ?>

                    <div class="mt-6 text-center">
                        <p class="text-gray-500">
                            Already have an account?
                            <a href="<?= $this->Url->build(['action' => 'login']) ?>" class="text-pmh-purple font-semibold hover:underline ml-1">Sign In</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('confirm_password');

        function validatePassword() {
            const password = passwordField.value;
            const checks = {
                'req-length': password.length >= 8,
                'req-upper': /[A-Z]/.test(password),
                'req-number': /[0-9]/.test(password),
                'req-symbol': /[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/.test(password)
            };

            for (const [id, valid] of Object.entries(checks)) {
                const el = document.getElementById(id);
                const icon = el.querySelector('i');
                if (valid) {
                    el.classList.remove('text-gray-400', 'text-red-500');
                    el.classList.add('text-green-600');
                    icon.classList.remove('fa-circle', 'fa-times');
                    icon.classList.add('fa-check');
                } else {
                    el.classList.remove('text-green-600', 'text-gray-400');
                    el.classList.add('text-red-500');
                    icon.classList.remove('fa-circle', 'fa-check');
                    icon.classList.add('fa-times');
                }
            }
            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const errorEl = document.getElementById('password-match-error');
            if (confirmField.value.length > 0 && passwordField.value !== confirmField.value) {
                errorEl.classList.remove('hidden');
                confirmField.classList.add('border-red-500');
            } else {
                errorEl.classList.add('hidden');
                confirmField.classList.remove('border-red-500');
            }
        }

        passwordField.addEventListener('input', validatePassword);
        confirmField.addEventListener('input', checkPasswordMatch);

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (passwordField.value !== confirmField.value) {
                e.preventDefault();
                document.getElementById('password-match-error').classList.remove('hidden');
            }
        });
    </script>
</body>
</html>