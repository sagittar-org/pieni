<div class="container">
  <h2><?php h($vars['alias']); ?></h2>
  <table class="table table-sm">
    <tbody id="<?php h($vars['elm_id']); ?>-data">
<?php foreach ($vars['request_table']['columns'] as $column_name => $column): ?>
      <tr>
        <th><?php h($column_name); ?></th>
        <td name="<?php h($column_name); ?>"></td>
      <tr>
<?php endforeach; ?>
    </tbody>
  </table>
  <script>drawView('<?php href("{$vars['alias']}/view/{$vars['id']}", ['type' => 'api']); ?>', '<?php h($vars['elm_id']); ?>-data');</script>
</div>
