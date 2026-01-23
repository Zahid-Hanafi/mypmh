<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Application $application
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Application'), ['action' => 'edit', $application->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Application'), ['action' => 'delete', $application->id], ['confirm' => __('Are you sure you want to delete # {0}?', $application->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Applications'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Application'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="applications view content">
            <h3><?= h($application->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $application->has('user') ? $this->Html->link($application->user->full_name, ['controller' => 'Users', 'action' => 'view', $application->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($application->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($application->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cgpa') ?></th>
                    <td><?= $this->Number->format($application->cgpa) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($application->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified At') ?></th>
                    <td><?= h($application->modified_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Achievement') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($application->achievement)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
