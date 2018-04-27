<?php $errors = [1 => 'ERROR', 2 => 'WARNING', 4 => 'PARSE', 8 => 'NOTICE', 16 => 'CORE_ERROR', 32 => 'CORE_WARNING', 64 => 'COMPILE_ERROR', 128 => 'COMPILE_WARNING', 256 => 'USER_ERROR', 512 => 'USER_WARNING', 1024 => 'USER_NOTICE', 2048 => 'STRICT', 4096 => 'RECOVERABLE_ERROR', 8192 => 'DEPRECATED', 16384 => 'USER_DEPRECATED']; ?>
<div class="container">
	<h1><?php h($errors[$vars['errno']]); ?></h1>
	<div class="lead">
		<p><?php h($vars['errstr']); ?> in <b><?php h($vars['errfile']); ?></b> on line <b><?php h($vars['errline']); ?></b></p>
	</div>
</div>
