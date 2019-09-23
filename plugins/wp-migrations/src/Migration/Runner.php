<?php

namespace WP\Migration;

class Runner
{
    const PREFIX = 'Migration';
    const NAMESPACE = 'Migration';

    /**
     * Storage repository for already executed migrations
     *
     * @var StorageInterface
     */
    protected $storage;

    protected $outputWriter;

    /**
     * Constructor
     *
     * @param callback|null Optional output writer
     */
    public function __construct(StorageInterface $storage, ?\Closure $outputWriter = null)
    {
        $this->storage = $storage;
        $this->outputWriter = $outputWriter;
    }

    /**
     * Runs migrations that have not been executed yet
     */
    public function run()
    {
        $pattern = sprintf('%s/migrations/%s*.php', WP_CONTENT_DIR, self::PREFIX);
        $migrationFiles = glob($pattern);

        $newlyExecutedMigrations = [];

        foreach ($migrationFiles as $migrationFile) {
            $migrationName = $this->runFile($migrationFile);

            if ($migrationName) {
                $newlyExecutedMigrations[] = $migrationName;
            }
        }

        if (!empty($newlyExecutedMigrations)) {
            $this->storage->addExecutedMigrations($newlyExecutedMigrations);
        }
    }

    /**
     * Runs migration from given filename
     *
     * @param string $filename
     * @return string The name of the migration that was executed, if it was executed
     */
    protected function runFile(string $filename): ?string
    {
        $migrationName = basename($filename, '.php');

        if (in_array($migrationName, $this->storage->getExecutedMigrations(), true)) {
            // Migration has already been executed. Skip it.
            return null;
        }

        $migrationClassName = sprintf('\\%s\\%s', self::NAMESPACE, $migrationName);
        $migration = new $migrationClassName();

        if ($this->outputWriter) {
            ($this->outputWriter)("Executing migration $migrationName...");
        }

        $migration->execute();

        return $migrationName;
    }
}
