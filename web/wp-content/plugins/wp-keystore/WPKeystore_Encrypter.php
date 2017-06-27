<?php

class WPKeystore_Encrypter {
  const METHOD = 'aes-256-cbc';
  const IV_LENGTH = 16;

  public static function encrypt($value) {
    return openssl_encrypt($value, self::METHOD, AUTH_KEY, 0, self::getIV());
  }

  public static function decrypt($value) {
    return openssl_decrypt($value, self::METHOD, AUTH_KEY, 0, self::getIV());
  }

  private static function getIV() {
    return substr(AUTH_SALT, 0, self::IV_LENGTH);
  }
}
