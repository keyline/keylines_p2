<?php
namespace App\Libraries;
use App\Models\CommonModel;
/*namespace Firebase\JWT;
use \DomainException;
use \InvalidArgumentException;
use \UnexpectedValueException;
use \DateTime;*/
/**
 * JSON Web Token implementation, based on this spec:
 * https://tools.ietf.org/html/rfc7519
 *
 * PHP version 5
 *
 * @category Authentication
 * @package  Authentication_JWT
 * @author   Neuman Vong <neuman@twilio.com>
 * @author   Anant Narayanan <anant@php.net>
 * @license  http://opensource.org/licenses/BSD-3-Clause 3-clause BSD
 * @link     https://github.com/firebase/php-jwt
 */
class Pro {

	PRIVATE $secret_key;
	PRIVATE  $secret_iv;
	PRIVATE  $encrypt_method;
	
	function __construct(){
		/* $this->secret_key = '435TxF3Y24Mb53lo245QMx93';
		$this->secret_iv = 'FY&HRFH88TH896JH2';	 */
		$this->common_model         = new CommonModel;
		$application_settings   	= $this->common_model->find_data('application_settings','row');

		$this->secret_key 			= $application_settings->encryption_api_secret_key;
		$this->secret_iv 			= $application_settings->encryption_api_secret_iv;
		$this->encrypt_method 		= $application_settings->encryption_api_encrypt_method;
	}
	
    function encrypt($message){
        $output = false;
        $output = openssl_encrypt($message, $this->encrypt_method, $this->secret_key, 0, $this->secret_iv);
        return $output; 
    }
	
	function decrypt($message){
        $output = false;
        $output = openssl_decrypt($message, $this->encrypt_method, $this->secret_key, 0, $this->secret_iv);
        return $output; 
    }
	
	function encryptall($data){
        $output = false;
       	$newarray=array();
		foreach($data as $keyy=>$val){
			$output = openssl_encrypt($val, $this->encrypt_method, $this->secret_key, 0, $this->secret_iv);
			//$output = base64_encode($output); 
			$newarray[$keyy]=$output;
			}
			return $newarray; 
	}
	function decryptall($data){   
        $output = false;
       	foreach($data as $keyy=>$val){
			$output = openssl_decrypt($val, $this->encrypt_method,$this->secret_key, 0, $this->secret_iv);
			$newarray[$keyy]=$output;
		}
        return $newarray; 
    }
	function encrypt_decrypt($action, $string) {
		$output = false;
		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $this->encrypt_method, $this->secret_key, 0, $this->secret_iv);
			//$output = base64_encode($output);
		} else if( $action == 'decrypt' ) {
			$output = openssl_decrypt($string, $this->encrypt_method, $this->secret_key, 0, $this->secret_iv);
		}
		return $output;
	}
}
?>