<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Allow public access to login and register
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);
        
        // Fix for 'Unexpected field role' error: Unlock the action
        if (isset($this->Security)) {
            $this->Security->setConfig('unlockedActions', ['login', 'register']);
        }
    }

    public function login()
    {
        $this->viewBuilder()->setLayout('ajax'); 
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'dashboard']);
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid matric number or password.'));
        }
    }

    public function register()
    {
        $this->viewBuilder()->setLayout('ajax'); 
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->role = 'student';
            $user->status = 'active';

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Registration successful! Please login.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Registration failed. Please try again.'));
        }
        $this->set(compact('user'));
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'login']);
    }
}