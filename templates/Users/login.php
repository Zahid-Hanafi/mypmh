<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | MyPMH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'pmh-purple': '#7c2a7c', 'pmh-yellow': '#edd134' } } }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="bg-pmh-purple p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-pmh-yellow rounded-full mb-4 shadow-lg">
                    <span class="text-pmh-purple text-2xl font-bold">PMH</span>
                </div>
                <h2 class="text-white text-2xl font-bold tracking-tight">Welcome to MyPMH</h2>
            </div>

            <div class="p-8">
                <?= $this->Flash->render() ?>
                <?= $this->Form->create(null, ['class' => 'space-y-5']) ?>
                    <?php $this->Form->unlockField('role'); // Fix for Security Error ?>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Login As</label>
                        <div class="grid grid-cols-2 gap-2 p-1 bg-gray-100 rounded-xl">
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="student" checked class="peer hidden">
                                <div class="text-center py-2 rounded-lg text-sm font-bold transition-all peer-checked:bg-white peer-checked:text-pmh-purple peer-checked:shadow-sm text-gray-400">Student</div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="admin" class="peer hidden">
                                <div class="text-center py-2 rounded-lg text-sm font-bold transition-all peer-checked:bg-white peer-checked:text-pmh-purple peer-checked:shadow-sm text-gray-400">Admin</div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Matric Number</label>
                        <?= $this->Form->control('matric_no', ['label' => false, 'placeholder' => '2025XXXXXX', 'class' => 'block w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-pmh-purple']) ?>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password</label>
                        <?= $this->Form->control('password', ['label' => false, 'type' => 'password', 'placeholder' => '••••••••', 'class' => 'block w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-pmh-purple']) ?>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-pmh-purple bg-pmh-yellow hover:bg-yellow-400 transition-all">SIGN IN</button>
                    
                    <p class="text-center text-sm text-gray-500 mt-4">
                        Don't have an account? <a href="<?= $this->Url->build(['action' => 'register']) ?>" class="font-bold text-pmh-purple hover:underline">Create an Account</a>
                    </p>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</body>
</html>