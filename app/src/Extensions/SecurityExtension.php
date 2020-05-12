<?php

namespace App;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

class SecurityExtension extends Extension
{
    public function onAfterInit()
    {
        //css reqiurements
        Requirements::css('dist/app.css');

        //javascript requirements on pages
        Requirements::javascript('dist/manifest.js');
        Requirements::javascript('dist/vendor.js');
        Requirements::javascript('dist/app.js');
    }

    public function getPageTitle()
    {
        return 'Login ';
    }
}
