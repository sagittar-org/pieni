<div class="container">
  <h2><?php h($vars['alias']); ?></h2>
  <div class="table-responsive">
    <table class="table table-sm">
      <thead>
        <tr>
<?php foreach ($vars['request_table']['columns'] as $column_name => $column): ?>
          <th><?php h($column_name); ?></th>
<?php endforeach; ?>
          <th>actions</th>
        <tr>
      </thead>
      <tbody id="<?php h($vars['elm_id']); ?>-data">
        <tr class="d-none">
<?php foreach ($vars['request_table']['columns'] as $column_name => $column): ?>
          <td name="<?php h($column_name); ?>"></td>
<?php endforeach; ?>
          <td>
<?php if (in_array('view', array_keys($vars['request_table']['actions']))): ?>
            <a class="action-view" data-href="<?php href("{$vars['alias']}/view"); ?>">view</a>
<?php endif; ?>
          </td>
        <tr>
      </tbody>
    </table>
  </div>
  <script>drawIndex('<?php href($vars['alias'], ['type' => 'api']); ?>', '<?php h($vars['elm_id']); ?>-data');</script>
</div>
