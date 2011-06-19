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
     * @var array
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
     * Ecommerce tracking
     * @access private
     * @var array
     */
    private $transData = array();

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

	/**
     * Ecommerce tracking URL
     * @access private
     * @var array
     */
    private $tranItemURL = array();

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
		$this->__renderPageviewImg($this->pageviewURL);
        return true;
    }

    /**
     * Creates a transaction object
     *
     * @param string $orderId      order ID
     * @param string $affiliation  affiliation store
     * @param string $total        total price
     * @param string $tax          tax
     * @param string $shipping     shipping
     * @param string $city         city
     * @param string $state        state
     * @param string $country      country
     * @return boolean
     */
    function _addTrans($orderId, $affiliation, $total, $tax, $shipping, $city, $state, $country)
    {
        if(empty($orderId) OR empty($total)) return false;
        $this->transData[$orderId] = array(
            'affiliation' => $affiliation,
            'total'  => $total,
            'tax' => $tax,
            'shipping' => $shipping,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'items'  => array()
        );
        return true;
    }

    /**
     * set Item for transaction object
     *
     * @param string $orderId   order ID
     * @param string $sku       SKU code
     * @param string $name      Product name
     * @param string $category  Product category
     * @param string $price     Product price
     * @param string $quantity  Purchase quantity
     * @return boolean
     */
    function _addItem($orderId, $sku, $name, $category, $price, $quantity)
    {
        if(empty($sku) OR empty($price) OR empty($quantity)) return false;
        $this->transData[$orderId]['items'][] = array(
            'sku' => $sku,
            'name'  => $name,
            'category'  => $category,
            'price'  => $price,
            'quantity'  => $quantity
        );
        return true;
    }

    /**
     * render transaction tracking gif
     *
     * @return boolean
     */
    function _trackTrans()
    {
        if(is_null($this->account)) {
            echo 'Cannot tracking: Not set web property ID.<br />';
            return false;
        }

        $this->__createTranItemURL();
        $this->__renderPageviewImg($this->tranItemURL);
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

        if(!empty($CustomVarURL)) $url .= "&utme={$CustomVarURL}";
        $this->pageviewURL[]  = $url;
        return true;
    }
	
	/**
     * ka.php img Transaction URL create
     */
    private
    function __createTranItemURL()
    {
        $URLs = array();
        $url = "";
        $url .= "{$this->img_path}?utmac={$this->account}&guid=ON";
        $url .= "&utmn=" . rand(0, 0x7fffffff);
        if (true === $this->debug) $url .= "&utmdebug=ON";

        foreach($this->transData as $orderId => $event) {
            $tranURL  = "&utmt=tran&utmtid={$orderId}&utmtst=". urlencode($event['affiliation'])
                . "&utmtto={$event['total']}&utmttx={$event['tax']}&utmtsp={$event['shipping']}"
                . "&utmtci=". urlencode($event['city']) ."&utmtrg=". urlencode($event['state']) ."&utmtco=". urlencode($event['country']);
            $this->tranItemURL[] = $url . $tranURL;

            foreach($event['items'] as $item) {
                $itemURL = "&utmt=item&utmtid={$orderId}&utmipc=" . urlencode($item['sku'])
                  . "&utmipn=" . urlencode($item['name']) . "&utmiva=" . urlencode($item['category'])
                  . "&utmipr={$item['price']}&utmiqt={$item['quantity']}";
                $this->tranItemURL[] = $url . $itemURL;
            }
        }
        return true;
    }

    /**
     * ka.php img tag render
     *
     * @return boolean 
     */
    private
    function __renderPageviewImg($imgURL)
    {
        foreach($imgURL as $url) {
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
