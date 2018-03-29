# Mizmoz App Framework (Incomplete, do not use)

## Aims

- Be lightweight, we'll only be serving API requests
- Use PHP-FIG where possible
- Be very opinionated (I hate boilerplate)
- Handle both HTTP and CLI

```php
// Use an index file for all configs
$config = new Config('./configs/index.php');

// At it's most basic
App::run($config);
```

## Project Structure

```
/App
    /Http
        /App.php - HTTP Application
        /routes.php - contains all HTTP route definitions
    /Cli
        /App.php - CLI Application
        /commands.php - contains all console commands
    /Command
/config
/public
/tests
```