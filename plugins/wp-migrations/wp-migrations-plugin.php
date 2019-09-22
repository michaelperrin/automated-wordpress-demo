<?php
/**
 * Plugin Name: WordPress migrations
 * Description: A plugin to run migration commands for WordPress
 * Author: Michael Perrin
 * Version: 0.1.0
 */

require 'vendor/autoload.php';

use WP\Migration\Runner;
use WP\Migration\WordPressOptionStorage;

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('migrations migrate', function () {
        $outputWriter = function ($message, $status = null) {
            if ($status === 'success') {
                WP_CLI::success($message);
            } elseif ($status === 'error') {
                WP_CLI::error($message);
            } else {
                WP_CLI::log($message);
            }
        };

        $storage = new WordPressOptionStorage();
        $migrationRunner = new Runner($storage, $outputWriter);
        $migrationRunner->run();

        WP_CLI::success('Migrations are up to date');
    });
}
