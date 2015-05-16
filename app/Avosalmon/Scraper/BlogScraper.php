<?php namespace App\Avosalmon\Scraper;

use DOMDocument;
use DOMXPath;

class BlogScraper
{
    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var DOMDocument
     */
    protected $dom;

    /**
     * Variable to hold the blog base url.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Create a new instance.
     *
     * @param DOMDocument $dom
     * @param string $baseUrl
     */
    function __construct(DOMDocument $dom, $baseUrl = 'http://hokuohkurashi.com/note/page/')
    {
        $this->dom     = $dom;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Scrape blog entries. Gets 20 entries by default.
     *
     * @param  int $offset
     * @param  int $limit
     * @return array
     */
    public function getEntries($offset = 0, $limit = 1)
    {
        $entries = [];

        for ($i=1; $i < $limit+1; $i++) {
            @$this->dom->loadHTMLFile($this->baseUrl . ($offset+$i));
            $xpath = new DOMXPath($this->dom);

            // retrieve DOM
            foreach ($xpath->query('//div[@class="entry main_cntr_cntnt_inner"]') as $entryNode) {
                $url = $xpath->evaluate('string(.//h3/a/@href)', $entryNode);
                $id  = trim($url, 'http://hokuohkurashi.com/note/');
                $entry_data = [
                    'title'      => $xpath->evaluate('string(.//h3/a)', $entryNode),
                    'entry_url'  => $xpath->evaluate('string(.//h3/a/@href)', $entryNode),
                    'entry_date' => $xpath->evaluate('string(.//p[@class="date small"])', $entryNode),
                    'tag'        => $xpath->evaluate('string(.//span[@class="tag"])', $entryNode),
                    'image_url'  => $xpath->evaluate('string(.//img/@src)', $entryNode)
                ];

                $entries[$id] = $entry_data;
            }
        }

        return $entries;
    }

}
