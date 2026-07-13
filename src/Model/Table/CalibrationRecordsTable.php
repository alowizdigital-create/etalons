<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CalibrationRecords Model
 *
 * @property \App\Model\Table\DevicesTable&\Cake\ORM\Association\BelongsTo $Devices
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\AgentsTable&\Cake\ORM\Association\BelongsTo $Agents
 * @property \App\Model\Table\MessagesTable&\Cake\ORM\Association\HasMany $Messages
 *
 * @method \App\Model\Entity\CalibrationRecord newEmptyEntity()
 * @method \App\Model\Entity\CalibrationRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CalibrationRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CalibrationRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CalibrationRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CalibrationRecordsTable extends Table
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

        $this->setTable('calibration_records');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'company_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Agents', [
            'foreignKey' => 'agent_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Messages', [
            'foreignKey' => 'calibration_record_id',
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
            ->integer('device_id')
            ->notEmptyString('device_id');

        $validator
            ->integer('company_id')
            ->notEmptyString('company_id');

        $validator
            ->integer('agent_id')
            ->notEmptyString('agent_id');

        $validator
            ->date('calibration_date')
            ->requirePresence('calibration_date', 'create')
            ->notEmptyDate('calibration_date');

        $validator
            ->scalar('validity')
            ->maxLength('validity', 50)
            ->allowEmptyString('validity');

        $validator
            ->date('next_calibration_date')
            ->allowEmptyDate('next_calibration_date');

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
        $rules->add($rules->existsIn(['device_id'], 'Devices'), ['errorField' => 'device_id']);
        $rules->add($rules->existsIn(['company_id'], 'Companies'), ['errorField' => 'company_id']);
        $rules->add($rules->existsIn(['agent_id'], 'Agents'), ['errorField' => 'agent_id']);

        return $rules;
    }
}
