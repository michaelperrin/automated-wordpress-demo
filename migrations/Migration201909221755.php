<?php

namespace Migration;

use WP\Migration\MigrationInterface;
use WP\Migration\MigrationUtilitiesTrait;

class Migration201909221755 implements MigrationInterface
{
    use MigrationUtilitiesTrait;

    public function execute()
    {
        $this->createAboutUsPage();
    }

    private function createAboutUsPage()
    {
        $permalink = 'about';

        if ($pageId = $this->getPageByPermalink($permalink)) {
            // Page already exists
            return $pageId->ID;
        }

        $pageData = [
            'post_name'     => $permalink,
            'post_title'    => 'About us',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'page',
            'menu_order'    => 1,
        ];

        $postId = wp_insert_post($pageData);

        $this->addToMenu($postId, 'Contact');

        return $postId;
    }
}
