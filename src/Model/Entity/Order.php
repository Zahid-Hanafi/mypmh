<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string|null $size
 * @property int $quantity
 * @property string $shipping_address
 * @property string $total_price
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $modified_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Product $product
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'product_id' => true,
        'size' => true,
        'quantity' => true,
        'shipping_address' => true,
        'total_price' => true,
        'status' => true,
        'created_at' => true,
        'modified_at' => true,
        'user' => true,
        'product' => true,
    ];
}
