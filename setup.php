<?php

$commands = [
    'composer install',
    'php -r "file_exists(\'.env\') || copy(\'.env.example\', \'.env\');"',
    'php artisan key:generate',
    'php -r "if (!file_exists(\'database/database.sqlite\')) { $handle = fopen(\'database/database.sqlite\', \'w\'); fclose($handle); }"',
    'php artisan migrate',
    'npm install',
    'npm run build ',
    'php artisan test',
    'php artisan db:seed',
];

foreach ($commands as $command) {
    echo "Running: $command\n";
    $output = [];
    $return_var = null;
    exec($command, $output, $return_var);

    if ($return_var !== 0) {
        echo "Error running command: $command\n";
        echo implode("\n", $output);
        exit($return_var);
    }

    echo implode("\n", $output);
    echo "\n";
}

if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
    // Windows-specific commands
    echo "Running: win\n";
    exec('start /B php -S localhost:8000 -t public & start /B php artisan queue:work');
} else {
    // Unix-like system commands
    echo "Running: Unix\n";
    exec('php -S localhost:8000 -t public > /dev/null 2>&1 &');
    exec('php artisan queue:work > /dev/null 2>&1 &');
}


echo "Laravel application setup complete.\n";
