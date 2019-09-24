<?php
/**
 * Plugin Name: WordPress migrations
 * Description: A plugin to run migration commands for WordPress
 * Author: Michael Perrin
 * Version: 0.1.0
 */

require 'vendor/autoload.php';

use WP\Command\Migrations\ExecuteCommand;
use WP\Command\Migrations\GenerateCommand;

function registerCommands()
{
    if (defined('WP_CLI') && WP_CLI) {
        GenerateCommand::register();
        ExecuteCommand::register();
    }
}

registerCommands();
