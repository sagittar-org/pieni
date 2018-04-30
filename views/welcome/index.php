<div class="container">
	<h1>Prototyping Console</h1>

	<!-- Nav tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#erDiagram" data-toggle="tab">ER diagram</a></li>
		<li><a href="#tables" data-toggle="tab">Tables</a></li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div class="tab-pane active" id="erDiagram">
			<h3>ER diagram</h3>
			<div style="overflow-x: scroll;">
				<img src="<?php public_href('schema.svg'); ?>">
			</div>
		</div>
		<div class="tab-pane" id="tables">
			<h3>Tables</h3>
		</div>
	</div>

	<div class="text-right">
		<p>Back to <a href="<?php href('welcome/get_started') ?>">Get Started</a> page.</p>
	</div>
</div>
