<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Agents Model
 *
 * @property \App\Model\Table\CalibrationRecordsTable&\Cake\ORM\Association\HasMany $CalibrationRecords
 *
 * @method \App\Model\Entity\Agent newEmptyEntity()
 * @method \App\Model\Entity\Agent newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Agent> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Agent get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Agent findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Agent patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Agent> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Agent|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Agent saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Agent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Agent>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Agent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Agent> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Agent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Agent>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Agent>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Agent> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AgentsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('agents');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CalibrationRecords', [
            'foreignKey' => 'agent_id',
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
            ->uuid('uuid')
            ->requirePresence('uuid', 'create')
            ->notEmptyString('uuid');

        $validator
            ->scalar('registration_number')
            ->maxLength('registration_number', 50)
            ->requirePresence('registration_number', 'create')
            ->notEmptyString('registration_number')
            ->add('registration_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('grade')
            ->maxLength('grade', 255)
            ->allowEmptyString('grade');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 30)
            ->allowEmptyString('phone');

        $validator
            ->integer('create_uid')
            ->allowEmptyString('create_uid');

        $validator
            ->integer('write_uid')
            ->allowEmptyString('write_uid');

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
        $rules->add($rules->isUnique(['registration_number']), ['errorField' => 'registration_number']);

        return $rules;
    }
}
