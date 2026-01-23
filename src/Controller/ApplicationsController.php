<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ApplicationsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        if (isset($this->FormProtection)) {
            $this->FormProtection->setConfig('unlockedActions', ['add', 'edit', 'delete']);
        }
    }

    public function joinus()
    {
        $userId = $this->Authentication->getIdentity()->id;
        $myApplications = $this->Applications->find()
            ->where(['user_id' => $userId])
            ->order(['created_at' => 'DESC'])
            ->all();

        $application = $this->Applications->newEmptyEntity();
        if ($this->request->is('post')) {
            $application = $this->Applications->patchEntity($application, $this->request->getData());
            $application->user_id = $userId;
            $application->status = 'pending';
            
            if ($this->Applications->save($application)) {
                $this->Flash->success(__('Application submitted successfully!'));
                return $this->redirect(['action' => 'joinus']);
            }
            $this->Flash->error(__('Submission failed. Please try again.'));
        }

        $this->set(compact('application', 'myApplications'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $application = $this->Applications->get($id);
        if ($this->Applications->delete($application)) {
            $this->Flash->success(__('Application withdrawn.'));
        }
        return $this->redirect(['action' => 'joinus']);
    }
}