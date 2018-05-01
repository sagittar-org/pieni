<div class="container">
	<h1>Prototyping console</h1>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li><a href="#tabErDiagram" data-toggle="tab">ER diagram</a></li>
		<li class="active"><a href="#tabAliases" data-toggle="tab">Aliases</a></li>
		<li><a href="#tabTables" data-toggle="tab">Tables</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane" id="tabErDiagram">
			<h2>ER diagram</h2>
			<div style="overflow-x: scroll;">
				<img src="<?php public_href('er_diagram.svg'); ?>">
			</div>
		</div>
		<div class="tab-pane active" id="tabAliases">
<?php load_view('welcome', 'prototyping_console/aliases', $vars); ?>
		</div>
		<div class="tab-pane" id="tabTables">
			<h2>Tables</h2>

			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tabDatabaseSchema" data-toggle="tab">Database schema</a></li>
				<li><a href="#tabApplicationSchema" data-toggle="tab">Application schema</a></li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
<?php load_view('welcome', 'prototyping_console/database_schema', $vars); ?>
<?php load_view('welcome', 'prototyping_console/application_schema', $vars); ?>
			</div>
		</div>
	</div>

	<div class="text-right">
		<p>Back to <a href="<?php href('welcome/get_started') ?>">Get Started</a> page.</p>
	</div>
</div>
