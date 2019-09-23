<?php

namespace WP\Migration;

trait MigrationUtilitiesTrait
{
    protected function getPostByPermalink(string $permalink, string $type = 'post'): ?object
    {
        $args = [
            'name'        => $permalink,
            'post_type'   => $type,
            'post_status' => 'publish',
            'numberposts' => 1,
        ];

        $posts = get_posts($args);

        if ($posts) {
            return $posts[0];
        }

        return null;
    }

    protected function getPageByPermalink(string $permalink): ?object
    {
        return $this->getPostByPermalink($permalink, 'page');
    }

    protected function addToMenu(int $postId, string $title)
    {
        $locations = get_nav_menu_locations();

        if (isset($locations['primary_navigation'])) {
            $menuId = $locations['primary_navigation'];

            // Add or update item in menu
            wp_update_nav_menu_item($menuId, 0, [
                'menu-item-title'  => $title,
                'menu-item-url'    => get_permalink($postId),
                'menu-item-status' => MENU_STATUS_PUBLISH,
            ]);
        }
    }

    protected function addToMenuAfter(int $menuId, ?int $postId, string $title, string $afterTitle)
    {
        // Get menu item that we want to insert our item after
        $item = get_page_by_title($afterTitle, OBJECT, 'nav_menu_item');

        if (!$item) {
            return;
        }

        $menuOrder = $item->menu_order;

        // Update all following menu items by incrementing their position by 2
        $items = wp_get_nav_menu_items($menuId);

        foreach ($items as $item) {
            if ($item->menu_order >= $menuOrder + 1) {
                $item->menu_order = $item->menu_order + 1;
                wp_update_post($item);
            }
        }

        // Add or update item in menu
        wp_update_nav_menu_item($menuId, 0, [
            'menu-item-position' => $menuOrder + 1,
            'menu-item-title'  => $title,
            'menu-item-url'    => get_permalink($postId),
            'menu-item-status' => MENU_STATUS_PUBLISH,
        ]);
    }
}
