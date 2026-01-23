<div class="mb-10 text-center">
    <h1 class="text-4xl font-black text-pmh-purple uppercase tracking-widest">Global Order Management</h1>
    <p class="text-gray-500 italic">Admin Dashboard for Merchandise Logistics</p>
</div>
    <div class="md:col-span-2 bg-pmh-purple p-8 rounded-2xl shadow-lg text-white flex items-center justify-between mb-10">
    <div>
        <h2 class="text-2xl font-black uppercase">Order Summary</h2>
        <p class="text-purple-200">Total processed orders this session</p>
    </div>
    <div class="text-5xl font-black text-pmh-yellow"><?= count($orders) ?></div>
</div>

<div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
    <table class="w-full text-left">
        <thead class="bg-black text-white">
            <tr>
                <th class="p-5 text-xs font-bold uppercase tracking-wider">Order Date</th>
                <th class="p-5 text-xs font-bold uppercase tracking-wider">Product</th>
                <th class="p-5 text-xs font-bold uppercase tracking-wider">Customer Details</th>
                <th class="p-5 text-xs font-bold uppercase tracking-wider">Status</th>
                <?php if ($this->request->getAttribute('identity')->get('role') === 'admin'): ?>
                    <th class="p-5 text-xs font-bold uppercase tracking-wider">Update Progress</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach ($orders as $order): ?>
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-5 text-sm font-medium text-gray-500">
                    <?= $order->created_at->format('d M Y') ?><br>
                    <span class="text-[10px] text-gray-400">ID: #PMH-<?= $order->id ?></span>
                </td>
                <td class="p-5">
                    <p class="font-bold text-pmh-purple"><?= h($order->product->name) ?></p>
                    <p class="text-xs text-gray-500">Size: <?= h($order->size ?: 'N/A') ?> | Qty: <?= h($order->quantity) ?></p>
                </td>
                <td class="p-5">
                    <p class="font-bold text-gray-800"><?= h($order->user->name) ?></p>
                    <p class="text-xs text-gray-500 italic"><?= h($order->shipping_address) ?></p>
                </td>
                <td class="p-5">
                    <?php 
                        $badgeClass = 'bg-gray-100 text-gray-600';
                        if ($order->status === 'pending') $badgeClass = 'bg-yellow-100 text-yellow-700';
                        if ($order->status === 'waiting for pickup') $badgeClass = 'bg-blue-100 text-blue-700';
                        if ($order->status === 'complete') $badgeClass = 'bg-green-100 text-green-700';
                    ?>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase <?= $badgeClass ?>">
                        <?= h($order->status) ?>
                    </span>
                </td>
                <?php if ($this->request->getAttribute('identity')->get('role') === 'admin'): ?>
                <td class="p-5">
                    <?= $this->Form->create(null, ['url' => ['action' => 'updateStatus', $order->id], 'class' => 'flex gap-2']) ?>
                        <select name="status" class="text-xs border rounded p-1 outline-none">
                            <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="waiting for pickup" <?= $order->status == 'waiting for pickup' ? 'selected' : '' ?>>Waiting for Pickup</option>
                            <option value="complete" <?= $order->status == 'complete' ? 'selected' : '' ?>>Complete</option>
                        </select>
                        <button type="submit" class="bg-gray-800 text-white p-1 px-2 rounded hover:bg-pmh-purple transition-colors">
                            <i class="fas fa-save"></i>
                        </button>
                    <?= $this->Form->end() ?>
                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>