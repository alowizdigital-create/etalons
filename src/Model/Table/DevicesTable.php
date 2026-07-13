<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Devices Model
 *
 * @property \App\Model\Table\CalibrationRecordsTable&\Cake\ORM\Association\HasMany $CalibrationRecords
 *
 * @method \App\Model\Entity\Device newEmptyEntity()
 * @method \App\Model\Entity\Device newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Device> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Device get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Device findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Device patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Device> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Device|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Device saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Device>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Device>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Device>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Device> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Device>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Device>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Device>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Device> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DevicesTable extends Table
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

        $this->setTable('devices');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('CalibrationRecords', [
            'foreignKey' => 'device_id',
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
            ->scalar('device_code')
            ->maxLength('device_code', 20)
            ->requirePresence('device_code', 'create')
            ->notEmptyString('device_code')
            ->add('device_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('manufacturer')
            ->maxLength('manufacturer', 255)
            ->allowEmptyString('manufacturer');

        // $validator
        //     ->date('acquisition_date')
        //     ->allowEmptyDate('acquisition_date');

        $validator
            ->integer('create_uid')
            ->allowEmptyString('create_uid');

        $validator
            ->integer('modifie_uid')
            ->allowEmptyString('modifie_uid');

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
        $rules->add($rules->isUnique(['device_code']), ['errorField' => 'device_code']);

        return $rules;
    }
}
