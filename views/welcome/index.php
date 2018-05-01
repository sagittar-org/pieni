<div class="container">
	<h1>Prototyping console</h1>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li><a href="#tabDatabase" data-toggle="tab">Database</a></li>
		<li><a href="#tabTables" data-toggle="tab">Tables</a></li>
		<li class="active"><a href="#tabRequests" data-toggle="tab">Requests</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane" id="tabDatabase">
			<h2>Database</h2>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tabErDiagram" data-toggle="tab">ER diagram</a></li>
				<li><a href="#tabAliases" data-toggle="tab">Aliases</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="tabErDiagram">
					<h3>ER diagram</h3>
					<div style="overflow-x: scroll;">
						<img src="<?php public_href('er_diagram.svg'); ?>">
					</div>
				</div>
				<div class="tab-pane" id="tabAliases">
<?php load_view('welcome', 'prototyping_console/aliases', $vars); ?>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="tabTables">
			<h2>Tables</h2>
<?php load_view('welcome', 'prototyping_console/table_selector', $vars); ?>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li><a href="#tabDatabaseSchema" data-toggle="tab">Database schema</a></li>
				<li class="active"><a href="#tabApplicationSchema" data-toggle="tab">Application schema</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane" id="tabDatabaseSchema">
<?php load_view('welcome', 'prototyping_console/database_schema', $vars); ?>
				</div>
				<div class="tab-pane active" id="tabApplicationSchema">
<?php load_view('welcome', 'prototyping_console/application_schema', $vars); ?>
				</div>
			</div>
		</div>
		<div class="tab-pane active" id="tabRequests">
			<h2>Requests</h2>
<?php load_view('welcome', 'prototyping_console/request_selector', $vars); ?>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tabRequestSchema" data-toggle="tab">Request schema</a></li>
				<li><a href="#tabRenderedView" data-toggle="tab">Rendered view</a></li>
				<li><a href="#tabQuery" data-toggle="tab">Query</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
<?php load_view('welcome', 'prototyping_console/request_schema', $vars); ?>
<?php load_view('welcome', 'prototyping_console/rendered_view', $vars); ?>
<?php load_view('welcome', 'prototyping_console/query', $vars); ?>
			</div>
		</div>
	</div>

	<div class="text-right">
		<p>Back to <a href="<?php href('welcome/get_started') ?>">Get Started</a> page.</p>
	</div>
</div>
