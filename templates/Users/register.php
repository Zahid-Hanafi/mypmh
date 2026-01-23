<?php $this->disableAutoLayout(); ?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | MyPMH</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { colors: { 'pmh-purple': '#7c2a7c', 'pmh-yellow': '#edd134' } } }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="md:flex">
                <div class="md:w-1/3 bg-pmh-purple p-8 text-white">
                    <h2 class="text-2xl font-bold mb-4 text-pmh-yellow">Join PMH</h2>
                    <p class="text-purple-200 text-sm">Create an account to participate in our programs.</p>
                </div>

                <div class="md:w-2/3 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Student Registration</h2>
                    <?= $this->Flash->render() ?>
                    <?= $this->Form->create($user, ['class' => 'space-y-4']) ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-gray-500 uppercase">Full Name</label>
                                <?= $this->Form->control('full_name', ['label' => false, 'class' => 'w-full px-4 py-2.5 border rounded-xl', 'placeholder' => 'Full Name']) ?>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Matric No.</label>
                                <?= $this->Form->control('matric_no', ['label' => false, 'class' => 'w-full px-4 py-2.5 border rounded-xl', 'placeholder' => '2025XXXXXX']) ?>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Email</label>
                                <?= $this->Form->control('email', ['label' => false, 'class' => 'w-full px-4 py-2.5 border rounded-xl', 'placeholder' => 'email@uitm.edu.my']) ?>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Phone No.</label>
                                <?= $this->Form->control('phone_no', ['label' => false, 'class' => 'w-full px-4 py-2.5 border rounded-xl', 'placeholder' => '01X-XXXXXXX']) ?>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase">Password</label>
                                <?= $this->Form->control('password', ['label' => false, 'type' => 'password', 'class' => 'w-full px-4 py-2.5 border rounded-xl', 'placeholder' => '••••••••']) ?>
                            </div>
                        </div>
                        <button type="submit" class="w-full py-3 bg-pmh-purple text-white font-bold rounded-xl mt-4">CREATE ACCOUNT</button>
                        <div class="text-center pt-4">
                            <a href="<?= $this->Url->build(['action' => 'login']) ?>" class="text-sm text-pmh-purple font-bold hover:underline">Back to Login</a>
                        </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>