<div class="mb-10 text-center">
    <h1 class="text-4xl font-black text-pmh-purple uppercase tracking-widest mb-2">Event Calendar 2025</h1>
    <p class="text-gray-500 italic">Stay updated with the latest programs from Persatuan Mahasiswa Hadhari</p>
</div>

<?php if ($user->role === 'admin'): ?>
<div class="mb-6 flex justify-end">
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="bg-pmh-purple text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-purple-900 transition-all flex items-center gap-2">
        <i class="fas fa-plus-circle"></i> Create New Program
    </a>
</div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <div class="lg:col-span-1 bg-white p-4 rounded-2xl shadow-md border border-gray-100">
        <h3 class="text-lg font-bold text-pmh-purple mb-4 flex items-center gap-2">
            <i class="fas fa-calendar-day"></i> PMH Official Calendar
        </h3>
        <div class="aspect-square w-full">
            <iframe src="https://calendar.google.com/calendar/embed?src=en.malaysia%23holiday%40group.v.calendar.google.com&ctz=Asia%2FKuala_Lumpur" style="border: 0" width="100%" height="100%" frameborder="0" scrolling="no" class="rounded-xl"></iframe>
        </div>
        <p class="mt-4 text-xs text-gray-400 italic text-center">Add these events to your own Google Calendar to stay notified!</p>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
            <table class="w-full text-left border-collapse">
                <thead class="bg-pmh-purple text-white">
                    <tr>
                        <th class="p-4 uppercase text-xs font-bold tracking-wider">Date</th>
                        <th class="p-4 uppercase text-xs font-bold tracking-wider">Program Name</th>
                        <th class="p-4 uppercase text-xs font-bold tracking-wider">Venue</th>
                        <th class="p-4 uppercase text-xs font-bold tracking-wider">Status</th>
                        <th class="p-4 uppercase text-xs font-bold tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php foreach ($programs as $program): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-sm font-medium text-gray-600">
                            <?= h($program->date->format('d M Y')) ?>
                        </td>
                        <td class="p-4 font-bold text-pmh-purple">
                            <?= h($program->name) ?>
                        </td>
                        <td class="p-4 text-sm text-gray-500">
                            <i class="fas fa-map-marker-alt text-pmh-yellow mr-1"></i> <?= h($program->venue) ?>
                        </td>
                        <td class="p-4">
                            <?php if ($program->status === 'complete'): ?>
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">Complete</span>
                            <?php else: ?>
                                <span class="px-3 py-1 bg-pmh-yellow text-pmh-purple rounded-full text-xs font-bold uppercase">Upcoming</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-4 flex gap-3">
                            <?php if ($program->status === 'upcoming'): ?>
                                <a href="https://forms.gle/your-google-form-link" target="_blank" class="text-xs font-bold text-pmh-purple hover:underline">Join Now</a>
                            <?php endif; ?>
                            
                            <?php if ($user->role === 'admin'): ?>
                                <a href="<?= $this->Url->build(['action' => 'edit', $program->id]) ?>" class="text-blue-500 hover:text-blue-700"><i class="fas fa-edit"></i></a>
                                <?= $this->Form->postLink(
                                    '<i class="fas fa-trash"></i>',
                                    ['action' => 'delete', $program->id],
                                    ['confirm' => __('Delete {0}?', $program->name), 'escape' => false, 'class' => 'text-red-500 hover:text-red-700']
                                ) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-8 right-8 w-12 h-12 bg-pmh-yellow text-pmh-purple rounded-full shadow-2xl flex items-center justify-center hover:bg-pmh-purple hover:text-white transition-all transform hover:scale-110 z-50 border-2 border-pmh-purple">
    <i class="fas fa-arrow-up"></i>
</button>