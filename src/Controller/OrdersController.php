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
        <html>
        <head>
            <style>
                body { font-family: "Helvetica", sans-serif; color: #333; line-height: 1.6; }
                .container { max-width: 100%; border: 1px solid #ddd; padding: 40px; border-radius: 8px; }
                .header { text-align: center; margin-bottom: 40px; border-bottom: 2px solid #7c2a7c; padding-bottom: 20px; }
                .logo { font-size: 24px; font-weight: bold; color: #7c2a7c; text-transform: uppercase; letter-spacing: 2px; }
                .subtitle { font-size: 14px; color: #edd134; font-weight: bold; background: #7c2a7c; padding: 5px 15px; border-radius: 20px; display: inline-block; margin-top: 10px; }
                .school-info { font-size: 12px; color: #666; margin-top: 5px; }
                
                .receipt-meta { width: 100%; margin-bottom: 30px; }
                .receipt-meta td { vertical-align: top; padding: 5px 0; }
                .label { color: #888; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; }
                .value { font-weight: bold; font-size: 14px; }
                
                .table-wrapper { margin-bottom: 30px; border-radius: 8px; overflow: hidden; border: 1px solid #eee; }
                .product-table { width: 100%; border-collapse: collapse; }
                .product-table th { background: #f9f9f9; padding: 12px 15px; text-align: left; font-size: 12px; font-weight: bold; color: #555; text-transform: uppercase; border-bottom: 1px solid #eee; }
                .product-table td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; }
                .product-table tr:last-child td { border-bottom: none; }
                
                .total-section { text-align: right; margin-top: 20px; }
                .total-label { font-size: 14px; color: #666; margin-right: 15px; }
                .total-amount { font-size: 24px; color: #7c2a7c; font-weight: bold; }
                
                .process-flow { margin-top: 40px; background: #fdfdfd; border: 1px dashed #ddd; padding: 20px; border-radius: 8px; font-size: 12px; }
                .flow-steps { margin-bottom: 15px; color: #7c2a7c; font-weight: bold; text-align: center; }
                .instructions { color: #555; }
                .instructions strong { color: #333; }
                
                .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #aaa; border-top: 1px solid #eee; padding-top: 20px; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <div class="logo">MyPMH</div>
                    <div class="subtitle">Official Pre-Order Receipt</div>
                    <div class="school-info">Persatuan Mahasiswa Hadhari<br>UiTM Puncak Perdana, Kolej Jasmine</div>
                </div>

                <table class="receipt-meta">
                    <tr>
                        <td width="60%">
                            <div class="label">Customer Name</div>
                            <div class="value">'.h($order->user->full_name).'</div>
                            <br>
                            <div class="label">Matric Number</div>
                            <div class="value">'.h($order->user->matric_no).'</div>
                        </td>
                        <td width="40%" style="text-align: right;">
                            <div class="label">Receipt No</div>
                            <div class="value">#PMH-'.$order->id.'</div>
                            <br>
                            <div class="label">Date Issued</div>
                            <div class="value">'.$order->created_at->format('d M Y, h:i A').'</div>
                        </td>
                    </tr>
                </table>

                <div class="table-wrapper">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th width="60%">Item Description</th>
                                <th width="20%" style="text-align: center;">Size</th>
                                <th width="20%" style="text-align: center;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="font-weight: bold;">'.h($order->product->name).'</div>
                                    <div style="font-size: 12px; color: #888;">Category: '.h($order->product->category).'</div>
                                </td>
                                <td style="text-align: center;">'.h($order->size ?: 'Standard').'</td>
                                <td style="text-align: center;">'.$order->quantity.'</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="total-section">
                    <span class="total-label">TOTAL AMOUNT DUE</span>
                    <span class="total-amount">RM '.$formattedPrice.'</span>
                </div>

                <div class="process-flow">
                    <div class="flow-steps">
                        PENDING &rarr; WAITING FOR PICKUP &rarr; PAID & COLLECTED
                    </div>
                    <div class="instructions">
                        <strong>Payment Instructions:</strong>
                        <p style="margin: 5px 0;">Please present this receipt at the <strong>PMH Counter (Kolej Jasmine / Office)</strong> when the status changes to "Waiting for Pickup".</p>
                        <p style="margin: 5px 0 0 0;">ACCEPTED PAYMENT METHODS:<br> &bull; Cash<br> &bull; QR Pay / Online Transfer</p>
                    </div>
                </div>

                <div class="footer">
                    This is a computer-generated document. No signature is required.<br>
                    Generated by MyPMH Student Portal v1.0
                </div>
            </div>
        </body>
        </html>';

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