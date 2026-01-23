<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Program Entity
 *
 * @property int $id
 * @property string $name
 * @property string $venue
 * @property \Cake\I18n\FrozenDate $date
 * @property string|null $google_event_id
 * @property int $created_by
 * @property string|null $status
 * @property \Cake\I18n\FrozenTime|null $created_at
 * @property \Cake\I18n\FrozenTime|null $modified_at
 */
class Program extends Entity
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
        'name' => true,
        'venue' => true,
        'date' => true,
        'google_event_id' => true,
        'created_by' => true,
        'status' => true,
        'created_at' => true,
        'modified_at' => true,
    ];
}
