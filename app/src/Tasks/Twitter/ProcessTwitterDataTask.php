<?php

use App\RawCOVIDStory;
use SilverStripe\Dev\BuildTask;

class ProcessTwitterDataTasks extends BuildTask
{
/**
 * Set a custom url segment (to follow dev/tasks/)
 *
 * @config
 * @var string
 */
    private static $segment = 'process-twitter-data-task';

    /**
     * @var bool $enabled If set to FALSE, keep it from showing in the list
     * and from being executable through URL or CLI.
     */
    protected $enabled = true;

    /**
     * @var string $title Shown in the overview on the {@link TaskRunner}
     * HTML or CLI interface. Should be short and concise, no HTML allowed.
     */
    protected $title = 'Process Fetched Twitter Data';

    /**
     * @var string $description Describe the implications the task has,
     * and the changes it makes. Accepts HTML formatting.
     */
    protected $description = 'Processing fetched twitter data';

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
        echo 'Finished creating' . $this->noOfStoriesFetchedAndCreated . ' COVID-19 stories based on our search terms';
    }

    private function processFetchedData()
    {
        $rawStories = RawCOVIDStory::get();
    }
}
