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
						<li class="active"><a href="#tabDatabaseSchemaScalars" data-toggle="tab">Scalars</a></li>
						<li><a href="#tabDatabaseSchemaPirmaryKeys" data-toggle="tab">Primary keys</a></li>
						<li><a href="#tabDatabaseSchemaChildren" data-toggle="tab">Children</a></li>
						<li><a href="#tabDatabaseSchemaParents" data-toggle="tab">Parents</a></li>
						<li><a href="#tabDatabaseSchemaColumns" data-toggle="tab">Columns</a></li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="tabDatabaseSchemaScalars">
							<h4>Scalars</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>ID</th>
										<th>Value</th>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_scalars">
									<tr>
										<td name="id">(ID)</td>
										<td name="value">(Value)</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="tabDatabaseSchemaPirmaryKeys">
							<h4>Primary keys</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>ID</th>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_primary_keys">
									<tr>
										<td name="id">(ID)</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="tabDatabaseSchemaChildren">
							<h4>Children</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>ID</th>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_children">
									<tr>
										<td name="id">(ID)</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="tabDatabaseSchemaParents">
							<h4>Parents</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>ID</th>
										<th>Column</th>
										<th>Parent table</th>
										<th>Parent column</th>
										<th>Updata time</th>
										<th>Delete time</th>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_parents">
									<tr>
										<td name="id">(ID)</td>
										<td name="column">(column)</td>
										<td name="parent_table">(parent_table)</td>
										<td name="parent_column">(parent_column)</td>
										<td name="update_rule">(update_rule)</td>
										<td name="delete_rule">(delete_rule)</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tab-pane" id="tabDatabaseSchemaColumns">
							<h4>Columns</h4>
							<table class="table table-condensed">
								<thead>
									<tr>
										<th>ID</th>
										<th>Type</th>
										<th>Nullable</th>
										<th>Default</th>
										<th>Extra</th>
										<th>Comment</th>
									</tr>
								</thead>
								<tbody id="tableDatabaseSchema_columns">
									<tr>
										<td name="id">(ID)</td>
										<td name="type">(type)</td>
										<td name="nullable">(nullable)</td>
										<td name="default">(default)</td>
										<td name="extra">(extra)</td>
										<td name="comment">(comment)</td>
									</tr>
								</tbody>
							</table>
						</div>
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
