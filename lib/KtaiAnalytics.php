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

        if(!empty($this->pageTitle)) $url .= "&utmdt=" . urlencode($this->pageTitle);
        //$url .= "&utmdt=" . urlencode("mobile|test2");

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

// private function }}} 

}
