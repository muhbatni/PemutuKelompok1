<?php
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use CodeIgniter\Cookie\CookieInterface;

function getDecodedToken()
{
  $request = service('request');
  if (!isset($request->token)) {
    return null;
  }
  $token = $request->token;
  try {
    $decoded = JWT::decode($token, config('Pemutu')->myConfig['jwt_secret']);
    return $decoded;
  } catch (Exception $exception) {
    return null;
  }
}

function isValidToken($token)
{
  if (!$token) {
    return null;
  }
  try {
    return JWT::decode($token, config('Pemutu')->myConfig['jwt_secret']);
  } catch (ExpiredException $exception) {
    return null;
  }
}


function refreshToken()
{
  $refreshToken = get_cookie('refresh_token') ?? null;
  if (!$refreshToken) {
    return null;
  }
  try {
    $refreshDecoded = JWT::decode($refreshToken, config('Pemutu')->myConfig['jwt_secret']);
    if ($refreshDecoded->type !== 'refresh') {
      return null;
    }
    if (!isset($refreshDecoded->uid)) {
      return null;
    }
    $now = time();
    $newAccessExp = $now + 3600;
    $newAccessPayload = [
      'iat' => $now,
      'exp' => $newAccessExp,
      'uid' => $refreshDecoded->uid,
      'utype' => $refreshDecoded->utype
    ];
    $newAccessToken = JWT::encode($newAccessPayload, getenv('JWT_SECRET'), 'HS256');
    set_cookie('access_token', $newAccessToken, $newAccessExp, '', '/', '', false, false, CookieInterface::SAMESITE_LAX);
    return $newAccessToken;
  } catch (Exception $exception) {
    redirectWithMessage('login', 'error', 'Masa akun anda sudah habis, silahkan login terlebih lagi!');
    return null;
  }
}
?>