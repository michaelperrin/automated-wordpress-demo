<?php

namespace WP\Command\Migrations;

use WP\Migration\Runner;
use WP\Migration\WordPressOptionStorage;

class ExecuteCommand
{
    public static function register() {
        \WP_CLI::add_command('migrations execute', function () {
            $outputWriter = function ($message, $status = null) {
                if ($status === 'success') {
                    \WP_CLI::success($message);
                } elseif ($status === 'error') {
                    \WP_CLI::error($message);
                } else {
                    \WP_CLI::log($message);
                }
            };

            $storage = new WordPressOptionStorage();
            $migrationRunner = new Runner($storage, $outputWriter);
            $migrationRunner->run();

            \WP_CLI::success('Migrations are up to date');
        });
    }
}
