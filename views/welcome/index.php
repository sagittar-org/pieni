<div class="container">
	<h1>Prototyping console</h1>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li><a href="#tabErDiagram" data-toggle="tab">ER diagram</a></li>
		<li class="active"><a href="#tabTables" data-toggle="tab">Tables</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane" id="tabErDiagram">
			<h2>ER diagram</h2>
			<div style="overflow-x: scroll;">
				<img src="<?php public_href('er_diagram.svg'); ?>">
			</div>
		</div>
		<div class="tab-pane active" id="tabTables">
			<h2>Tables</h2>

			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tabDatabaseSchema" data-toggle="tab">Database schema</a></li>
				<li><a href="#tabApplicationSchema" data-toggle="tab">Application schema</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
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
<?php foreach ($table as $row_name): ?>
										<th><?php h($row_name); ?></th>
<?php endforeach; ?>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_<?php h($table_name); ?>">
									<tr>
										<td name="id">(ID)</td>
<?php foreach ($table as $row_name): ?>
										<td name="<?php h($row_name); ?>"></td>
<?php endforeach; ?>
									</tr>
								</tbody>
							</table>
						</div>
<?php $i++; ?>
<?php endforeach; ?>
					</div>

<script>
$.ajax({
	url: '<?php href('api/database_schema/index/address'); ?>',
	dataType: 'json',
	success: (vars) => {
		for (let tableName in vars.data) {
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
</script>
				</div>
				<div class="tab-pane" id="tabApplicationSchema">
					<h3>Application schema</h3>
				</div>
			</div>
		</div>
	</div>

	<div class="text-right">
		<p>Back to <a href="<?php href('welcome/get_started') ?>">Get Started</a> page.</p>
	</div>
</div>
