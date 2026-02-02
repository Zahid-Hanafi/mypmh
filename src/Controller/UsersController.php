<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class UsersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Allow public access to login, register, and password reset flow
        $this->Authentication->addUnauthenticatedActions(['login', 'register', 'forgotPassword', 'resetPassword']);
        
        // Fix for 'Unexpected field role' error: Unlock the action
        if (isset($this->Security)) {
            $this->Security->setConfig('unlockedActions', ['login', 'register', 'forgotPassword', 'resetPassword']);
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
            $data = $this->request->getData();
            $fields = ['full_name', 'email', 'phone_no'];
            
            // Only patch password if it's not empty
            if (!empty($data['password'])) {
                $fields[] = 'password';
            } else {
                unset($data['password']);
            }

            $user = $this->Users->patchEntity($user, $data, [
                'fields' => $fields
            ]);
            
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Profile updated successfully!'));
                return $this->redirect(['action' => 'profile']);
            }
            $this->Flash->error(__('Could not update profile. Please try again.'));
        }
        
        $this->set(compact('user'));
    }
    public function forgotPassword()
    {
        $this->viewBuilder()->setLayout('ajax');
        
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $user = $this->Users->find()
                ->where([
                    'matric_no' => $data['matric_no'],
                    'email' => $data['email']
                ])
                ->first();

            if ($user) {
                // In a real app, send email with token. Here using session for simplicity as requested.
                $this->request->getSession()->write('ResetPassword.userId', $user->id);
                return $this->redirect(['action' => 'resetPassword']);
            }
            $this->Flash->error(__('Invalid Matric Number or Email Address.'));
        }
    }

    public function resetPassword()
    {
        $this->viewBuilder()->setLayout('ajax');
        
        $userId = $this->request->getSession()->read('ResetPassword.userId');
        if (!$userId) {
            return $this->redirect(['action' => 'login']);
        }

        $user = $this->Users->get($userId);
        $user->password = ''; // Clear password so hash doesn't show in the form
        
        if ($this->request->is(['post', 'put'])) {
            // Use the specific validation method we fixed in UsersTable
            $user = $this->Users->patchEntity($user, $this->request->getData(), [
                'validate' => 'resetPassword'
            ]);
            
            if (!$user->hasErrors() && $this->Users->save($user)) {
                $this->request->getSession()->delete('ResetPassword');
                $this->Flash->success(__('Password has been reset successfully. Please login.'));
                return $this->redirect(['action' => 'login']);
            }
            
            // Debug: Capture all errors (validation + rules)
            $errorMsg = 'Validation failed.';
            if ($user->hasErrors()) {
                $errors = [];
                foreach ($user->getErrors() as $field => $rules) {
                    if (is_array($rules)) {
                        foreach ($rules as $rule => $message) {
                            $errors[] = "$field: $message";
                        }
                    } else {
                         $errors[] = "$field: $rules";
                    }
                }
                $errorMsg = implode('<br>', $errors);
            }
            $this->Flash->error(__('Could not reset password.<br>' . $errorMsg), ['escape' => false]);
        }
        
        $this->set(compact('user'));
    }
}