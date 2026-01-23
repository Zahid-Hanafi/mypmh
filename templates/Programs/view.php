<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Program $program
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Program'), ['action' => 'edit', $program->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Program'), ['action' => 'delete', $program->id], ['confirm' => __('Are you sure you want to delete # {0}?', $program->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Programs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Program'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="programs view content">
            <h3><?= h($program->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($program->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Venue') ?></th>
                    <td><?= h($program->venue) ?></td>
                </tr>
                <tr>
                    <th><?= __('Google Event Id') ?></th>
                    <td><?= h($program->google_event_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($program->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($program->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td><?= $this->Number->format($program->created_by) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($program->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($program->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified At') ?></th>
                    <td><?= h($program->modified_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
