<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>pieni - the rapid prototyping</title>
    <script src="<?php public_href('third_party/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php public_href('third_party/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <link href="<?php public_href('third_party/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php public_href('third_party/bootstrap/css/bootstrap-theme.min.css'); ?>" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <h2>An Error Occurred</h2>
      <blockquote><?php h($vars['message']); ?> in <b><?php h($vars['file']); ?></b> on line <b><?php h($vars['line']); ?></b></blockquote>
<?php if (isset($vars['args'])): ?>
      <h3>Arguments</h3>
<?php foreach ($vars['args'] as $arg): ?>
      <pre>
<?php print_r($arg); ?>
      </pre>
<?php endforeach; ?>
<?php endif; ?>
      <pre>
<?php print_r(debug_backtrace()); ?>
      </pre>
    </div>
  </body>
</html>
