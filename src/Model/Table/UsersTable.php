<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ApplicationsTable&\Cake\ORM\Association\HasMany $Applications
 * @property \App\Model\Table\OrdersTable&\Cake\ORM\Association\HasMany $Orders
 * @property \App\Model\Table\ReviewsTable&\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('full_name');
        $this->setPrimaryKey('id');

        $this->hasMany('Applications', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Reviews', [
            'foreignKey' => 'user_id',
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
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name');

        $validator
            ->scalar('matric_no')
            ->lengthBetween('matric_no', [10, 10], 'Matric number must be exactly 10 digits')
            ->requirePresence('matric_no', 'create')
            ->notEmptyString('matric_no')
            ->add('matric_no', 'numeric', [
                'rule' => ['custom', '/^[0-9]{10}$/'],
                'message' => 'Matric number must contain exactly 10 digits'
            ])
            ->add('matric_no', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('phone_no')
            ->maxLength('phone_no', 15)
            ->requirePresence('phone_no', 'create')
            ->notEmptyString('phone_no');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')
            ->add('password', 'minLength', [
                'rule' => ['minLength', 8],
                'message' => 'Password must be at least 8 characters long'
            ])
            ->add('password', 'hasUppercase', [
                'rule' => function ($value) {
                    return (bool)preg_match('/[A-Z]/', $value);
                },
                'message' => 'Password must contain at least 1 uppercase letter'
            ])
            ->add('password', 'hasNumber', [
                'rule' => function ($value) {
                    return (bool)preg_match('/[0-9]/', $value);
                },
                'message' => 'Password must contain at least 1 number'
            ])
            ->add('password', 'hasSymbol', [
                'rule' => function ($value) {
                    return (bool)preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/', $value);
                },
                'message' => 'Password must contain at least 1 symbol (!@#$%^&*() etc.)'
            ]);

        $validator
            ->scalar('role')
            ->notEmptyString('role');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->dateTime('created_at')
            ->allowEmptyDateTime('created_at');

        $validator
            ->dateTime('modified_at')
            ->allowEmptyDateTime('modified_at');

        return $validator;
    }

    /**
     * Validation rules for password reset
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationResetPassword(Validator $validator): Validator
    {
        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password')
            ->notEmptyString('password')
            ->add('password', 'minLength', [
                'rule' => ['minLength', 8],
                'message' => 'Password must be at least 8 characters long'
            ])
            ->add('password', 'hasUppercase', [
                'rule' => function ($value) {
                    return (bool)preg_match('/[A-Z]/', $value);
                },
                'message' => 'Password must contain at least 1 uppercase letter'
            ])
            ->add('password', 'hasNumber', [
                'rule' => function ($value) {
                    return (bool)preg_match('/[0-9]/', $value);
                },
                'message' => 'Password must contain at least 1 number'
            ])
            ->add('password', 'hasSymbol', [
                'rule' => function ($value) {
                    return (bool)preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:,.<>?]/', $value);
                },
                'message' => 'Password must contain at least 1 symbol (!@#$%^&*() etc.)'
            ]);

        $validator
            ->scalar('confirm_password')
            ->requirePresence('confirm_password')
            ->notEmptyString('confirm_password')
            ->add('confirm_password', 'compareWith', [
                'rule' => ['compareWith', 'password'],
                'message' => 'Passwords do not match'
            ]);

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['matric_no']), ['errorField' => 'matric_no']);

        return $rules;
    }
}
