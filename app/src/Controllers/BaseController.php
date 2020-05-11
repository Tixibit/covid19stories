<?php

namespace {

    use SilverStripe\Control\Controller;
    use SilverStripe\View\Requirements;

    class BaseController extends Controller
    {
        protected function init()
        {
            parent::init();

            //css reqiurements
            Requirements::css('dist/app.css');

            //javascript requirements on pages
            Requirements::javascript('dist/manifest.js');
            Requirements::javascript('dist/vendor.js');
            Requirements::javascript('dist/app.js');
        }
    }
}
