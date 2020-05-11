<?php

namespace App;

use SilverStripe\Admin\ModelAdmin;

class COVIDStoryAdmin extends ModelAdmin
{
    private static $managed_models = [
        COVIDStory::class,
    ];

    private static $url_segment = 'covid-stories';
    private static $menu_title = 'COVID Stories';
}
