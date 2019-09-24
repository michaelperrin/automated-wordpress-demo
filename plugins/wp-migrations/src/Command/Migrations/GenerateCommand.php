<?php

namespace WP\Command\Migrations;

class GenerateCommand
{
    public static function register()
    {
        \WP_CLI::add_command('migrations generate', function () {
            $className = sprintf('Migration%s', date('YmdHi'));

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

            \WP_CLI::success("Migration created at $path");
        });
    }
}
