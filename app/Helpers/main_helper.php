<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

function getDatabyToken()
{
  helper('cookie');
  $token = get_cookie('access_token');
  try {
    return JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
  } catch (ExpiredException $e) {
    return null;
  }
}

function isValidRefreshToken($model, $id)
{
  helper('cookie');
  $token = get_cookie('refresh_token');
  if ($token === null) {
    return false;
  }
  try {
    JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
    return true;
  } catch (ExpiredException $e) {
    return false;
  }
}

function alert($redirectPath, $type, $message)
{
  return redirect()->to(base_url('public/' . $redirectPath))->with($type, $message);
}

?>