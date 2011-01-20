<?php

/**
 * KtaiAnalytics, Google Analytics tracking for Ktai (Japanese mobile phone)
 * 
 * @package    KtaiAnalytics
 * @author     naberon <naberon86@gmail.com>
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class KtaiAnalytics
{

// properties {{{ 

    /**
     * @access public
     * @var string
     */
    public $img_path = '/ka.php';

    /**
     * debug parameter flag
     * @access public
     * @var boolean
     */
    public $debug = false;

    /**
     * web property ID (Analytics Account ID)
     * @access private
     * @var string
     */
    private $account;

    /**
     * Page Title
     * @access private
     * @var string
     */
    private $pageTitle;

    /**
     * Event tracking
     * @access private
     * @var string
     */
    private $eventData = array();

    /**
     * Custom Var list
     * @access private
     * @var string
     */
    private $CustomVars = array(
        1 => NULL,
        2 => NULL,
        3 => NULL,
        4 => NULL,
        5 => NULL
    );

    /**
     * tracking page URL
     * @access private
     * @var string
     */
    private $opt_pageURL;

    /**
     * pageview tracking URL
     * @access private
     * @var array
     */
    private $pageviewURL = array();

// }}} properties
    
// {{{ public function

    /**
     * set web property ID.
     * (e.g.UA-65432-1)
     *
     * @param string $accountID web property ID
     * @return boolean
     */
    function _setAccount($accountId=null)
    {
        if(preg_match('/^MO-[0-9]+-[0-9]+$/', $accountId)) {
            $this->account = $accountId;
            return true;
        } else {
            echo 'Format ERROR: Cannot set web property ID. use `MO-XXXXX-YY`.<br />';
            return false;
        }
    }

    /**
     * set Custom Var.
     *
     * @param integer $index Custom var slot [1-5]
     * @param string $name Custom var name
     * @param string $value Custom var value
     * @param integer $opt_scope scope 1.user 2.session 3.page
     * @return boolean
     */
    function _setCustomVar($index, $name, $value, $opt_scope)
    {
        if(1 > $index AND 5 < $index) return false;

        $this->CustomVars[$index] = array(
            'name' => urlencode($name),
            'value' => urlencode($value),
            'scope' => $opt_scope
        );
        return true;
    }

    /**
     * set page title.
     *
     * @param string $pageTitle page title
     * @return boolean
     */
    function _setTitle($pageTitle='')
    {
        $this->pageTitle = $pageTitle;
        return true;
    }

    /**
     * set event.
     *
     * @param string $category   event category
     * @param string $action     event action
     * @param string $opt_label  event info
     * @param int    $opt_value  event value
     * @return boolean
     */
    function _trackEvent($category, $action, $opt_label, $opt_value)
    {
        if(empty($category) OR empty($action)) return false;
        $this->eventData[] = array(
            'category' => $category,
            'action'  => $action,
            'label' => $opt_label,
            'value' => $opt_value
        );
        return true;
    }

    /**
     * render tracking gif
     *
     * @param string $pageURL tracking URL
     * @return boolean
     */
    function _trackPageview($opt_pageURL=null)
    {
        if(is_null($this->account)) {
            echo 'Cannot tracking: Not set web property ID.<br />';
            return false;
        }
        if(!is_null($opt_pageURL)) $this->opt_pageURL = $opt_pageURL;
        $this->__createPageviewURL();
        $this->__renderPageviewImg();
        return true;
    }


// public function }}}
    
// private function {{{

    /**
     * ka.php img URL create
     */
    private
    function __createPageviewURL()
    {
        $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '-';
        if(is_null($this->opt_pageURL)) {
            $path = isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : '';
        } else {
            $path = $this->opt_pageURL;
        }

        $url = "";
        $url .= "{$this->img_path}?utmac={$this->account}";
        $url .= "&utmn=" . rand(0, 0x7fffffff);

        $url .= "&utmr=" . urlencode($referer);

        if (!empty($path)) $url .= "&utmp=" . urlencode($path);

        $url .= "&guid=ON";

        if (true === $this->debug) $url .= "&utmdebug=ON";

        // Custom Var
        $CustomVarURL = $this->__createCustomVar();

        // Page title
        if(!empty($this->pageTitle)) $url .= "&utmdt=" . urlencode($this->pageTitle);

        // event
        foreach($this->eventData as $event) {
            $utme = "&utmt=event&utme=5(" . urlencode($event['category']) . '*' . 
                urlencode($event['action']) . '*' . 
                urlencode($event['label']) . ')(' . 
                urlencode($event['value']) . ')' . $CustomVarURL;
            $this->pageviewURL[] = $url . $utme;
        }

        if(!empty($CustomVarURL)) $url .= "&utme={$CustomVarURL}"
        $this->pageviewURL[]  = $url;
        return true;
    }

    /**
     * ka.php img tag render
     *
     * @return boolean 
     */
    private
    function __renderPageviewImg()
    {
        foreach($this->pageviewURL as $url) {
            echo '<img src="' . $url . '" alt="" />';
        }
        return true;
    }

    /**
     * create CustomVar tracking URL
     * @return string CustomVar tracking URL
     */
    private
    function __createCustomVar()
    {
        $url = "";
        $name = "";
        $val = "";
        $scope = "";
        $emptyFlg  = false; // not set slot flag
        $scopeFlg  = false; // scope 3 flag
        foreach($this->CustomVars as $index => $CustomVar) {
            if(is_null($CustomVar)) {
                $emptyFlg = true;
                $scopeFlg = true;
                continue;
            }
            if(1 === $index) {
                $name .= $CustomVar['name'];
                $val .= $CustomVar['value'];
                if(3 !== $CustomVar['scope']) $scope .= $CustomVar['scope'];
            } else {
                $name .= ($emptyFlg) ? "*{$index}!" . urlencode($CustomVar['name']) : "*" . urlencode($CustomVar['name']);
                $val .= ($emptyFlg) ? "*{$index}!" . urlencode($CustomVar['value']) : "*" . urlencode($CustomVar['value']);
                if(3  === $CustomVar['scope']) {
                    $scopeFlg = true;
                } else {
                    $scope .= ($scopeFlg) ? "*{$index}!{$CustomVar['scope']}" : "*{$CustomVar['scope']}";
                }
            }
        }

        if(!empty($name)) $url .= "8({$name})";
        if(!empty($val)) $url .= "9({$val})";
        if(!empty($scope)) $url .= "11({$scope})";
        return $url;
    }

// private function }}} 

}
