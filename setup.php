<?php

$commands = [
    'composer install',
    'cp .env.example .env',
    'php artisan key:generate',
    'php artisan migrate',
    'php artisan test',
    'php artisan db:seed',
    'php artisan queue:work',
    'php artisan serve'
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

echo "Laravel application setup complete.\n";
