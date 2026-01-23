<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ProgramsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Benarkan akses untuk melihat program
        $this->Authentication->addUnauthenticatedActions(['allprogram']);

        // UNLOCK ACTIONS: Mematikan semakan keselamatan form secara khusus
        if ($this->components()->has('FormProtection')) {
            $this->FormProtection->setConfig('unlockedActions', ['add', 'edit', 'delete']);
        }
    }

    public function allprogram()
    {
        $programs = $this->Programs->find('all', ['order' => ['Programs.date' => 'ASC']]);
        $user = $this->Authentication->getIdentity();
        $this->set(compact('programs', 'user'));
    }

    public function add()
    {
        $program = $this->Programs->newEmptyEntity();
        if ($this->request->is('post')) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());
            $program->created_by = $this->Authentication->getIdentity()->id;
            
            if ($this->Programs->save($program)) {
                $this->Flash->success(__('Program berjaya ditambah!'));
                return $this->redirect(['action' => 'allprogram']);
            }
            $this->Flash->error(__('Gagal menambah program. Sila cuba lagi.'));
        }
        $this->set(compact('program'));
    }
}