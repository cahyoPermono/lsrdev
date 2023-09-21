<?php

namespace App\Helpers;

class Crypto
{
     const METHOD = 'aes-256-ctr';

     /**
      * Encrypts (but does not authenticate) a message
      * 
      * @param string $message - plaintext message
      * @return string (raw binary)
      */
     public static function encrypt($message)
     {
          $nonceSize = openssl_cipher_iv_length(self::METHOD);
          $nonce = openssl_random_pseudo_bytes($nonceSize);

          $ciphertext = openssl_encrypt(
               $message,
               self::METHOD,
               self::key(),
               OPENSSL_RAW_DATA,
               $nonce
          );

          return base64_encode($nonce . $ciphertext);
     }

     /**
      * Decrypts (but does not verify) a message
      * 
      * @param string $message - ciphertext message
      * @return string
      */
     public static function decrypt($message)
     {
          $message = base64_decode($message, true);
          if ($message === false) {
               throw new \Exception('Encryption failure');
          }

          $nonceSize = openssl_cipher_iv_length(self::METHOD);
          $nonce = mb_substr($message, 0, $nonceSize, '8bit');
          $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

          $plaintext = openssl_decrypt(
               $ciphertext,
               self::METHOD,
               self::key(),
               OPENSSL_RAW_DATA,
               $nonce
          );

          return $plaintext;
     }

     private static function key()
     {
          return config('app.key');
     }
}
