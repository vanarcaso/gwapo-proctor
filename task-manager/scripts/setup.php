<?php

// Run after composer install. Safe to repeat: existing data and keys are retained.
$root = dirname(__DIR__);
chdir($root);

if (! file_exists('.env') && ! copy('.env.example', '.env')) {
    fwrite(STDERR, "Could not create .env.\n");
    exit(1);
}

if (! file_exists('database/database.sqlite') && ! touch('database/database.sqlite')) {
    fwrite(STDERR, "Could not create the SQLite database.\n");
    exit(1);
}

$commands = ['config:clear'];
if (! preg_match('/^APP_KEY=.+$/m', file_get_contents('.env'))) {
    $commands[] = 'key:generate --no-interaction';
}
$commands[] = 'migrate --no-interaction';

foreach ($commands as $command) {
    passthru(escapeshellarg(PHP_BINARY).' artisan '.$command, $exitCode);
    if ($exitCode !== 0) {
        exit($exitCode);
    }
}

echo "Setup complete. Run: php artisan serve --host=0.0.0.0 --port=8000\n";
