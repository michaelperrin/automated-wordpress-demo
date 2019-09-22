<?php

namespace WP\Migration;

/**
 * Adapter for managins migrations as a WordPress option
 */
class WordPressOptionStorage implements StorageInterface
{
    const OPTION_NAME = 'wm_migrations';

    protected static $executedMigrations = null;

    /**
     * {@inheritDoc}
     */
    public function getExecutedMigrations(): array
    {
        if (null === self::$executedMigrations) {
            // See https://developer.wordpress.org/reference/functions/get_option/
            self::$executedMigrations = json_decode(get_option(self::OPTION_NAME, '[]'), true);
        }

        return self::$executedMigrations;
    }

    /**
     * {@inheritDoc}
     */
    public function addExecutedMigrations(array $migrations)
    {
        // See https://developer.wordpress.org/reference/functions/get_option/

        $executedMigrations = array_merge(
            $this->getExecutedMigrations(),
            $migrations
        );

        // see https://developer.wordpress.org/reference/functions/update_option/
        update_option('wm_migrations', json_encode($executedMigrations));
    }
}
