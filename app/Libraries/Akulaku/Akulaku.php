<?php 
namespace App\Libraries\Akulaku;
use GuzzleHttp\Exception\RequestException;
use \GuzzleHttp\Client as Client;

/**
* 
*/
class Akulaku
{
	private static $SANDBOX_URL ='https://testmall.akulaku.com';
	private static $API_URL ='https://mall.akulaku.com';
	private static $VERSION;
	
	function __construct()
	{
		Akulaku::$VERSION = config('akulaku.version','v2');
    }
    
    public function sign($content)
    {
        $app_id = $this->getAppid();
        $secret_key = $this->getSecretKey();
        $content = $app_id.$secret_key.$content;
        $sign = base64_encode(hash('sha512', $content, true)); return str_replace(array('+','/','='),array('-','_',''),$sign);
    }

    public function payloadsToContent($payloads)
    {
        $content = '';
        foreach($payloads as $payload){
            $content .= $payload;
        }

        return $content;
    }

	public function getAppid()
	{
		return config('akulaku.production',false)? config('akulaku.production_appid'):config('akulaku.development_appid');
    }

    public function getSecretKey()
    {
        return config('akulaku.production',false)? config('akulaku.production_secret'):config('akulaku.development_secret');
    }

	public function getUserAccount()
	{
		return config('akulaku.production',false)? config('akulaku.production_useraccount'):config('akulaku.development_useraccount');
    }

	public function getApiUrl()
	{
		return (config('akulaku.production',false)? Akulaku::$API_URL : Akulaku::$SANDBOX_URL);
	}

	public function getVersion()
	{
		return Akulaku::$VERSION;
	}

	public function getRelativeUrl($route)
	{
		return 'api/json/public/openpay/'.$route;
    }

	public function getPaymentUrl(string $refNo)
	{
        return $this->getApiUrl().'/'.$this->getVersion().'/openPay.html?appId='.$this->getAppid().'&refNo='.$refNo.'&sign='.$this->sign($refNo).'&lang=id';
    }
    
	public function getInstallmentInfo($skuid, $price)
	{
		$client=new Client([
			'base_uri'=>$this->getApiUrl(),
			'headers'=> [
				'Content-Type' =>	'application/json',
				'Accept' =>	'application/json'
			]
        ]);
        
		$payloads = [
			'skuId' => $skuid,
            'price'=> $price,
            'qty' => '1',
            'version'=>1
        ];
        
        $payloads['sign'] = $this->sign($this->payloadsToContent($payloads));
        $payloads['appId'] = $this->getAppid();
                            
		$response = $client->request('GET', $this->getRelativeUrl('installment/info/get.do'), [ 'form_params' => $payloads ]);
		return collect(json_decode($response->getBody()));
    }
    
    public function generateOrder(array $payloads)
	{
        $client=new Client([
			'base_uri'=>$this->getApiUrl(),
			'headers'=> [
				'Content-Type' =>	'application/json',
				'Accept' =>	'application/json'
			]
        ]);
        
        $payloads['sign'] = $this->sign($this->payloadsToContent($payloads));
        $payloads['appId'] = $this->getAppid();
        
        $response = $client->request('POST', $this->getRelativeUrl('new.do'), [ 'form_params' => $payloads ]);
		return collect(json_decode($response->getBody()));
	}

	public function confirmReceipt(string $transaction_invoice_number)
	{
		$client=new Client([
			'base_uri'=>$this->getApiUrl(),
			'headers'=> [
				'Content-Type' =>	'application/json',
				'Accept' =>	'application/json'
			]
        ]);
        
		$payloads = [
			'refNo'=> $transaction_invoice_number
        ];
        
        $payloads['sign'] = $this->sign($this->payloadsToContent($payloads));
        $payloads['appId'] = $this->getAppid();

		$response = $client->request('POST', $this->getRelativeUrl('order/receipt.do'), [ 'form_params' => $payloads ]);
		return collect(json_decode($response->getBody()));
	}

	public function inquiryStatus(string $transaction_invoice_number)
	{
		$client=new Client([
			'base_uri'=>$this->getApiUrl(),
			'headers'=> [
				'Content-Type' =>	'application/json',
				'Accept' =>	'application/json'
			]
        ]);
        
		$payloads = [
			'refNo' => $transaction_invoice_number
        ];
        
        $payloads['sign'] = $this->sign($this->payloadsToContent($payloads));
        $payloads['appId'] = $this->getAppid();

		$response = $client->request('GET', $this->getRelativeUrl('status.do'), [ 'form_params' => $payloads ]);
		return collect(json_decode($response->getBody()));
	}

	/* This method for sandbox only */
	public function changeStatus(string $transaction_invoice_number, $status)
	{
		$client=new Client([
			'base_uri'=>$this->getApiUrl(),
			'headers'=> [
				'Content-Type' =>	'application/json',
				'Accept' =>	'application/json'
			]
        ]);
        
		$payloads = [
			'refNo' => $transaction_invoice_number,
			'status' => $status
        ];
        
        $payloads['sign'] = $this->sign($this->payloadsToContent($payloads));
        $payloads['appId'] = $this->getAppid();

		$response = $client->request('POST', $this->getRelativeUrl('test/status/change.do'), [ 'form_params' => $payloads ]);
		return collect(json_decode($response->getBody()));
	}

}