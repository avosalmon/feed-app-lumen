<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use App\Avosalmon\Scraper\BlogScraper;
use App\Avosalmon\Store\Blog\BlogRepositoryInterface;

class BlogScrapeCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'blog:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape kurashicom blog entries and push to Firebase';

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var App\Avosalmon\Scraper\BlogScraper
     */
    protected $scraper;

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var App\Avosalmon\Store\Blog\BlogRepositoryInterface
     */
    protected $blog;

    /**
     * Create a new command instance.
     *
     * @param  App\Avosalmon\Scraper\BlogScraper $scraper
     * @param  App\Avosalmon\Store\Blog\BlogRepositoryInterface $blog
     * @return void
     */
    public function __construct(BlogScraper $scraper, BlogRepositoryInterface $blog)
    {
        $this->scraper = $scraper;
        $this->blog    = $blog;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $debug = $this->option('debug');
        $count = $this->option('count');

        $entries = $this->scraper->getEntries($count);
        foreach ($entries as $id => $entry) {
            if ($debug) $this->logToConsole($id, $entry);
            $this->blog->create($id, $entry);
        }
    }

    /**
     * Display blog entry info to the console.
     *
     * @param  int $id
     * @param  array $entry
     * @return void
     */
    protected function logToConsole($id, $entry)
    {
        $this->info('============ ' . $id . ' ============');
        $this->info('title: '      . $entry['title']);
        $this->info('entry_url: '  . $entry['entry_url']);
        $this->info('entry_date: ' . $entry['entry_date']);
        $this->info('tag: '        . $entry['tag']);
        $this->info('image_url: '  . $entry['image_url']);
        $this->info('');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['debug', null, InputOption::VALUE_NONE, 'Display retrieved entry info in the console.'],
            ['count', null, InputOption::VALUE_OPTIONAL, 'Count for which blog entries are retrieved.', 1]
        ];
    }

}
