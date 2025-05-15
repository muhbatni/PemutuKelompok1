<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class AuthFilter implements FilterInterface
{

  protected $userModel;
  private string $prefix = '/pemutu/public/';

  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  private array $guardedRoutes = [
    "akreditasi/unit" => '3',
    "akreditasi/isian-pemutu" => '3',
  ];

  public function before(RequestInterface $request, $arguments = null)
  {
    $accessToken = get_cookie('access_token');
    if (!isValidToken(token: $accessToken)) {
      $accessToken = refreshToken();
      if (!$accessToken) {
        return redirectWithMessage('login', 'error', 'Silahkan login terlebih dahulu!');
      }
    }
    $request->token = $accessToken;
    $token = getDecodedToken();
    $path = str_replace($this->prefix, '', $request->getUri()->getPath());
    if (isset($this->guardedRoutes[$path])) {
      if ($this->guardedRoutes[$path] !== $token->utype) {
        return redirectWithMessage('dashboard', 'error', 'Anda tidak memiliki akses ke halaman ini!');
      }
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // No action needed after the request
  }
}