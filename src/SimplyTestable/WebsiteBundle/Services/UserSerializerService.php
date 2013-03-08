<?php
namespace SimplyTestable\WebsiteBundle\Services;

use SimplyTestable\WebsiteBundle\Model\User;

class UserSerializerService {    
    
    /**
     *
     * @var string
     */
    private $surrogateKey;  
    
    
    /**
     *
     * @var string
     */
    private $iv;
    
    
    /**
     *
     * @var string
     */
    private $key;
    
    
    /**
     * 
     * @param string $key
     */
    public function __construct($key) {
        $this->key = md5($key);
    }    
    
    
    public function serialize(User $user) {        
        return array(
            'username' => $this->encrypt($user->getUsername(), $this->getSurrogateKey()),
            'password' => $this->encrypt($user->getPassword(), $this->getSurrogateKey()),
            'key' => $this->encrypt($this->getSurrogateKey(), $this->key),
            'iv' => $this->getIv(),
        );
        
    }
    
    
    /**
     * 
     * @param array $serializedUser
     * @return \SimplyTestable\WebsiteBundle\Model\User
     */
    public function unserialize($serializedUser) {
        $this->iv = $serializedUser['iv'];
        $this->surrogateKey = $this->decrypt($serializedUser['key'], $this->key);
        
        $user = new User();
        $user->setUsername(trim($this->decrypt($serializedUser['username'], $this->getSurrogateKey())));        
        $user->setPassword(trim($this->decrypt($serializedUser['password'], $this->getSurrogateKey())));
        
        return $user;
    }
    
    
    /**
     * 
     * @param string $user
     * @return \SimplyTestable\WebClientBundle\Model\User
     */
    public function unserializedFromString($user) {        
        $base64EncodedUserValues = json_decode(base64_decode($user), true);        
        if (!is_array($base64EncodedUserValues)) {
            return null;
        }
        
        if (!count($base64EncodedUserValues)) {
            return null;
        }
        
        $expectedKeys = array('username', 'password', 'key', 'iv');
        foreach  ($expectedKeys as $expectedKey) {
            if (!isset($base64EncodedUserValues[$expectedKey])) {
                return null;
            }
        }
        
        $userValues = array();
        
        foreach ($base64EncodedUserValues as $key => $value) {            
            $base64DecodedValue = base64_decode($value);
            if ($base64DecodedValue == '') {
                return null;
            }
            
            $userValues[$key] = $base64DecodedValue;
        }
        
        return $this->unserialize($userValues);        
    }    
    
    
    /**
     * 
     * @return string
     */
    private function getSurrogateKey() {
        if (is_null($this->surrogateKey)) {
            $this->surrogateKey = md5(rand());
        }
        
        return $this->surrogateKey;
    }
    
    
    /**
     * 
     * @param string $plaintext
     * @param string $key
     * @return string
     */
    private function encrypt($plaintext, $key) {        
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $plaintext, MCRYPT_MODE_ECB, $this->getIv());        
    }
    
    
    /**
     * 
     * @param string $ciphertext
     * @param string $key
     * @return strings
     */
    private function decrypt($ciphertext, $key) {        
        return mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $key, $ciphertext, MCRYPT_MODE_ECB, $this->getIv());
    }
    
    
    /**
     * 
     * @return int
     */
    private function getIvSize() {
        return mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    }
    
    
    /**
     * 
     * @return string
     */
    private function getIv() {
        if (is_null($this->iv)) {
            $this->iv = mcrypt_create_iv($this->getIvSize(), MCRYPT_RAND);
        }
        
        return $this->iv;
    }
    
}