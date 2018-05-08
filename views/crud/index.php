<div class="container">
  <h2><?php h($vars['alias']); ?></h2>
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
          <a class="action-view" data-href="<?php href("{$vars['alias']}/view"); ?>">view</a>
        </td>
      <tr>
    </tbody>
  </table>
  <script>drawIndex('<?php href($vars['alias'], ['type' => 'api']); ?>', '<?php h($vars['elm_id']); ?>-data');</script>
</div>
