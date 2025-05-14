<?php 
/**
 * Copyright 2020 HonqphucIT <honqphucit@gmail.com>
 *
 * Zalo: https://zalo.me/hongphucit
 */

class Facebook 
{
	const VERSION = '1.0.0';

	protected $response = array();

	public function __construct($uid = NULL)
	{
	    if(!$uid) {
	    	exit;
	    } else {

	    	if(is_numeric($uid)) {

	    		$this->checkUID($uid);

	    	} else {
	    		exit;
	    	}

	    }
	}

	public function __destruct()
	{
		if(count($this->response) > 0){
			try {
				header('Content-Type: application/json');
				echo json_encode(array('result' => $this->response));
				exit;
			} catch (Exception $e) {
				// noop
			}
		}
	}

	public function checkUID($uid)
	{

		$response 	= $this->cURL('https://graph.facebook.com/'.$uid.'?fields=picture');
		$result		= json_decode($response, TRUE);

		if(isset($result['error'])){
			$this->response[] = array('status' => 'die');
		} else {
			$this->response[] = array('status' => 'live');
		}
	}

	public function cURL($url){
	    $data = curl_init();
	    curl_setopt($data, CURLOPT_RETURNTRANSFER,1);
	    curl_setopt($data, CURLOPT_URL, $url);
	    $result = curl_exec($data);
	    curl_close($data);
	    return $result;
	}
}