<div class="max-w-4xl mx-auto">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black text-pmh-purple uppercase">Membership Application</h1>
        <p class="text-gray-500">Apply now to become an official member of PMH UiTM</p>
    </div>

    <div class="bg-white p-10 rounded-3xl shadow-xl border border-gray-100 mb-16">
        <?= $this->Form->create($application, ['class' => 'space-y-6']) ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Current CGPA</label>
                    <?= $this->Form->control('cgpa', ['label' => false, 'type' => 'number', 'step' => '0.01', 'class' => 'w-full p-3 border rounded-xl', 'placeholder' => 'e.g. 3.50']) ?>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Phone Number</label>
                    <input type="text" class="w-full p-3 border rounded-xl bg-gray-50" value="<?= $this->request->getAttribute('identity')->phone_no ?>" disabled>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase text-gray-500 mb-1">Relative Experience / Achievements</label>
                    <?= $this->Form->control('achievement', ['label' => false, 'type' => 'textarea', 'rows' => 4, 'class' => 'w-full p-3 border rounded-xl', 'placeholder' => 'Tell us about your previous involvement in clubs or leadership roles...']) ?>
                </div>
            </div>
            <button type="submit" class="w-full bg-pmh-purple text-white font-black py-4 rounded-2xl shadow-lg hover:bg-black transition-all transform active:scale-95">SUBMIT APPLICATION</button>
        <?= $this->Form->end() ?>
    </div>

    <h2 class="text-2xl font-black text-pmh-purple uppercase mb-6 flex items-center gap-3">
        <i class="fas fa-history"></i> My Applications
    </h2>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-10">
        <table class="w-full text-left">
            <thead class="bg-black text-white">
                <tr>
                    <th class="p-4 text-xs font-bold uppercase">Date Submitted</th>
                    <th class="p-4 text-xs font-bold uppercase">CGPA</th>
                    <th class="p-4 text-xs font-bold uppercase">Status</th>
                    <th class="p-4 text-xs font-bold uppercase">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach ($myApplications as $app): ?>
                <tr>
                    <td class="p-4 text-sm font-medium text-gray-600"><?= $app->created_at->format('d M Y') ?></td>
                    <td class="p-4 font-bold text-pmh-purple"><?= h($app->cgpa) ?></td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase bg-yellow-100 text-yellow-700"><?= h($app->status) ?></span>
                    </td>
                    <td class="p-4 flex gap-4">
                        <a href="#" class="text-pmh-purple font-bold text-xs underline"><i class="fas fa-file-download mr-1"></i> PDF Letter</a>
                        <?php if ($app->status === 'pending'): ?>
                            <?= $this->Form->postLink('<i class="fas fa-trash"></i> Withdrawal', ['action' => 'delete', $app->id], ['confirm' => 'Withdraw this application?', 'class' => 'text-red-500 font-bold text-xs', 'escape' => false]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>