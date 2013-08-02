<?php

class authenticationFilter extends sfFilter
{
  public function execute ($filterChain)
  {
    $authentication = new authentication();
    $authentication->checkAuthentication();

    $filterChain->execute();
  }
}
