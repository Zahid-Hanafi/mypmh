<?php
/**
 * All Programs - PMH Program Announcement Platform
 * Students: View only | Admin: Full CRUD
 */
?>

<!-- Scroll to Top Button -->
<button id="scrollTopBtn" onclick="scrollToTop()" class="fixed bottom-6 right-6 w-12 h-12 bg-pmh-purple text-white rounded-full shadow-lg hover:bg-pmh-purple-dark transition-all opacity-0 invisible z-50 flex items-center justify-center">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Page Header -->
<div id="top" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">All Programs 2025</h1>
        <p class="text-gray-500 mt-1">View all PMH programs and events for this year</p>
    </div>
    <?php if ($isAdmin): ?>
    <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-purple-200 transition-all">
        <i class="fas fa-plus"></i> Create New Program
    </a>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
    <!-- Google Calendar Widget -->
    <div class="xl:col-span-1 order-2 xl:order-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden sticky top-24">
            <div class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark p-4 text-white">
                <h3 class="font-semibold flex items-center gap-2">
                    <i class="fab fa-google"></i> PMH Calendar
                </h3>
                <p class="text-purple-200 text-xs mt-1">Event schedule synced automatically</p>
            </div>
            <div class="aspect-square">
                <iframe src="https://calendar.google.com/calendar/embed?src=en.malaysia%23holiday%40group.v.calendar.google.com&ctz=Asia%2FKuala_Lumpur&showTitle=0&showNav=1&showPrint=0&showTabs=0&showCalendars=0" 
                    style="border: 0" width="100%" height="100%" frameborder="0" scrolling="no"></iframe>
            </div>
            <div class="p-4 bg-gray-50 border-t border-gray-100">
                <p class="text-xs text-gray-500 text-center">
                    <i class="fas fa-info-circle mr-1"></i> Calendar updates automatically
                </p>
            </div>
        </div>
    </div>

    <!-- Programs List -->
    <div class="xl:col-span-3 order-1 xl:order-2">
        <!-- Legend -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6">
            <div class="flex flex-wrap items-center gap-4 text-sm">
                <span class="text-gray-500">Status:</span>
                <span class="inline-flex items-center gap-2">
                    <span class="w-3 h-3 bg-pmh-yellow rounded-full"></span> Upcoming
                </span>
                <span class="inline-flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full"></span> Complete
                </span>
                <?php if (!$isAdmin): ?>
                <span class="ml-auto text-pmh-purple font-medium">
                    <i class="fas fa-hand-pointer mr-1"></i> Click "Join Program" to register
                </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Cards View -->
        <div class="space-y-4 lg:hidden">
            <?php foreach ($programs as $program): ?>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all">
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex-grow">
                            <?php if ($program->status === 'complete'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase mb-2">
                                    <i class="fas fa-check-circle mr-1"></i> Complete
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-pmh-yellow text-pmh-purple uppercase mb-2">
                                    <i class="fas fa-clock mr-1"></i> Upcoming
                                </span>
                            <?php endif; ?>
                            <h3 class="font-bold text-gray-900 text-lg"><?= h($program->name) ?></h3>
                        </div>
                        <div class="text-center bg-purple-100 rounded-xl px-3 py-2 flex-shrink-0">
                            <p class="text-lg font-bold text-pmh-purple"><?= h($program->date->format('d')) ?></p>
                            <p class="text-[10px] text-pmh-purple uppercase"><?= h($program->date->format('M')) ?></p>
                        </div>
                    </div>
                    
                    <p class="text-sm text-gray-500 flex items-center gap-2 mb-2">
                        <i class="fas fa-map-marker-alt text-pmh-yellow"></i>
                        <?= h($program->venue) ?>
                    </p>
                    
                    <?php if ($program->description): ?>
                    <p class="text-sm text-gray-600 line-clamp-2 mb-3"><?= h($program->description) ?></p>
                    <?php endif; ?>
                    
                    <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                        <?php if ($program->status === 'upcoming'): ?>
                            <a href="<?= h($program->google_form_url ?? '#') ?>" target="_blank" class="flex-1 text-center text-sm font-bold text-white bg-pmh-purple px-4 py-2.5 rounded-xl hover:bg-pmh-purple-dark transition-colors">
                                <i class="fas fa-hand-pointer mr-1"></i> Join Program
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?= $this->Url->build(['action' => 'view', $program->id]) ?>" class="text-sm font-medium text-pmh-purple hover:underline px-3 py-2">
                            Details
                        </a>
                        
                        <?php if ($isAdmin): ?>
                            <a href="<?= $this->Url->build(['action' => 'edit', $program->id]) ?>" class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash"></i>',
                                ['action' => 'delete', $program->id],
                                ['confirm' => __('Delete "{0}"?', $program->name), 'escape' => false, 'class' => 'p-2 text-red-500 hover:bg-red-50 rounded-lg']
                            ) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Program Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Venue</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php foreach ($programs as $program): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex flex-col items-center justify-center">
                                        <span class="text-xl font-bold text-pmh-purple"><?= h($program->date->format('d')) ?></span>
                                        <span class="text-[10px] text-pmh-purple uppercase font-medium"><?= h($program->date->format('M')) ?></span>
                                    </div>
                                    <span class="text-sm text-gray-400"><?= h($program->date->format('Y')) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-semibold text-gray-900"><?= h($program->name) ?></p>
                                <?php if ($program->description): ?>
                                <p class="text-sm text-gray-400 line-clamp-1 mt-1"><?= h($program->description) ?></p>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-gray-600 flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-pmh-yellow"></i>
                                    <?= h($program->venue) ?>
                                </p>
                            </td>
                            <td class="px-6 py-5">
                                <?php if ($program->status === 'complete'): ?>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-green-100 text-green-700">
                                        <i class="fas fa-check-circle mr-1.5"></i> Complete
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-pmh-yellow/20 text-pmh-purple">
                                        <i class="fas fa-clock mr-1.5"></i> Upcoming
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <?php if ($program->status === 'upcoming'): ?>
                                        <a href="<?= h($program->google_form_url ?? '#') ?>" target="_blank" class="text-sm font-semibold text-white bg-pmh-purple px-4 py-2 rounded-lg hover:bg-pmh-purple-dark transition-colors">
                                            <i class="fas fa-hand-pointer mr-1"></i> Join
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="<?= $this->Url->build(['action' => 'view', $program->id]) ?>" class="p-2 text-gray-400 hover:text-pmh-purple hover:bg-purple-50 rounded-lg transition-all" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <?php if ($isAdmin): ?>
                                        <a href="<?= $this->Url->build(['action' => 'edit', $program->id]) ?>" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?= $this->Form->postLink(
                                            '<i class="fas fa-trash"></i>',
                                            ['action' => 'delete', $program->id],
                                            ['confirm' => __('Delete "{0}"? This action cannot be undone.', $program->name), 'escape' => false, 'class' => 'p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all', 'title' => 'Delete']
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info Box for Students -->
        <?php if (!$isAdmin): ?>
        <div class="mt-6 bg-gradient-to-r from-purple-50 to-yellow-50 rounded-2xl p-6 border border-purple-100">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-pmh-purple rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-info-circle text-white text-xl"></i>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">How to Join a Program?</h4>
                    <p class="text-gray-600 text-sm">
                        Click the <strong>"Join Program"</strong> button on any upcoming event. You'll be redirected to a Google Form where you can fill in your details to register for the program.
                    </p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Scroll to Top functionality
const scrollTopBtn = document.getElementById('scrollTopBtn');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.classList.remove('opacity-0', 'invisible');
        scrollTopBtn.classList.add('opacity-100', 'visible');
    } else {
        scrollTopBtn.classList.add('opacity-0', 'invisible');
        scrollTopBtn.classList.remove('opacity-100', 'visible');
    }
});

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>