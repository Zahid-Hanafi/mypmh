<?php
declare(strict_types=1);

namespace App\Controller;

class ProductsController extends AppController
{
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

        // Load logged-in student identity
        $userId = $this->Authentication->getIdentity()->id;
        $this->loadModel('Orders');
        
        // Fetch orders for this student so they appear in the history section
        $myOrders = $this->Orders->find()
            ->where(['Orders.user_id' => $userId])
            ->contain(['Products'])
            ->order(['Orders.id' => 'DESC'])
            ->all();

        $this->set(compact('products', 'myOrders'));
    }
}