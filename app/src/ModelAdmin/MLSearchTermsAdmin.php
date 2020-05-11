<?php

namespace App;

use SilverStripe\Admin\ModelAdmin;

class MLSearchTermsAdmin extends ModelAdmin
{
    private static $managed_models = [
        MLSearchTerms::class,
    ];

    private static $url_segment = 'ml-search-terms';
    private static $menu_title = 'ML Search Terms';
}
