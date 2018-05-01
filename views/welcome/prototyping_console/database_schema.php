				<div class="tab-pane active" id="tabDatabaseSchema">
					<h3>Database schema</h3>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
<?php foreach (array_keys($vars['database_schema_columns']) as $i => $table_name): ?>
						<li<?php if ($i === 0): ?> class="active"<?php endif; ?>><a href="#tabDatabaseSchema_<?php h($table_name); ?>" data-toggle="tab"><?php h($table_name); ?></a></li>
<?php endforeach; ?>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
<?php $i = 0; ?>
<?php foreach ($vars['database_schema_columns'] as $table_name => $table): ?>
						<div class="tab-pane<?php if ($i === 0): ?> active<?php endif; ?>" id="tabDatabaseSchema_<?php h($table_name); ?>">
							<h4><?php h($table_name); ?></h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>id</th>
<?php foreach ($table as $column_name): ?>
										<th><?php h($column_name); ?></th>
<?php endforeach; ?>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_<?php h($table_name); ?>">
									<tr>
										<td name="id"></td>
<?php foreach ($table as $column_name): ?>
										<td name="<?php h($column_name); ?>"></td>
<?php endforeach; ?>
									</tr>
								</tbody>
							</table>
						</div>
<?php $i++; ?>
<?php endforeach; ?>
					</div>
					<script>
					function getDatabaseSchema(name)
					{
						$.ajax({
							url: '<?php href('api/database_schema/index'); ?>/' + name,
							dataType: 'json',
							success: (vars) => {
								for (let tableName in vars.data) {
									$('#tableDatabaseSchema_' + tableName + ' > *:nth-child(n + 2)').remove();
									let rowElementTemplate = $('#tableDatabaseSchema_' + tableName + ' *:first');
									for (let rowName in vars.data[tableName]) {
										let rowElement = rowElementTemplate.clone();
										rowElement.find('[name="id"]').text(rowName);
										for (let columnName in vars.data[tableName][rowName]) {
											rowElement.find('[name="' + columnName + '"]').text(vars.data[tableName][rowName][columnName]);
										}
										$('#tableDatabaseSchema_' + tableName).append(rowElement);
									}
								}
							},
						});
					}
					getDatabaseSchema('actor');
					</script>
				</div>
