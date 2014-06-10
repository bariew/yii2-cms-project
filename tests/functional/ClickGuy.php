<?php 

class ClickGuy extends TestGuy
{
    public $baseUrl;
        
    public $except = [
        '/.*\/logout.*$/',
        '/.*\/delete.*/',
        '/.*\#.*/'
    ];
    
    public $include = [];
    
    public $urls = [];
    
    public $visited = [];
    
    public $cycleLimit = 100;
    
    public function __construct(\Codeception\Scenario $scenario) 
    {
        parent::__construct($scenario);
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set("xdebug.max_nesting_level", 1000);
        $this->baseUrl = $this->getUrl('/');
        $this->include[] = '/' . str_replace('/', '\/', $this->baseUrl) . '.*/';
    }
    
    public function getUrl($root, $params = [])
    {
        $url = array_merge([$root], $params);
        return Yii::$app->getUrlManager()->createUrl($url);
    }
    
    public function clickAllLinks($url = '')
    {
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
        $limit = $this->cycleLimit;
        while ($limit) {
            try {
                $css = $this->getSelector($result);
                $url = $this->grabAttributeFrom($css, 'href');
            } catch (\Exception $e) {
                break;
            }
            $limit--;
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
                $this->clickAllLinks($url);
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
