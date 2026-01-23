<div class="max-w-2xl mx-auto bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
    <div class="mb-8 border-b pb-4">
        <h2 class="text-2xl font-black text-pmh-purple uppercase tracking-tight">Create New Program</h2>
        <p class="text-gray-500 text-sm">Fill in the details to announce a new PMH event.</p>
    </div>

    <?= $this->Form->create($program, ['class' => 'space-y-6']) ?>
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Program Name</label>
                <?= $this->Form->control('name', ['label' => false, 'class' => 'w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-pmh-purple']) ?>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Date</label>
                    <?= $this->Form->control('date', ['label' => false, 'type' => 'date', 'class' => 'w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-pmh-purple']) ?>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Venue</label>
                    <?= $this->Form->control('venue', ['label' => false, 'class' => 'w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-pmh-purple']) ?>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                <?= $this->Form->control('status', [
                    'label' => false, 
                    'options' => ['upcoming' => 'Upcoming', 'complete' => 'Complete'],
                    'class' => 'w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-pmh-purple'
                ]) ?>
            </div>
        </div>
        
        <div class="flex gap-4 pt-4">
            <?= $this->Form->button(__('Save Program'), ['class' => 'flex-grow bg-pmh-purple text-white font-bold py-3 rounded-xl hover:bg-purple-900 transition-all shadow-lg']) ?>
            <a href="<?= $this->Url->build(['action' => 'allprogram']) ?>" class="px-8 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition-all text-center">Cancel</a>
        </div>
    <?= $this->Form->end() ?>
</div>