<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

class PagesController extends AppController
{
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        
        $page = $path[0];
        
        // Logic for Dashboard data
        if ($page === 'dashboard') {
            $programsTable = TableRegistry::getTableLocator()->get('Programs');
            $ordersTable = TableRegistry::getTableLocator()->get('Orders');
            $productsTable = TableRegistry::getTableLocator()->get('Products');

            // Fetch real counts for the cards
            $totalPrograms = $programsTable->find()->count();
            $upcomingPrograms = $programsTable->find()->where(['status' => 'upcoming'])->count();
            $totalOrders = $ordersTable->find()->count();
            $totalProducts = $productsTable->find()->count();

            $this->set(compact('totalPrograms', 'upcomingPrograms', 'totalOrders', 'totalProducts'));
        }

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }
}