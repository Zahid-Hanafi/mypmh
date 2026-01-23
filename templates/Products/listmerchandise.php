<div class="bg-pmh-yellow text-pmh-purple py-3 font-bold shadow-md mb-9 w-screen relative left-1/2 right-1/2 -ml-[50vw] -mr-[50vw] -mt-8">
    <marquee scrollamount="10">🔥 PROMOTION: New RAVEN Edition T-shirts are now available! | 🛍️ PRE-ORDER: MyPMH Tote Bags back in stock!</marquee>
</div>

<div class="image-marquee-container mx-auto mb-10 overflow-hidden rounded-2xl shadow-2xl border-4 border-white bg-gradient-to-r from-pmh-purple to-black">
    <div class="image-marquee">
        <div class="marquee-item"><?= $this->Html->image('products/TOTE BAG (4).png') ?></div>
        <div class="marquee-item"><?= $this->Html->image('products/BADGES (2).png') ?></div>
        <div class="marquee-item"><?= $this->Html->image('products/BADGES (7).png') ?></div>
        <div class="marquee-item"><?= $this->Html->image('products/BURNING SKULL (2).png') ?></div>
        <div class="marquee-item"><?= $this->Html->image('products/STREET GRAFITTI (2).png') ?></div>
        <div class="marquee-item"><?= $this->Html->image('products/BELIEVER (2).png') ?></div>
        <div class="marquee-item"><?= $this->Html->image('products/KING APES (2).png') ?></div>
    </div>
</div>

<style>
.image-marquee-container { width: 100%; height: 320px; display: flex; align-items: center; position: relative; }
.image-marquee { display: flex; width: max-content; animation: waterfall-scroll 10s linear infinite; }
.marquee-item img { width: 250px !important; height: 250px !important; object-fit: contain !important; border-radius: 12px; padding: 0 20px; }
@keyframes waterfall-scroll { from { transform: translateX(0); } to { transform: translateX(-50%); } }
</style>

<div class="bg-white p-6 rounded-2xl shadow-md mb-10 border border-gray-100 flex flex-wrap gap-4 items-center">
    <form method="get" class="flex flex-grow gap-4 items-center">
        <input type="text" name="search" placeholder="Search product..." class="w-full px-4 py-2 border rounded-xl" value="<?= h($this->request->getQuery('search')) ?>">
        <button type="submit" class="bg-pmh-purple text-white px-6 py-2 rounded-xl font-bold">Filter</button>
    </form>
    <a href="#my-orders" class="text-pmh-purple font-black underline ml-auto">Go to My Orders</a>
</div>

<?php 
$category_list = ['New Arrival', 'T-Shirt Ivory Edition', 'T-Shirt Raven Edition', 'Tote Bags', 'Badges Ivory Edition', 'Badges Raven Edition'];
foreach ($category_list as $current_cat): 
?>
<div class="mb-16">
    <h2 class="text-2xl font-black text-pmh-purple uppercase mb-6 border-l-8 border-pmh-yellow pl-4 italic"><?= $current_cat ?></h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
        <?php foreach ($products as $product): ?>
            <?php if (trim($product->category) === $current_cat): ?>
            <div class="bg-white rounded-2xl shadow-lg border p-4 text-center transition-all hover:-translate-y-2">
                <div class="h-48 mb-4 flex items-center justify-center"><?= $this->Html->image('products/' . h($product->image), ['class' => 'max-h-full max-w-full object-contain']) ?></div>
                <h3 class="font-bold text-gray-800 text-sm mb-2 uppercase"><?= h($product->name) ?></h3>
                <p class="text-pmh-purple font-black mb-4">RM <?= number_format($product->price, 2) ?></p>
                <button onclick="openOrderModal('<?= $product->id ?>', '<?= h($product->name) ?>', '<?= $product->price ?>')" 
                        class="w-full bg-pmh-yellow text-pmh-purple font-bold py-2 rounded-xl uppercase text-xs">Pre-Order Now</button>
            </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<div id="my-orders" class="pt-10 mb-20 border-t-4 border-pmh-purple">
    <h2 class="text-3xl font-black text-pmh-purple uppercase mb-6 italic">My Purchase History</h2>
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <table class="w-full text-left">
            <thead class="bg-black text-white text-xs uppercase tracking-widest">
                <tr>
                    <th class="p-5">Product</th>
                    <th class="p-5">Size</th>
                    <th class="p-5">Qty</th>
                    <th class="p-5">Total</th>
                    <th class="p-5">Status</th>
                    <th class="p-5 text-center">Receipt</th>
                    <th class="p-5 text-center">Action</th> </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if ($myOrders->isEmpty()): ?>
                    <tr><td colspan="7" class="p-10 text-center text-gray-400 italic">No orders found.</td></tr>
                <?php else: ?>
                    <?php foreach ($myOrders as $order): ?>
                    <tr>
                        <td class="p-5 font-bold text-pmh-purple"><?= h($order->product->name) ?></td>
                        <td class="p-5"><?= h($order->size ?: '-') ?></td>
                        <td class="p-5"><?= h($order->quantity) ?></td>
                        <td class="p-5 font-black">RM <?= number_format((float)$order->total_price, 2) ?></td>
                        <td class="p-5">
                            <span class="uppercase font-bold text-[10px] bg-pmh-yellow px-2 py-1 rounded"><?= h($order->status) ?></span>
                        </td>
                        <td class="p-5 text-center">
                            <a href="<?= $this->Url->build(['controller' => 'Orders', 'action' => 'viewReceipt', $order->id]) ?>" target="_blank">
                                <i class="fas fa-file-pdf fa-lg text-pmh-purple"></i>
                            </a>
                        </td>
                        <td class="p-5 text-center">
                            <?= $this->Form->postLink(
                                '<i class="fas fa-trash-alt text-red-500 hover:text-red-700"></i>',
                                ['controller' => 'Orders', 'action' => 'delete', $order->id],
                                [
                                    'escape' => false,
                                    'confirm' => __('Are you sure you want to cancel the pre-order for {0}?', $order->product->name),
                                    'title' => 'Cancel Pre-order'
                                ]
                            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="bg-pmh-purple p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold uppercase" id="modalProductName">Product Name</h3>
            <button onclick="closeOrderModal()" class="text-white"><i class="fas fa-times"></i></button>
        </div>
        <?= $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'add'], 'class' => 'p-8 space-y-4']) ?>
            <?= $this->Form->hidden('product_id', ['id' => 'modalProductId']) ?>
            <?= $this->Form->hidden('total_price', ['id' => 'hiddenTotalPrice']) ?>
            <input type="hidden" id="basePrice" value="0">
            <div>
                <label class="block text-xs font-black uppercase text-gray-400 mb-1">Pickup Address</label>
                <?= $this->Form->select('shipping_address', ['Self-Pickup at Kolej Jasmine'=>'Self-Pickup at Kolej Jasmine'], ['class' => 'w-full p-3 border rounded-xl bg-gray-50', 'default' => 'Self-Pickup at Kolej Jasmine']) ?>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-black uppercase text-gray-400 mb-1">Size</label>
                    <?= $this->Form->select('size', ['XS'=>'XS','S'=>'S','M'=>'M','L'=>'L','XL'=>'XL','2XL'=>'2XL','N/A'=>'N/A'], ['class' => 'w-full p-3 border rounded-xl bg-gray-50', 'default' => 'M']) ?>
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-gray-400 mb-1">Qty</label>
                    <?= $this->Form->number('quantity', ['id' => 'modalQuantity', 'value' => 1, 'min' => 1, 'onchange' => 'calculateTotal()', 'onkeyup' => 'calculateTotal()', 'class' => 'w-full p-3 border rounded-xl font-bold']) ?>
                </div>
            </div>
            <div class="bg-gray-100 p-4 rounded-xl text-center border-2 border-dashed">
                <span class="text-gray-500 text-xs font-bold uppercase">Estimated Grand Total</span>
                <div class="text-2xl font-black text-pmh-purple">RM <span id="displayTotal">0.00</span></div>
            </div>
            <button type="submit" class="w-full bg-pmh-purple text-white font-black py-4 rounded-2xl uppercase shadow-lg">Confirm Pre-Order</button>
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
    calculateTotal();
}
function calculateTotal() {
    const price = parseFloat(document.getElementById('basePrice').value);
    const qty = parseInt(document.getElementById('modalQuantity').value) || 1;
    const total = (price * qty).toFixed(2);
    document.getElementById('displayTotal').innerText = total;
    document.getElementById('hiddenTotalPrice').value = total;
}
function closeOrderModal() { document.getElementById('orderModal').classList.add('hidden'); }
</script>