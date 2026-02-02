<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ProgramsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Allow viewing programs for all authenticated users
        // CRUD actions (add, edit, delete) require admin check in methods
        
        if ($this->components()->has('FormProtection')) {
            $this->FormProtection->setConfig('unlockedActions', ['add', 'edit', 'delete']);
        }
    }

    /**
     * Check if current user is admin
     */
    private function isAdmin(): bool
    {
        $identity = $this->Authentication->getIdentity();
        return $identity && $identity->get('role') === 'admin';
    }

    /**
     * Ensure only admins can access CRUD actions
     */
    private function requireAdmin()
    {
        if (!$this->isAdmin()) {
            $this->Flash->error(__('Access denied. Admin privileges required.'));
            return $this->redirect(['action' => 'allprogram']);
        }
        return null;
    }

    /**
     * List all programs
     */
    public function allprogram()
    {
        $programs = $this->Programs->find('all', [
            'order' => ['Programs.date' => 'ASC']
        ]);
        
        $identity = $this->Authentication->getIdentity();
        $isAdmin = $identity && $identity->get('role') === 'admin';
        
        $this->set(compact('programs', 'isAdmin'));
    }

    /**
     * View single program details
     */
    public function view($id = null)
    {
        $program = $this->Programs->get($id);
        $isAdmin = $this->isAdmin();
        $this->set(compact('program', 'isAdmin'));
    }

    /**
     * Add new program (Admin only)
     */
    public function add()
    {
        $redirect = $this->requireAdmin();
        if ($redirect) return $redirect;

        $program = $this->Programs->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());
            $program->created_by = $this->Authentication->getIdentity()->id;
            $program->status = 'upcoming'; // Default status
            
            if ($this->Programs->save($program)) {
                $this->Flash->success(__('Program has been created successfully!'));
                return $this->redirect(['action' => 'allprogram']);
            }
            $this->Flash->error(__('Failed to create program. Please try again.'));
        }
        
        $this->set(compact('program'));
    }

    /**
     * Edit program (Admin only)
     */
    public function edit($id = null)
    {
        $redirect = $this->requireAdmin();
        if ($redirect) return $redirect;

        $program = $this->Programs->get($id);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());
            
            if ($this->Programs->save($program)) {
                $this->Flash->success(__('Program has been updated successfully!'));
                return $this->redirect(['action' => 'allprogram']);
            }
            $this->Flash->error(__('Failed to update program. Please try again.'));
        }
        
        $this->set(compact('program'));
    }

    /**
     * Delete program (Admin only)
     */
    public function delete($id = null)
    {
        $redirect = $this->requireAdmin();
        if ($redirect) return $redirect;

        $this->request->allowMethod(['post', 'delete']);
        $program = $this->Programs->get($id);
        
        if ($this->Programs->delete($program)) {
            $this->Flash->success(__('Program has been deleted.'));
        } else {
            $this->Flash->error(__('Failed to delete program. Please try again.'));
        }

        return $this->redirect(['action' => 'allprogram']);
    }
}