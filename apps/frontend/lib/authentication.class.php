<?php

class authentication
{
  function __construct()
  {
  }
  
  public function checkAuthentication ()
  {
    if (!isset($_SERVER['PHP_AUTH_USER']))
    {
      $this->sendHeadersAndExit();
    }
    if (!($_SERVER['PHP_AUTH_USER'] == sfConfig::get('app_auth_username') && $_SERVER['PHP_AUTH_PW'] == sfConfig::get('app_auth_password')))
    {
      $this->sendHeadersAndExit();
    }
  }
 
  private function sendHeadersAndExit ()
  {
    header('WWW-Authenticate: Basic realm="' . sfConfig::get('app_auth_realm') . '"');
    header('HTTP/1.0 401 Unauthorized');
    exit;
  }
}