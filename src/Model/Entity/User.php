<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

class User extends Entity
{
    protected $_accessible = [
        'full_name' => true,
        'matric_no' => true,
        'email' => true,
        'phone_no' => true,
        'password' => true,
        'role' => true,
        'status' => true,
        'created_at' => true,
        'modified_at' => true,
        'applications' => true,
        'orders' => true,
        'programs' => true,
        'reviews' => true,
    ];

    protected $_hidden = [
        'password',
    ];

    // This function automatically hashes the password when it is set
    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return $password;
    }
}