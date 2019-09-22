<?php

namespace WP\Migration;

interface MigrationInterface
{
    /**
     * Execute migration
     */
    public function execute();
}
