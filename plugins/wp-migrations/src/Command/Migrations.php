<?php

namespace WP\Command\Migrations {

    use WP\Migration\Runner;
    use WP\Migration\WordPressOptionStorage;

    function registerExecute()
    {
        WP_CLI::add_command('migrations execute', function () {
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

    function registerGenerate()
    {
        WP_CLI::add_command('migrations generate', function () {
            $className = sprintf('Migration{%s}', date('YmdHis'));

            $content = <<<EOT
<?php

namespace Migration;

use WP\Migration\MigrationInterface;

class {$className} implements MigrationInterface
{
    public function execute()
    {
        // ...
    }
}

EOT;


            $path = sprintf('%s/migrations/%s.php', WP_CONTENT_DIR, $className);

            file_put_contents($path, $content);

            WP_CLI::success("Migration created at $path");
        });
    }
}
