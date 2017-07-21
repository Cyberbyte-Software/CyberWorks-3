<?php
/**
 * Created by PhpStorm.
 * Author: https://github.com/Siprah/IPSConnect-Client
 * Date: 25/06/2017
 * Time: 23:29
 */

namespace CyberWorks\Core\Auth;

class IPSSlave
{
    protected $IPS_MASTER_URL;
    protected $IPS_BASE_URL;
    protected $IPS_MASTER_KEY;
    protected $IPS_API_KEY;


    function __construct( $masterUrl, $masterKey, $baseUrl, $apiKey)
    {
        $this->IPS_MASTER_URL = $masterUrl;
        $this->IPS_MASTER_KEY = $masterKey;
        $this->IPS_BASE_URL = $baseUrl;
        $this->IPS_API_KEY = $apiKey;
    }

    /**
     * Connect to the Master
     * @param Array - Query string with parameters
     * @return Object - Request's response
     */
    public function doRequest($params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->IPS_MASTER_URL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    /**
     * Connect to the Master
     * @param Array - Query string with parameters
     * @return Object - Request's response
     */
    public function doGetRequest($endPoint)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->IPS_BASE_URL . $endPoint);
        curl_setopt($ch,CURLOPT_HTTPAUTH	, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->IPS_API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    public function doPostRequest($params, $endPoint)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->IPS_BASE_URL . $endPoint);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params) );
        curl_setopt($ch,CURLOPT_HTTPAUTH	, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->IPS_API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result);
    }

    /**
     * Get salt of user.
     * @param String - Username or Email
     * @param Integer - Type of value from first variable. 1 - Username, 2 - Email, 3 - Undefined. Default: 3.
     * @return Boolean
     */
    public function fetchSalt($username, $idType=3)
    {
        $params = [
            'do' => 'fetchSalt',
            'id' => $username,
            'idType' => $idType,
            'key' => md5( $this->IPS_MASTER_KEY . $username )
        ];

        $req = $this->doRequest($params);

        if(!$req || $req->status != "SUCCESS")
            return false;

        return $req->pass_salt;
    }

    /**
     * Hash password using plaintext and salt.
     * @param String - Password in plaintext
     * @param String - Salt
     * @return String - Hashed passowrd
     */
    public function makePassword($password, $salt)
    {
        return crypt( $password, '$2a$13$' . $salt );
    }

    /**
     * Check login credentials are valid
     * @param String - Username or Email
     * @param String - Password
     * @param Integer - Type of value from first variable. 1 - Username, 2 - Email, 3 - Undefined. Default: 3.
     * @return Boolean
     */
    public function attempt($username, $password, $idType=3)
    {
        $salt = $this->fetchSalt($username, $idType);
        $hash = $this->makePassword($password, $salt);

        $params = [
            'do' => 'login',
            'id' => $username,
            'idType' => $idType,
            'password' => $hash,
            'key' => md5( $this->IPS_MASTER_KEY . $username )
        ];

        $req = $this->doRequest($params);

        if(!$req || $req->status != "SUCCESS")
            return false;

        return $req;
    }
}