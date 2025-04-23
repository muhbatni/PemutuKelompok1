<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Cookie\CookieInterface;
use Exception;


class AuthFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {
    helper('cookie');
    try {
      $accessToken = get_cookie('access_token');
      if (!$accessToken) {
        return alert('login', 'error', 'Silahkan login terlebih dahulu!');
      }
      $decoded = JWT::decode($accessToken, new Key(getenv('JWT_SECRET'), 'HS256'));
      $request->user = $decoded;
    } catch (Exception $exception) {
      $refreshToken = get_cookie('refresh_token') ?? null;
      if (!$refreshToken) {
        return alert('login', 'error', 'Refresh token is required');
      }
      $refreshDecoded = JWT::decode($refreshToken, new Key(getenv('JWT_SECRET'), 'HS256'));
      if ($refreshDecoded->type !== 'refresh') {
        return alert('login', 'error', message: 'Invalid refresh token type');
      }
      if (!isset($refreshDecoded->uid)) {
        return alert('login', 'error', 'Invalid refresh token data');
      }
      // Issue new access token
      $now = time();
      $newAccessExp = $now + 3600;
      $newAccessPayload = [
        'iat' => $now,
        'exp' => $newAccessExp, // 1 hour
        'uid' => $refreshDecoded->uid
      ];
      $newAccessToken = JWT::encode($newAccessPayload, getenv('JWT_SECRET'), 'HS256');
      set_cookie('access_token', $newAccessToken, $newAccessExp, '', '/', '', false, false, CookieInterface::SAMESITE_LAX);
      $request->user = $refreshDecoded;
      echo "<script>console.log('refresh cookie');</script>";
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // No action needed after the request
  }
}