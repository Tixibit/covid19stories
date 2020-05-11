<?php

namespace App;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;

class FetchTwitterDataTask extends BuildTask
{

    /**
     * Set a custom url segment (to follow dev/tasks/)
     *
     * @config
     * @var string
     */
    private static $segment = 'fetch-twitter-data-task';

    /**
     * @var bool $enabled If set to FALSE, keep it from showing in the list
     * and from being executable through URL or CLI.
     */
    protected $enabled = true;

    /**
     * @var string $title Shown in the overview on the {@link TaskRunner}
     * HTML or CLI interface. Should be short and concise, no HTML allowed.
     */
    protected $title = 'Fetch Twitter Data';

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = 'fetch data from twitter for processing later';

    private $noOfStoriesFetchedAndCreated = 0;

    /**
     * Implement this method in the task subclass to
     * execute via the TaskRunner
     *
     * @param HTTPRequest $request
     * @return
     */
    public function run($request)
    {
        $this->fetchTwitterDataForProcessing();
        echo 'Finished creating ' . $this->noOfStoriesFetchedAndCreated . ' COVID-19 stories based on our search terms';
    }

    public function getMLSearchTerms()
    {
        return MLSearchTerms::get()->filter('Approved', 1);
    }

    private function fetchTwitterDataForProcessing()
    {
        $twitterData = new TwitterAPIService();
        if ($searchTerms = $this->getMLSearchTerms()) {
            foreach ($searchTerms as $searchTerm) {
                $statuses = $twitterData->searchTweets($searchTerm->Title, 200);
                if ($statuses) {
                    foreach ($statuses as $status) {
                        if (!RawCOVIDStory::get()->filter('SourceID', $status->id_str)->first()) {
                            $rawStory = new RawCOVIDStory();
                            $rawStory->SourceID = $status->id_str;
                            $rawStory->Type = COVIDStory::TWITTER_STORY_TYPE;
                            $rawStory->Data = json_encode($status);
                            $rawStory->write();
                            $this->noOfStoriesFetchedAndCreated++;
                        }
                    }
                }
            }
        }
    }
}
