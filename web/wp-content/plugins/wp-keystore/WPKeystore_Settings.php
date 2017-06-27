<?php

include 'WPKeystore_Encrypter.php';

class WPKeystore_Settings {
  const OPTION_KEY = 'wpkeystore-keystore';
  const DEFAULT = array();

  private $keys;

  public function __construct() {
    $this->keys = self::get();
  }

  private static function get() {
    $opts = get_option(self::OPTION_KEY, self::DEFAULT);

    foreach ($opts as &$opt) {
      $opt = self::decrypt($opt);
    };

    return $opts;
  }

  public function add($name, $key) {
    $this->keys[$name] = $key;
    $this->save();
  }

  private function save() {
    $toSave = [];
    foreach ($this->keys as $name => $key) {
      $toSave[$name] = self::encrypt($key);
    }
    update_option(self::OPTION_KEY, $toSave);
  }

  public function delete($name) {
    unset($this->keys[$name]);
    $this->save();
  }

  public function remove($name) {
    $this->delete($name);
  }

  public static function asArray() {
    $keys = self::get();

    foreach ($keys as $name => $key) {
      $keys[$name] = self::clean($key);
    }

    return $keys;
  }

  public function toGlobals() {
    foreach ($this->keys as $name => $key) {
      if (!defined($name)) { // don't allow overriding of wp-settings.php
        define($name, $key);
      }
    }
  }

  private static function clean($value) {
    $first = $value[0];
    $last = substr($value, -3);
    $numMiddle = strlen($value) - 4;

    return $first . str_repeat('X', $numMiddle) . $last;
  }

  private static function encrypt($value) {
    return WPKeystore_Encrypter::encrypt($value);
  }

  private static function decrypt($value) {
    return WPKeystore_Encrypter::decrypt($value);
  }
}
