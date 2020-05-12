<?php

namespace {

    use SilverStripe\Control\Controller;
    use SilverStripe\Control\Session;
    use SilverStripe\View\ArrayData;
    use SilverStripe\View\Requirements;

    class BaseController extends Controller
    {
        /**
         * URL Segment used for links
         */
        public $url_segment = '/';

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

        /**
         * Get a link to a security action
         *
         * @param string $action Name of the action
         * @return string Returns the link to the given action
         */
        public function link($action = null)
        {
            return $this->join_links($this->url_segment, $action);
        }

        /**
         * setMessage function.
         *
         * intended usage example:
         * <code>
         * $controller->setFlashMessage('Error', 'Please login to view this page');
         * Director->Redirect('/login');
         * </code>
         *
         *
         * @access public
         * @param string $type - sets the message box css class (Error, Success or Message)
         * @param string $message (the message to be displayed)
         * @return void
         */
        public function setFlashMessage($type, $message)
        {
            $session = $this->getSession();
            $session->set('FlashMessage', [
                'Type' => $type,
                'Message' => $message,
            ]);
        }

        /**
         * getMessage function.
         *
         * @access public
         * @return object $message
         */
        public function getFlashMessage()
        {
            $session = $this->getSession();
            if ($message = $session->get('FlashMessage')) {
                $session->clear('FlashMessage');
                $array = new ArrayData($message);
                return $array->renderWith('FlashMessage');
            }
        }

        /**
         * Get Session
         *
         * @return void
         */
        public function getSession()
        {
            return $this->getRequest()->getSession();
        }
    }
}
