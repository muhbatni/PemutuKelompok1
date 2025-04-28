<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    $accessToken = get_cookie('access_token');
    if (!isValidToken($accessToken)) {
      $accessToken = refreshToken();
      if (!$accessToken) {
        return redirectWithMessage('login', 'error', 'Silahkan login terlebih dahulu!');
      }
      $_COOKIE['access_token'] = $accessToken;
    }
    $request->token = $accessToken;
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // No action needed after the request
  }
}