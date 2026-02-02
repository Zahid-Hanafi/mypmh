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
            // Get the authenticated user's identity
            $identity = $this->Authentication->getIdentity();
            $selectedRole = $this->request->getData('role');
            
            // Validate that selected role matches user's actual role
            if ($identity->get('role') !== $selectedRole) {
                $this->Authentication->logout();
                if ($selectedRole === 'admin') {
                    $this->Flash->error(__('Access denied. You are not registered as an Admin. Please select Student.'));
                } else {
                    $this->Flash->error(__('Access denied. You are not registered as a Student. Please select Admin.'));
                }
                return null;
            }
            
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

    public function profile()
    {
        $identity = $this->Authentication->getIdentity();
        $user = $this->Users->get($identity->get('id'));
        
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData(), [
                'fields' => ['full_name', 'email', 'phone_no']
            ]);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Profile updated successfully!'));
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('Could not update profile. Please try again.'));
        }
        
        $this->set(compact('user'));
    }
}