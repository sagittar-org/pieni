				<div class="tab-pane" id="tabApplicationSchema">
					<h3>Application schema</h3>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
<?php foreach (array_keys($vars['application_schema_columns']) as $i => $table_name): ?>
						<li<?php if ($i === 0): ?> class="active"<?php endif; ?>><a href="#tabApplicationSchema_<?php h($table_name); ?>" data-toggle="tab"><?php h($table_name); ?></a></li>
<?php endforeach; ?>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
<?php $i = 0; ?>
<?php foreach ($vars['application_schema_columns'] as $table_name => $table): ?>
						<div class="tab-pane<?php if ($i === 0): ?> active<?php endif; ?>" id="tabApplicationSchema_<?php h($table_name); ?>">
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
								<tbody id="tableApplicationSchema_<?php h($table_name); ?>">
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
					function getApplicationSchema(name)
					{
						$.ajax({
							url: '<?php href('api/application_schema/index'); ?>/' + name,
							dataType: 'json',
							success: (vars) => {
								for (let tableName in vars.data) {
									$('#tableApplicationSchema_' + tableName + ' > *:nth-child(n + 2)').remove();
									let rowElementTemplate = $('#tableApplicationSchema_' + tableName + ' *:first');
									for (let rowName in vars.data[tableName]) {
										let rowElement = rowElementTemplate.clone();
										rowElement.find('[name="id"]').text(rowName);
										for (let columnName in vars.data[tableName][rowName]) {
											rowElement.find('[name="' + columnName + '"]').text(vars.data[tableName][rowName][columnName]);
										}
										$('#tableApplicationSchema_' + tableName).append(rowElement);
									}
								}
							},
						});
					}
					getApplicationSchema('actor');
					</script>
				</div>
