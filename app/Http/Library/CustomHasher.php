<?php

namespace App\Http\Library;

use RuntimeException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CustomHasher implements HasherContract
{
	public function __construct(){

		$this->Mage = \Magento::getInstance();
	}

    public function make($value, array $options = [])
	{
        $salt = $this->Mage->helper('core')->getRandomString(32);

        return $salt === false ? $this->Mage->getModel('core/encryption')->hash($value) : $this->Mage->getModel('core/encryption')->hash($salt . $value) . ':' . $salt;
	}

    public function check($value, $hashedValue, array $options = [])
    {

		if (strlen($hashedValue) === 0) {
			return false;
		}

		$hashArr = explode(':',$hashedValue);

        switch (count($hashArr)) {
            case 1:
				return $this->Mage->getModel('core/encryption')->hash($value) === $hashedValue;
            case 2:
                return $this->Mage->getModel('core/encryption')->hash($hashArr[1] . $value) === $hashArr[0];
        }
		
		return 'Invalid hash';
	}    

    public function needsRehash($hashedValue, array $options = []) {}
}