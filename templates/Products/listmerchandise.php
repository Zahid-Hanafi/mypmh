<!-- Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Merchandise Store</h1>
        <p class="text-gray-500 mt-1">Shop official PMH merchandise and place your pre-orders</p>
    </div>
    <a href="#my-orders" class="inline-flex items-center gap-2 text-pmh-purple font-semibold hover:underline">
        <i class="fas fa-history"></i> View My Orders
    </a>
</div>

<!-- Search -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-8">
    <form method="get" class="flex flex-col sm:flex-row gap-4">
        <div class="relative flex-grow">
            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" name="search" placeholder="Search products..." 
                value="<?= h($this->request->getQuery('search')) ?>"
                class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pmh-purple focus:border-pmh-purple transition-all outline-none">
        </div>
        <button type="submit" class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-purple-200 transition-all">
            Search
        </button>
    </form>
</div>

<?php 
$category_list = ['New Arrival', 'T-Shirt Ivory Edition', 'T-Shirt Raven Edition', 'Tote Bags', 'Badges Ivory Edition', 'Badges Raven Edition'];
foreach ($category_list as $current_cat): 
?>
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-gradient-to-b from-pmh-purple to-pmh-purple-dark rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-900"><?= $current_cat ?></h2>
    </div>
    
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        <?php foreach ($products as $product): ?>
            <?php if (trim($product->category) === $current_cat): ?>
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-xl hover:border-pmh-purple/30 transition-all">
                <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-4 relative overflow-hidden">
                    <?= $this->Html->image('products/' . h($product->image), ['class' => 'max-h-full max-w-full object-contain group-hover:scale-110 transition-transform duration-300']) ?>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end justify-center pb-4">
                        <button onclick="openOrderModal('<?= $product->id ?>', '<?= h(addslashes($product->name)) ?>', '<?= $product->price ?>')" 
                            class="bg-pmh-yellow text-pmh-purple font-bold px-4 py-2 rounded-lg text-sm">
                            Quick Order
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 text-sm mb-1 line-clamp-2"><?= h($product->name) ?></h3>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-pmh-purple font-bold text-lg">RM <?= number_format($product->price, 2) ?></p>
                        <button onclick="openOrderModal('<?= $product->id ?>', '<?= h(addslashes($product->name)) ?>', '<?= $product->price ?>')" 
                            class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-pmh-purple hover:bg-pmh-purple hover:text-white transition-all">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<!-- My Orders -->
<div id="my-orders" class="pt-8">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-8 bg-gradient-to-b from-pmh-yellow to-yellow-400 rounded-full"></div>
        <h2 class="text-xl font-bold text-gray-900">My Purchase History</h2>
    </div>
    
    <!-- Mobile Cards -->
    <div class="space-y-4 lg:hidden">
        <?php if ($myOrders->isEmpty()): ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-10 text-center">
                <i class="fas fa-shopping-bag text-4xl text-gray-200 mb-4"></i>
                <p class="text-gray-400">No orders yet</p>
            </div>
        <?php else: ?>
            <?php foreach ($myOrders as $order): ?>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-gray-900"><?= h($order->product->name) ?></h4>
                    <?php 
                    $statusClass = 'bg-gray-100 text-gray-600';
                    if ($order->status === 'pending') $statusClass = 'bg-yellow-100 text-yellow-700';
                    if ($order->status === 'complete') $statusClass = 'bg-green-100 text-green-700';
                    ?>
                    <span class="text-xs font-bold px-2 py-1 rounded-lg <?= $statusClass ?>"><?= ucfirst($order->status) ?></span>
                </div>
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Size: <?= h($order->size ?: '-') ?> | Qty: <?= $order->quantity ?></span>
                    <span class="font-bold text-pmh-purple">RM <?= number_format((float)$order->total_price, 2) ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Desktop Table -->
    <div class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Size</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Qty</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php if ($myOrders->isEmpty()): ?>
                    <tr><td colspan="6" class="px-6 py-12 text-center text-gray-400"><i class="fas fa-shopping-bag text-4xl mb-3 block"></i> No orders yet</td></tr>
                <?php else: ?>
                    <?php foreach ($myOrders as $order): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-5 font-semibold text-gray-900"><?= h($order->product->name) ?></td>
                        <td class="px-6 py-5 text-gray-500"><?= h($order->size ?: '-') ?></td>
                        <td class="px-6 py-5 text-gray-500"><?= $order->quantity ?></td>
                        <td class="px-6 py-5 font-bold text-gray-900">RM <?= number_format((float)$order->total_price, 2) ?></td>
                        <td class="px-6 py-5">
                            <?php 
                            $statusClass = 'bg-gray-100 text-gray-600';
                            if ($order->status === 'pending') $statusClass = 'bg-yellow-100 text-yellow-700';
                            if ($order->status === 'complete') $statusClass = 'bg-green-100 text-green-700';
                            ?>
                            <span class="inline-flex px-3 py-1.5 rounded-xl text-xs font-bold <?= $statusClass ?>"><?= ucfirst($order->status) ?></span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center gap-4">
                                <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'viewReceipt', $order->id]) ?>" target="_blank" class="text-pmh-purple hover:text-pmh-purple-dark" title="Receipt"><i class="fas fa-file-pdf"></i></a>
                                <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['controller' => 'Orders', 'action' => 'delete', $order->id], ['escape' => false, 'confirm' => __('Cancel order?'), 'class' => 'text-red-500 hover:text-red-700']) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform scale-95 opacity-0 transition-all" id="modalContent">
        <div class="bg-gradient-to-r from-pmh-purple to-pmh-purple-dark p-6 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold" id="modalProductName">Product</h3>
                <button onclick="closeOrderModal()" class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center hover:bg-white/30 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'add'], 'class' => 'p-6 space-y-5']) ?>
            <?= $this->Form->hidden('product_id', ['id' => 'modalProductId']) ?>
            <?= $this->Form->hidden('total_price', ['id' => 'hiddenTotalPrice']) ?>
            <input type="hidden" id="basePrice" value="0">
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pickup Location</label>
                <?= $this->Form->select('shipping_address', ['Self-Pickup at Kolej Jasmine'=>'Self-Pickup at Kolej Jasmine'], ['class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50']) ?>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Size</label>
                    <?= $this->Form->select('size', ['XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','2XL'=>'2XL','N/A'=>'N/A'], ['class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl', 'default' => 'M']) ?>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                    <?= $this->Form->number('quantity', ['id' => 'modalQuantity', 'value' => 1, 'min' => 1, 'onchange' => 'calculateTotal()', 'class' => 'w-full px-4 py-3 border border-gray-200 rounded-xl font-bold text-center']) ?>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-50 to-yellow-50 p-5 rounded-xl text-center border border-purple-100">
                <p class="text-sm text-gray-500 mb-1">Total Amount</p>
                <p class="text-3xl font-bold text-pmh-purple">RM <span id="displayTotal">0.00</span></p>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-pmh-purple to-pmh-purple-dark text-white font-bold py-4 rounded-xl hover:shadow-lg transition-all">
                Confirm Pre-Order
            </button>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
function openOrderModal(id, name, price) {
    document.getElementById('modalProductId').value = id;
    document.getElementById('modalProductName').innerText = name;
    document.getElementById('basePrice').value = price;
    document.getElementById('orderModal').classList.remove('hidden');
    document.getElementById('orderModal').classList.add('flex');
    setTimeout(() => {
        document.getElementById('modalContent').classList.remove('scale-95', 'opacity-0');
        document.getElementById('modalContent').classList.add('scale-100', 'opacity-100');
    }, 10);
    calculateTotal();
}

function calculateTotal() {
    const price = parseFloat(document.getElementById('basePrice').value);
    const qty = parseInt(document.getElementById('modalQuantity').value) || 1;
    const total = (price * qty).toFixed(2);
    document.getElementById('displayTotal').innerText = total;
    document.getElementById('hiddenTotalPrice').value = total;
}

function closeOrderModal() { 
    document.getElementById('modalContent').classList.add('scale-95', 'opacity-0');
    setTimeout(() => {
        document.getElementById('orderModal').classList.add('hidden');
        document.getElementById('orderModal').classList.remove('flex');
    }, 200);
}
</script>