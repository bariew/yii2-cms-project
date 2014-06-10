<?php 
namespace tests\functional;

class ClickGuy extends TestGuy
{
    public $baseUrl;
    
    public $maxDepth = 3;
    
    public $except = [
        '/.*\/logout.*$/',
        '/.*\/delete.*/',
        '/.*\#.*/'
    ];
    
    public $include = [];
    
    public $urls = [];
    
    public $visited = [];
    
    public function __construct(\Codeception\Scenario $scenario) 
    {
        parent::__construct($scenario);
        $this->setBaseUrl();
    }
    
    public function setBaseUrl()
    {
        $mainPage = new \tests\_pages\MainPage($this);
        $this->baseUrl = $mainPage->getUrl();
        $this->include[] = '/' . str_replace('/', '\/', $this->baseUrl) . '.*/';
    }
    
    public function clickThemAll($url)
    {
        ini_set("xdebug.max_nesting_level", 200);
        $startUrl = $this->baseUrl . str_replace($this->baseUrl, "", $url);
        $this->visited[] = $startUrl;
        $currentUrls = array_diff($this->getPageUrls($startUrl), $this->urls);
        $this->visitUrls($currentUrls);
    }
    
    public function getSelector($urls)
    {
        $css = 'a';
        if (!$urls) {
            return $css;
        }
        foreach ($urls as $url) {
            $css .= ':not([href="'.$url.'"])';
        }
        return $css;
    }
    
    protected function getPageUrls($startUrl)
    {
        $this->amOnPage($startUrl);
        $result = [];
        while (true) {
            try {
                $css = $this->getSelector($result);
                $url = $this->grabAttributeFrom($css, 'href');
            } catch (\Exception $e) {
                break;
            }
            $result[] = $url;
        }
        return $result;
    }
    
    protected function visitUrls($urls)
    {
        foreach ( $urls as $url) {
            $this->urls[] = $url;
            if ($this->filterUrl($url)) {
                continue;
            }
            try {
                $this->clickThemAll($url);
            } catch (\Exception $ex) {
                echo "Could not open page at " . str_replace($this->baseUrl, "", $url);
                exit;
            }
        }        
    }
    
    protected function filterUrl($url)
    {
        if (in_array($url, $this->visited)) {
            return true;
        } 
        foreach ($this->include as $filter) {
            if (!preg_match($filter, $url)) {
                return true;
            }
        }
        foreach ($this->except as $filter) {
            if (preg_match($filter, $url)) {
                return true;
            }
        }
        return false;
    }
}
