<nav class="navbar navbar-expand-md sticky-top navbar-light bg-light">
  <a class="navbar-brand" href="<?php href(''); ?>">pieni</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
<?php foreach ($vars['nav_tables'] as $table): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php href($table); ?>"><?php h($table); ?></a>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
</nav>
