<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use CodeIgniter\Cookie\CookieInterface;
function getDatabyToken()
{
  $request = service('request');
  if (!isset($request->token)) {
    return null;
  }
  $token = $request->token;
  try {
    $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
    return $decoded;
  } catch (Exception $exception) {
    return null;
  }
}

function isValidToken($token)
{
  try {
    JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
    return true;
  } catch (ExpiredException $exception) {
    return false;
  }
}


function refreshToken()
{
  $refreshToken = get_cookie('refresh_token') ?? null;
  if (!$refreshToken) {
    alert('login', 'error', 'Refresh token is required');
    return false;
  }
  $refreshDecoded = JWT::decode($refreshToken, new Key(getenv('JWT_SECRET'), 'HS256'));
  if (!$refreshDecoded) {
    alert('login', 'error', 'Your data is expired, please signin again!');
    return false;
  }
  if ($refreshDecoded->type !== 'refresh') {
    alert('login', 'error', 'Invalid refresh token type');
    return false;
  }
  if (!isset($refreshDecoded->uid)) {
    alert('login', 'error', 'Invalid refresh token data');
    return false;
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
  return $newAccessToken;
}
?>