<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class OrdersController extends AppController
{
    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        
        if (isset($this->FormProtection)) {
            $this->FormProtection->setConfig('unlockedActions', ['add', 'updateStatus', 'delete']);
        }
        if ($this->components()->has('Security')) {
            $this->Security->setConfig('unlockedActions', ['add', 'updateStatus', 'delete']);
        }
    }

    /**
     * viewReceipt: FIXED THE TYPEERROR
     */
    public function viewReceipt($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => ['Users', 'Products']
        ]);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // FIX: We force (float) before number_format to fix image_69fcb4.png error
        $formattedPrice = number_format((float)$order->total_price, 2);

        $html = '
        <div style="font-family: sans-serif; padding: 20px; border: 5px solid #7c2a7c;">
            <h1 style="color: #7c2a7c; text-align: center;">MyPMH OFFICIAL RECEIPT</h1>
            <p style="text-align: center;">Kolej Jasmine, UiTM Puncak Perdana</p>
            <hr>
            <table style="width: 100%; border-collapse: collapse;">
                <tr><td><strong>Receipt ID:</strong></td><td>#PMH-'.$order->id.'</td></tr>
                <tr><td><strong>Date:</strong></td><td>'.$order->created_at->format('d M Y, H:i').'</td></tr>
                <tr><td><strong>Customer:</strong></td><td>'.h($order->user->name).'</td></tr>
            </table>
            <hr>
            <table style="width: 100%; margin-top: 20px;">
                <tr style="background: #f4f4f4;">
                    <th style="text-align: left; padding: 10px;">Product Name</th>
                    <th style="text-align: center;">Size</th>
                    <th style="text-align: center;">Qty</th>
                </tr>
                <tr>
                    <td style="padding: 10px;">'.h($order->product->name).'</td>
                    <td style="text-align: center;">'.h($order->size ?: 'N/A').'</td>
                    <td style="text-align: center;">'.$order->quantity.'</td>
                </tr>
            </table>
            <h2 style="text-align: right; color: #7c2a7c; margin-top: 30px;">Total Amount: RM '.$formattedPrice.'</h2>
            <hr>
            <p style="font-size: 10px; color: #666; text-align: center; margin-top: 50px;">
                Note: This is a computer-generated receipt. Present this to pick up your items.
            </p>
        </div>';

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait');
        $dompdf->render();

        $this->response = $this->response->withType('pdf');
        $this->response->getBody()->write($dompdf->output());
        return $this->response;
    }

    public function totalorder()
    {
        // Admin-only access control
        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->get('role') !== 'admin') {
            $this->Flash->error(__('Access denied. This page is for administrators only.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'dashboard']);
        }
        
        $orders = $this->Orders->find()->contain(['Users', 'Products'])->order(['Orders.id' => 'DESC'])->all();
        $this->set(compact('orders'));
    }

    public function updateStatus($id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $order = $this->Orders->get($id);
        $order->status = $this->request->getData('status');
        $this->Orders->save($order);
        return $this->redirect(['action' => 'totalorder']);
    }

    public function add()
    {
        $this->request->allowMethod(['post']);
        $order = $this->Orders->newEmptyEntity();
        $order = $this->Orders->patchEntity($order, $this->request->getData());
        $order->user_id = $this->request->getAttribute('identity')->get('id');
        $order->status = 'pending';
        if ($this->Orders->save($order)) {
            $this->Flash->success(__('Pre-order placed!'));
        }
        return $this->redirect(['controller' => 'Products', 'action' => 'listmerchandise', '#' => 'my-orders']);
    }

    /**
 * Delete method: Allows students to cancel their pre-orders
 */
public function delete($id = null)
{
    // Restrict to POST or DELETE methods for security
    $this->request->allowMethod(['post', 'delete']);
    
    $order = $this->Orders->get($id);
    
    if ($this->Orders->delete($order)) {
        $this->Flash->success(__('The pre-order has been cancelled successfully.'));
    } else {
        $this->Flash->error(__('The pre-order could not be cancelled. Please, try again.'));
    }

    // Redirect back to the merchandise list and scroll to the history section
    return $this->redirect(['controller' => 'Products', 'action' => 'listmerchandise', '#' => 'my-orders']);
}
}