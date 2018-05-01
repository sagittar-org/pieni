					<h3>Request schema</h3>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
<?php foreach (array_keys($vars['request_schema_columns']) as $i => $table_name): ?>
						<li<?php if ($i === 0): ?> class="active"<?php endif; ?>><a href="#tabRequestSchema_<?php h($table_name); ?>" data-toggle="tab"><?php h($table_name); ?></a></li>
<?php endforeach; ?>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
<?php $i = 0; ?>
<?php foreach ($vars['request_schema_columns'] as $table_name => $table): ?>
						<div class="tab-pane<?php if ($i === 0): ?> active<?php endif; ?>" id="tabRequestSchema_<?php h($table_name); ?>">
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
								<tbody id="tableRequestSchema_<?php h($table_name); ?>">
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
