<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Visitor Entity
 *
 * @property int $id
 * @property int $organisation_id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email
 * @property \Cake\I18n\FrozenTime $start_time
 * @property \Cake\I18n\FrozenTime|null $end_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Organisation $organisation
 */

class Visitor extends Entity
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
        'organisation_id' => true,
        'first_name' => true,
        'last_name' => true,
        'phone_number' => true,
        'email' => true,
        'start_time' => true,
        'end_time' => true,
        'created' => true,
        'modified' => true,
        'organisation' => true,
    ];
}
