<?php

abstract class YPoolCurrencies
{
    const BITCOIN = "BTC";
    const LITECOIN = "BTC";
    const DOGECOIN = "DOGE";
    const PRIMECOIN = "XPM";
    const RIECOIN = "RIC";
    const BITSHARESPTS = "PTS";
    const PEERCOIN = "PPC";
}

class YPoolWallet
{
	private $apiKey;
	private $secret;

	public function __construct( $apiKey, $secret ) {
        $this->apiKey = $apiKey;
        $this->secret = $secret;
    }

    public function getBalance($currency) {
    	$hash = sha1("{$this->secret}_getbalance_{$this->apiKey}_{$currency}_{$this->secret}");
    	$call = "getbalance?key={$this->apiKey}&currency={$currency}&hash={$hash}";
    	return $this->sendRequest($call);
    }   

    public function sendCoins($currency,$targetAddress,$amount,$privateNote="") {
		$call;
    	if( func_num_args() > 4 && !empty(func_get_arg(4)) ) {
    		$token = (string)func_get_arg(4);
            if( empty($privateNote) ) {
        		$hash = sha1("{$this->secret}_sendcoins_{$this->apiKey}_{$currency}_{$targetAddress}_{$amount}_{$token}_{$this->secret}");
        		$call = "sendcoins?key={$this->apiKey}&currency={$currency}&address={$targetAddress}&amount={$amount}&token={$token}&hash={$hash}";
            }
            else {
                $hash = sha1("{$this->secret}_sendcoins_{$this->apiKey}_{$currency}_{$targetAddress}_{$amount}_{$privateNote}_{$token}_{$this->secret}");
                $call = "sendcoins?key={$this->apiKey}&currency={$currency}&address={$targetAddress}&amount={$amount}&note={$privateNote}&token={$token}&hash={$hash}";
            }
    	}
    	else {
            if( empty($privateNote) ) {
                $hash = sha1("{$this->secret}_sendcoins_{$this->apiKey}_{$currency}_{$targetAddress}_{$amount}_{$this->secret}");
                $call = "sendcoins?key={$this->apiKey}&currency={$currency}&address={$targetAddress}&amount={$amount}&hash={$hash}";
            }
            else {
                $hash = sha1("{$this->secret}_sendcoins_{$this->apiKey}_{$currency}_{$targetAddress}_{$amount}_{$privateNote}_{$this->secret}");
                $call = "sendcoins?key={$this->apiKey}&currency={$currency}&address={$targetAddress}&amount={$amount}&note={$privateNote}&hash={$hash}";
            }
    	}
    	return $this->sendRequest($call);
    }   

    public function getAddresses($currency) {
    	$hash = sha1("{$this->secret}_getaddresses_{$this->apiKey}_{$currency}_{$this->secret}");
    	$call = "getaddresses?key={$this->apiKey}&currency={$currency}&hash={$hash}";
    	return $this->sendRequest($call);
    }  

    public function generateAddress($currency) {
    	$call;
    	if( func_num_args() > 1 ) {
    		$token = (string)func_get_arg(1);
    		$hash = sha1("{$this->secret}_generateaddress_{$this->apiKey}_{$currency}_{$token}_{$this->secret}");
    		$call = "generateaddress?key={$this->apiKey}&currency={$currency}&token={$token}&hash={$hash}";
    	}
    	else {
    		$hash = sha1("{$this->secret}_generateaddress_{$this->apiKey}_{$currency}_{$this->secret}");
    		$call = "generateaddress?key={$this->apiKey}&currency={$currency}&hash={$hash}";
    	}
    	return $this->sendRequest($call);
    }   

    public function checkTransaction($txId, $historyId = false) {
    	$hash = sha1("{$this->secret}_checktransaction_{$this->apiKey}_{$txId}_{$this->secret}");
    	$call;
    	if( $historyId === true )
    		$call = "checktransaction?key={$this->apiKey}&historyId={$txId}&hash={$hash}";
    	else
    		$call = "checktransaction?key={$this->apiKey}&txId={$txId}&hash={$hash}";    		
    	return $this->sendRequest($call);
    } 

    public function checkAddressStatistic($currency,$address) {
    	$hash = sha1("{$this->secret}_checkaddressstatistic_{$this->apiKey}_{$currency}_{$address}_{$this->secret}");
    	$call = "checkaddressstatistic?key={$this->apiKey}&currency={$currency}&address={$address}&hash={$hash}";	
    	return $this->sendRequest($call);
    } 

    private function sendRequest($call) {
    	$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => "https://wallet.ypool.net/api/{$call}"
		));
		$resp = curl_exec($curl);
		curl_close($curl);
		return json_decode($resp);
    }
}

?>
