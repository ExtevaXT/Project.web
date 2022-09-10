<?php

namespace App\Libs\CustomHash;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Hashing\AbstractHasher;

class Sha1Hasher extends AbstractHasher implements HasherContract {

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @return string   $options
     * @return string
     */
    public function make($value, array $options = []) {
        //I have custom encoding / encryption here//
        //Define your custom hashing logic here//

        return strtoupper(hash_pbkdf2('sha1', $value, 'at_least_16_byte_with_login', 10000, 40));
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = array()) {
        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array()) {
        return false;
    }

}



