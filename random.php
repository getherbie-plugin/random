<?php

use Herbie\DI;
use Herbie\Hook;

Hook::attach('pageLoaded', function($page) {
    if (!empty($page->random)) {
        $menuItemCollection = DI::get('Menu\Page\Collection');
        $excludeRoutes = empty($page->random['excludes']) ? [] : $page->random['excludes'];
        do {
            $menuItem = $menuItemCollection->getRandom();
            $invalid = ($menuItem->hidden == true)
                || ($menuItem->path == $page->path)
                || in_array($menuItem->route, $excludeRoutes);
        } while ($invalid);
        if (isset($menuItem)) {
            $page->load($menuItem->getPath());
        }
    }
});
