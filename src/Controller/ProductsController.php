<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ProductsController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        if ($this->components()->has('Security')) {
            $this->Security->setConfig('unlockedActions', ['updateStatus']);
        }
    }

    /**
     * @var \App\Model\Table\OrdersTable
     */
    public $Orders = null;

    /**
     * listmerchandise method
     * Fetches products and specific order history for the current user.
     */
    public function listmerchandise()
    {
        $search = $this->request->getQuery('search');
        $category = $this->request->getQuery('category');

        $query = $this->Products->find();
        if ($search) {
            $query->where(['Products.name LIKE' => '%' . $search . '%']);
        }
        if ($category) {
            $query->where(['Products.category' => $category]);
        }

        $products = $query->all();

        // Load logged-in user identity
        $identity = $this->Authentication->getIdentity();
        $userId = $identity->get('id');
        $isAdmin = $identity->get('role') === 'admin';
        
        $this->loadModel('Orders');
        
        // Fetch orders for this student so they appear in the history section
        $myOrders = $this->Orders->find()
            ->where(['Orders.user_id' => $userId])
            ->contain(['Products'])
            ->order(['Orders.id' => 'DESC'])
            ->all();

        $this->set(compact('products', 'myOrders', 'isAdmin'));
    }

    public function updateStatus($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        
        // Security: specific admin check
        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->get('role') !== 'admin') {
            $this->Flash->error(__('You do not have permission to perform this action.'));
            return $this->redirect(['action' => 'listmerchandise']);
        }

        // Fix: Get ID from POST data if not provided in URL
        if (!$id) {
            $id = $this->request->getData('id');
        }

        $product = $this->Products->get($id);
        
        // Patch with new status
        $product = $this->Products->patchEntity($product, $this->request->getData());
        
        if ($this->Products->save($product)) {
            $this->Flash->success(__('The product status has been updated.'));
        } else {
            $this->Flash->error(__('The product status could not be updated. Please, try again.'));
        }

        return $this->redirect(['action' => 'listmerchandise']);
    }
}