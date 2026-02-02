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

            // Monthly program data for 2025 (for bar chart)
            $monthlyPrograms = [];
            for ($month = 1; $month <= 12; $month++) {
                $count = $programsTable->find()
                    ->where([
                        'YEAR(date)' => 2025,
                        'MONTH(date)' => $month
                    ])->count();
                $monthlyPrograms[] = $count;
            }

            // Orders by product category (for pie chart)
            $ordersByCategory = [];
            $categoryLabels = [];
            $categoryData = [];
            
            $categoryResults = $ordersTable->find()
                ->select([
                    'category' => 'Products.category',
                    'count' => $ordersTable->find()->func()->count('Orders.id')
                ])
                ->contain(['Products'])
                ->group(['Products.category'])
                ->toArray();
            
            foreach ($categoryResults as $result) {
                $categoryLabels[] = $result->category;
                $categoryData[] = (int)$result->count;
            }

            // Upcoming programs for slideshow
            $upcomingProgramsList = $programsTable->find()
                ->where(['status' => 'upcoming'])
                ->order(['date' => 'ASC'])
                ->limit(5)
                ->toArray();

            $this->set(compact(
                'totalPrograms', 
                'upcomingPrograms', 
                'totalOrders', 
                'totalProducts', 
                'monthlyPrograms',
                'categoryLabels',
                'categoryData',
                'upcomingProgramsList'
            ));
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