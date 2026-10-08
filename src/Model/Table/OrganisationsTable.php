<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Organisations Model
 *
 * @property \App\Model\Table\HouserulesTable&\Cake\ORM\Association\BelongsTo $Houserules
 * @property \App\Model\Table\StaffTable&\Cake\ORM\Association\HasMany $Staff
 * @property \App\Model\Table\VisitorsTable&\Cake\ORM\Association\HasMany $Visitors
 * @method \App\Model\Entity\Organisation newEmptyEntity()
 * @method \App\Model\Entity\Organisation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Organisation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Organisation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Organisation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Organisation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Organisation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Organisation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Organisation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Organisation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Organisation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Organisation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Organisation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrganisationsTable extends Table
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

        $this->setTable('organisations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Houserules', [
            'foreignKey' => 'rule_description_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Staff', [
            'foreignKey' => 'organisation_id',
        ]);
        $this->hasMany('Visitors', [
            'foreignKey' => 'organisation_id',
        ]);
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
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('code')
            ->maxLength('code', 154)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('organisation_details')
            ->allowEmptyString('organisation_details');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['code']), ['errorField' => 'code']);
        $rules->add($rules->existsIn(['rule_description_id'], 'Houserules'), ['errorField' => 'rule_description_id']);

        return $rules;
    }
}
