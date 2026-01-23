<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Flash');

        // This line is CRITICAL. It loads the Auth tool into the system.
        $this->loadComponent('Authentication.Authentication');
        
        // This ensures the Form protection (CSRF) is active.
        $this->loadComponent('Security');
    }
}