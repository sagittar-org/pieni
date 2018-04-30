<?php $application_schema_name = 'actor'; ?>
<?php $application_schema = $vars['application_schemas']['actor']; ?>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
<?php foreach ($application_schema as $table_name => $table): ?>
    <li role="presentation"><a href="#<?php h($application_schema_name); ?>-<?php h($table_name); ?>" role="tab" data-toggle="tab"><?php h($table_name); ?></a></li>
<?php endforeach; ?>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
<?php foreach ($application_schema as $table_name => $table): ?>
    <div role="tabpanel" class="tab-pane" id="<?php h($application_schema_name); ?>-<?php h($table_name); ?>">
<table class="table table-condensed">
<?php foreach ($table as $row_key => $row): ?>
	<tr>
		<td>
<?php h($row_key); ?>
		</td>
<?php foreach ($row as $column => $field): ?>
		<td>
<?php h($field); ?>
		</td>
<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
</table>
    </div>
<?php endforeach; ?>
  </div>
