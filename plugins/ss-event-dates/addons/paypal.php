<?php
/**
* 
*/
class PaypalPayment{
    public function __construct($config = "") {
     
        //default settings
        $settings = array(
            'business' => 'riob-facilitator@softwareseni.com', //paypal email address
            'currency' => 'US$', //paypal currency
            'cursymbol' => '$', //currency symbol
            'location' => 'IDN', //location code (ex GB)
            'returnurl' => 'http://www.iufroacacia2017.com/myreturnpage', //where to go back when the transaction is done.
            'returntxt' => 'Return to My Site', //What is written on the return button in paypal
            'cancelurl' => 'http://www.iufroacacia2017.com/mycancelpage', //Where to go if the user cancels.
            'shipping' => 0, //Shipping Cost
            'custom' => '' //Custom attribute
        );
     
        //overrride default settings
        if (!empty($config)) {
            foreach ($config as $key => $val) {
                if (!empty($val)) {
                    $settings[$key] = $val;
                }
            }
        }
     
        //Set the class attributes
        $this->business = $settings['business'];
        $this->currency = $settings['currency'];
        $this->cursymbol = $settings['cursymbol'];
        $this->location = $settings['location'];
        $this->returnurl = $settings['returnurl'];
        $this->returntxt = $settings['returntxt'];
        $this->cancelurl = $settings['cancelurl'];
        $this->shipping = $settings['shipping'];
        $this->custom = $settings['custom'];
        $this->items = array();
    }


    //=========================================//
    //==> Add an array of items to the cart <==//
    //=========================================//
    public function addMultipleItems($items) {
        if (!empty($items)) {
            foreach ($items as $item) { //lopp through the items
                $this->addSimpleItem($item); //And add them 1 by 1
            }
        }
    }
     
    //=====================================//
    //==> Add a simple item to the cart <==//
    //=====================================//
    public function addSimpleItem($item) {
        if (
                !empty($item['quantity'])
                && is_numeric($item['quantity'])
                && $item['quantity'] > 0
                && !empty($item['name'])
        ) { //And add the item to the cart if it is correct
            $items = $this->items;
            $items[] = $item;
            $this->items = $items;
        }
    }


}
    
?>

