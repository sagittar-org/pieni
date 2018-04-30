<div class="container">
	<h1>Prototyping Console</h1>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#er-diagram" role="tab" data-toggle="tab">ER Diagram</a></li>
    <li role="presentation" class="active"><a href="#tables" role="tab" data-toggle="tab">Tables</a></li>
    <li role="presentation"><a href="#configurations" role="tab" data-toggle="tab">Configurations</a></li>
    <li role="presentation"><a href="#languages" role="tab" data-toggle="tab">Languages</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="er-diagram">
        <h2>ER Diagram</h2>
        <div style="overflow: scroll;">
	<img src="<?php public_href('schema.svg'); ?>">
	</div>
    </div>
    <div role="tabpanel" class="tab-pane active" id="tables">
        <h2>Tables</h2>
<?php foreach ($vars['database_schemas'] as $database_schema_name => $database_schema): ?>
<input name="table_name" type="radio"><?php h($database_schema_name); ?> 
<?php endforeach; ?>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation"><a href="#databaseSchema" role="tab" data-toggle="tab">Database Schemas</a></li>
    <li role="presentation"><a href="#applicationSchema" role="tab" data-toggle="tab">Application Schemas</a></li>
    <li role="presentation" class="active"><a href="#requestSchema" role="tab" data-toggle="tab">Request Schemas</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="databaseSchema">
	<h3>Database Schemas</h3>
<?php load_view('welcome/prototyping_console', 'database_schema', $vars); ?>
    </div>
    <div role="tabpanel" class="tab-pane" id="applicationSchema">
	<h3>Application Schemas</h3>
<?php load_view('welcome/prototyping_console', 'application_schema', $vars); ?>
    </div>
    <div role="tabpanel" class="tab-pane active" id="requestSchema">
	<h3>Request Schemas</h3>
	<div>
	<b>Actor</b>
<?php foreach (['admin', 'member', 'guest'] as $action_name): ?>
<input name="action_name" type="radio"><?php h($action_name); ?> 
<?php endforeach; ?>
	</div>
	<div>
	<b>Alias</b>
<?php foreach (['actor', 'film_actor'] as $alias_name): ?>
<input name="alias_name" type="radio"><?php h($alias_name); ?> 
<?php endforeach; ?>
	</div>
	<div>
	<b>Action</b>
<?php foreach (['index', 'view', 'add', 'edit', 'delete'] as $action_name): ?>
<input name="action_name" type="radio"><?php h($action_name); ?> 
<?php endforeach; ?>
	</div>

<?php load_view('welcome/prototyping_console', 'application_schema', $vars); ?>
    </div>
  </div>

    </div>
  </div>


	<p>Back to <a href="<?php href('welcome/get_started') ?>">Get Started</a> page.</p>
</div>
