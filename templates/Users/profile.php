<!-- Header -->
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
    <p class="text-gray-500 mt-1">View and manage your account information</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-br from-pmh-purple to-pmh-purple-dark p-8 text-center relative">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-pmh-yellow rounded-full -translate-y-1/2 translate-x-1/2"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-pmh-yellow rounded-full translate-y-1/2 -translate-x-1/2"></div>
                </div>
                <div class="relative z-10">
                    <div class="w-24 h-24 bg-pmh-yellow rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg ring-4 ring-white/20">
                        <span class="text-pmh-purple text-3xl font-bold"><?= strtoupper(substr($user->full_name ?? 'U', 0, 1)) ?></span>
                    </div>
                    <h2 class="text-xl font-bold text-white"><?= h($user->full_name) ?></h2>
                    <p class="text-purple-200 mt-1"><?= h($user->matric_no) ?></p>
                    <span class="inline-block mt-3 px-4 py-1 bg-white/20 rounded-full text-white text-sm font-medium">
                        <?= ucfirst($user->role) ?>
                    </span>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="p-6">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Account Info</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-id-card text-pmh-purple"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Matric No.</p>
                            <p class="font-medium text-gray-900"><?= h($user->matric_no) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-pmh-yellow"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Email</p>
                            <p class="font-medium text-gray-900 break-all"><?= h($user->email) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-phone text-pmh-purple"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Phone</p>
                            <p class="font-medium text-gray-900"><?= h($user->phone_no) ?></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Status</p>
                            <p class="font-medium text-green-600"><?= ucfirst($user->status ?? 'Active') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Form -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-pmh-purple"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Edit Profile</h3>
                    <p class="text-sm text-gray-500">Update your personal information</p>
                </div>
            </div>

            <?= $this->Flash->render() ?>

            <?= $this->Form->create($user, ['class' => 'space-y-6']) ?>
                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user text-pmh-purple mr-2"></i>Full Name
                    </label>
                    <?= $this->Form->control('full_name', [
                        'label' => false,
                        'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none',
                        'placeholder' => 'Enter your full name'
                    ]) ?>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-pmh-purple mr-2"></i>Email Address
                    </label>
                    <?= $this->Form->control('email', [
                        'label' => false,
                        'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none',
                        'placeholder' => 'Enter your email'
                    ]) ?>
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone text-pmh-purple mr-2"></i>Phone Number
                    </label>
                    <?= $this->Form->control('phone_no', [
                        'label' => false,
                        'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none',
                        'placeholder' => '01X-XXXXXXX'
                    ]) ?>
                </div>
                
                <!-- New Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-pmh-purple mr-2"></i>New Password
                    </label>
                    <?= $this->Form->control('password', [
                        'label' => false,
                        'type' => 'password',
                        'value' => '', 
                        'required' => false,
                        'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none',
                        'placeholder' => 'Leave blank to keep current password'
                    ]) ?>
                    <p class="text-xs text-gray-500 mt-1 pl-1">
                        <i class="fas fa-info-circle mr-1" ></i> Must contain at least 8 characters, 1 uppercase, 1 number, and 1 symbol.
                    </p>
                </div>

                <!-- Matric No (Read-only) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-gray-400 mr-2"></i>Matric No. <span class="text-gray-400 font-normal">(Cannot be changed)</span>
                    </label>
                    <input type="text" value="<?= h($user->matric_no) ?>" disabled 
                        class="w-full px-4 py-3 border border-gray-100 rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed">
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" class="flex-1 bg-pmh-purple text-white font-semibold py-4 rounded-xl hover:bg-pmh-purple-dark transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'dashboard']) ?>" 
                        class="flex-1 bg-gray-100 text-gray-700 font-semibold py-4 rounded-xl hover:bg-gray-200 transition-all text-center">
                        Cancel
                    </a>
                </div>
            <?= $this->Form->end() ?>
        </div>

    </div>
</div>
