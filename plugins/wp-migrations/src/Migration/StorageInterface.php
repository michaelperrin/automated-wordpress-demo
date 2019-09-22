<?php

namespace WP\Migration;

interface StorageInterface
{
    /**
     * Get list of already executed migrations
     */
    public function getExecutedMigrations(): array;

    /**
     * Add provided list of migrations to executed migrations
     *
     * @param string[] $migrations
     * @return void
     */
    public function addExecutedMigrations(array $migrations);
}
