<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Houserules Model
 *
 * @method \App\Model\Entity\Houserule newEmptyEntity()
 * @method \App\Model\Entity\Houserule newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Houserule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Houserule get($primaryKey, $options = [])
 * @method \App\Model\Entity\Houserule findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Houserule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Houserule[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Houserule|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Houserule saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Houserule[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Houserule[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Houserule[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Houserule[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class HouserulesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('houserules');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('rule_description')
            ->requirePresence('rule_description', 'create')
            ->notEmptyString('rule_description');

        $validator
            ->dateTime('expiry_date')
            ->allowEmptyDateTime('expiry_date');

        return $validator;
    }
}
