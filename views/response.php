<!doctype html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="<?php pub('third_party/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php pub('default.css'); ?>" rel="stylesheet">
<script src="<?php pub('third_party/jquery/jquery.min.js'); ?>"></script>
<script src="<?php pub('third_party/bootstrap/js/bootstrap.min.js'); ?>"></script>
<script>const siteUrl = '<?php href(''); ?>';</script>
<?php load_view('nav', $vars); ?>
<?php load_view($vars['view'], $vars, '', $vars['class']); ?>
<footer class="footer">
  <div class="container">
    <span class="text-muted">Place sticky footer content here.</span>
  </div>
</footer>
