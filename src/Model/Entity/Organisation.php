<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Organisation Entity
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $organisation_details
 * @property int $rule_description_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Houserule $houserule
 * @property \App\Model\Entity\Staff[] $staff
 * @property \App\Model\Entity\Visitor[] $visitors
 */
class Organisation extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'code' => true,
        'organisation_details' => true,
        'is_disabled' => true,
        'created' => true,
        'modified' => true,
        'houserule' => true,
        'staff' => true,
        'visitors' => true,
    ];
}
