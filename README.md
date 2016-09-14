# Mizmoz App Framework

## Aims

- Be light, we'll only be serving API requests
- Use PHP-FIG where possible
- Be very oppinionated (I hate boilerplate)

// Use an index file for all configs
$config = new Config('./configs/index.php');

// At it's most basic
App::run($config);
