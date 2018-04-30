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
<?php load_view($vars['request']['class'], $vars['request']['method'], $vars); ?>
  </body>
</html>
