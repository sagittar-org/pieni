<div align="center">
  <svg xmlns="http://www.w3.org/2000/svg" width="120px" height="120px">
    <defs>
      <linearGradient id="g" x1="0" y1="1" x2="0" y2="0">
        <stop offset="0" stop-color="#800000" />
        <stop offset="1" stop-color="#FF0000" />
      </linearGradient>
    </defs>
    <path d="
      M0,30
      a30,30,0,0,1,60,0
      v70
      l-40,20
      v-90
      a10,10,0,0,0,-20,0
      M40,40
      a40,40,0,1,1,80,0
      a40,40,0,1,1,-80,0
      a20,20,0,1,0,40,0
      a20,20,0,1,0,-40,0
    " fill="url(#g)" />
  </svg>
  <h1>pieni - the rapid prototyping</h1>
</div>
<p align="center">
  <a href="https://packagist.org/packages/pieni/pieni" target="_blank">
    <img alt="Latest Stable Version" src="https://poser.pugx.org/pieni/pieni/version">
  </a>
  <a href="https://packagist.org/packages/pieni/pieni" target="_blank">
    <img alt="Total Downloads" src="https://poser.pugx.org/pieni/pieni/downloads">
  </a>
  <a href="https://packagist.org/packages/pieni/pieni" target="_blank">
    <img alt="License" src="https://poser.pugx.org/pieni/pieni/license">
  </a>
</p>

## Requirement
Apache 2.4.x / MySQL 5.7.x / PHP 7.0.x

## Install
```bash
composer require pieni/pieni
cp vendor/pieni/pieni/index.php .
cp vendor/pieni/pieni/.htaccess .
cp vendor/pieni/pieni/.gitignore .
```

## License
MIT License
