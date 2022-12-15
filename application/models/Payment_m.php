<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_m extends CI_Model {

	public function paytm_init($slug='',$account_slug='',$type='admin'){
        $data = [];   
        $settings = settings(); 
        $u_info = get_all_user_info_slug($slug);
        $package = $this->admin_m->get_package_info_by_slug($account_slug);  
        $paytm = json_decode($settings['paytm_config']);
        $data['order_id'] = 'order_12389'.time();

        $is_paytm_live = 0;

        $environment = $paytm->is_paytm_live;
        if($environment==0){
            $data['url'] = 'https://securegw-stage.paytm.in';
        }else{
            $data['url'] = 'https://securegw.paytm.in';
        }

        if($type=='admin'){
        	$callback_url = base_url('payment/paytm_verify/?slug='.$u_info['username'].'&account_slug='.$package['slug'].'&key='.$paytm->merchant_key);
        }else{
        	$callback_url = "";
        }

        $params = array(
            'order_id' => $data['order_id'],
            'mid' => $paytm->merchant_id,
            'mik' => $paytm->merchant_key,
            'is_paytm_live' => $environment,
            'username' => $slug,
            'account_slug' => $account_slug,
            'callback_url' => $callback_url,
            'price' => $package['price'],
        );
        $token = $this->token($params);
        $data['token']=isset($token)?$token['body']['txnToken']:'';
        return $data;
    }

    public function token($data){

    /*
    * import checksum generation utility
    * You can get this utility from https://developer.paytm.com/docs/checksum/
    */
    require_once("vendor/paytm/paytmchecksum/PaytmChecksum.php");

    $paytmParams = array();

    $paytmParams["body"] = array(
        "requestType"  => "Payment",
        "mid"  => $data['mid'],
        "websiteName"  => "WEBSTAGING",
        "orderId"  => $data['order_id'],
        "callbackUrl"  => $data['callback_url'],
        "txnAmount"   => array(
            "value"   => $data['price'],
            "currency" => "INR",
        ),
        "userInfo"   => array(
            "custId"  => "CUST_001",
        ),
    );


    /*
    * Generate checksum by parameters we have in body
    * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys
    */
    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $data['mik']);

    $paytmParams["head"] = array(
        "signature" => $checksum
    );

    $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
    if($data['is_paytm_live']==0):
        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid={$data['mid']}&orderId={$data['order_id']}";
    else:
        /* for Production */
        $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid={$data['mid']}&orderId={$data['order_id']}";
    endif;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

    $response = curl_exec($ch);
    return json_decode($response,true);



}

public function mercado_init($slug,$account_slug){
	$data = [];
	$u_info = get_all_user_info_slug($slug);
	$package = $this->admin_m->get_package_info_by_slug($account_slug);
	$settings = settings();
	$mercado = !empty($settings['mercado_config'])?json_decode($settings['mercado_config']):'';

	MercadoPago\SDK::setAccessToken($mercado->access_token);
	$preference = new MercadoPago\Preference();

    // Create a preference item
	$item = new MercadoPago\Item();
	$item->title = $package['package_name'];
	$item->quantity = 1;
	$item->unit_price = $package['price'];
	$item->currency_id = get_currency('currency_code');
	$preference->items = array($item);
	$preference->back_urls = array(
		"success" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}"),
		"failure" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}"),
		"pending" => base_url("payment/mercado?slug={$slug}&account_slug={$account_slug}")
	);
	$preference->auto_return = "approved";

	$preference->save();
	$data['f_id'] = $preference->id;
	$data['init'] = $preference->init_point;
	return $data;
}

/*----------------------------------------------
    FLUTTERWAVE
----------------------------------------------*/
public function flutterwave_init(){
    $data = [];
    $settings = settings();
    $flutterwave = !empty($settings['flutterwave_config'])?json_decode($settings['flutterwave_config']):'';

    // Flutter Wave API endpoints for Sandbox & Live
    $data['sandbox'] = $flutterwave->is_flutterwave_live==1?FALSE:TRUE; //TRUE for Sandbox - FALSE for live environment

    // Flutter Wave API endpoints for Sandbox & Live
    $data['payment_endpoint'] = ($data['sandbox']) ? 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/hosted/pay' : 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/hosted/pay';
    $data['verify_endpoint'] = ($data['sandbox']) ? 'https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/v2/verify' : 'https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify';

    /* datauration stars from here */
    // Flutter Wave Credentials 
    $data['PBFPubKey'] = ($data['sandbox']) ? $flutterwave->fw_public_key : $flutterwave->fw_public_key; /* Public Key for Sandbox : Live */
    $data['SECKEY'] = ($data['sandbox']) ? $flutterwave->fw_secret_key : $flutterwave->fw_secret_key; /* Secret Key for Sandbox : Live */
    $data['encryption_key'] = ($data['sandbox']) ? $flutterwave->encryption_key  : $flutterwave->encryption_key; /* Encryption Key for Sandbox : Live */

    // Webhook Secret Hash 
    $data['secret_hash'] = ($data['sandbox']) ? 'TEST_SECRET_HASH' : 'LIVE_SECRET_HASH$'; /* Secret HASH for Sandbox : Live */

    // What is the default currency?
    // $data['currency'] = 'USD';  /* Store Currency Code */
    $data['currency'] = !empty(get_currency('currency_code'))?get_currency('currency_code'):'NGN';  /* Store Currency Code */

    // Transaction Prefix if any
    $data['txn_prefix'] = 'TXN_PREFIX';  /* Transaction ID Prefix if any */

    $data['payment_url'] = $data['payment_endpoint'];
    $data['verify_url'] = $data['verify_endpoint'];
    $data['PBFPubKey'] = $data['PBFPubKey'];
    $data['SECKEY'] = $data['SECKEY'];
    $data['currency'] = $data['currency'];
    $data['txn_prefix'] = $data['txn_prefix'];


    return $data;
}



function create_flutterwave_payment($data){
    $int = $this->flutterwave_init();
    $data['PBFPubKey'] = $int['PBFPubKey'];
    $data['currency'] = $int['currency'];
    $data['txref'] = (!empty($int['txn_prefix']))?$int['txn_prefix'].'-'.time().''.mt_rand() : time().''.mt_rand();
    $response = $this->curl_post($int['payment_url'], $data,TRUE);
    return $response;
}
    
function verify_transaction($reference){
    $int = $this->flutterwave_init();
    $data = array(
        "SECKEY" => $int['SECKEY'], 
        "txref" => $reference
    );
    $response = $this->curl_post($int['verify_url'], $data,TRUE);
    return $response;
}
    
function curl_post($url, $data,$json_encode_data = FALSE){

    $data = ($json_encode_data)?json_encode($data):'';

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "cache-control: no-cache"
        ],
    ));
    $response = curl_exec($curl);

    if($err = curl_error($curl)){
        curl_close($curl);
        return "CURL Error : ".$err;
    }else{
        curl_close($curl);
        return $response;
    }
}


}

/* End of file Payment_m.php */
/* Location: ./application/models/Payment_m.php */