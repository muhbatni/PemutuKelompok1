<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use App\Models\UserModel;
use CodeIgniter\Cookie\CookieInterface;

class Auth extends BaseController
{
  protected $userModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
  }
  public function register()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $postData = $this->request->getPost();
    $validation = service('validation');
    $hashedPassword = password_hash($postData['password'], PASSWORD_DEFAULT);
    $data = [
      'username' => $postData['username'],
      'password' => $hashedPassword,
      'tipe' => $postData['tipe']
    ];
    if (!$this->validate('signup')) {
      return view(
        'registrasi/index',
        ['errors' => $validation->getErrors(), 'old' => $postData]
      );
    }
    if ($this->userModel->insert($data)) {
      return redirectWithMessage('login', 'success', 'Registrasi berhasil, silahkan login!');
    }
    return redirectWithMessage('registrasi', 'error', 'Registrasi gagal, silahkan coba lagi!');
  }

  public function login()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $postData = $this->request->getPost();
    $data = ['username' => $postData['username'], 'password' => $postData['password']];
    $user = $this->userModel->where('username', $data['username'])->first();
    if (!$user) {
      return redirectWithMessage('login', 'error', 'Username atau password salah!');
    }
    $hashedPassword = $user['password'];
    if (!password_verify($data['password'], $hashedPassword)) {
      return redirectWithMessage('login', 'error', 'Username atau password salah!');
    }
    $issuedAt = time();
    $accessTokenExp = $issuedAt + 3600; // 1 hour
    $refreshTokenExp = $issuedAt + 604800; // 7 days

    $accessPayload = [
      'iat' => $issuedAt,
      'exp' => $accessTokenExp,
      'uid' => $user['id'],
    ];

    $refreshPayload = [
      'iat' => $issuedAt,
      'exp' => $refreshTokenExp,
      'uid' => $user['id'],
      'type' => 'refresh'
    ];

    $secretKey = getenv('JWT_SECRET');
    $accessToken = JWT::encode($accessPayload, $secretKey, 'HS256');
    $refreshToken = JWT::encode($refreshPayload, $secretKey, 'HS256');
    $userAvatar = $user['foto'];
    if ($userAvatar) {
      if (cache()->get("avatar_{$user['id']}")) {
        cache()->delete("avatar_{$user['id']}");
      }
      $image = pg_unescape_bytea($userAvatar);
      cache()->save("avatar_{$user['id']}", $image, 3600);
    }
    set_cookie('access_token', $accessToken, $accessTokenExp, '', '/', '', false, false, CookieInterface::SAMESITE_LAX);
    set_cookie('refresh_token', $refreshToken, $refreshTokenExp, '', '/', '', false, false, CookieInterface::SAMESITE_LAX);
    return redirectWithMessage('dashboard', 'success', 'Login berhasil!')->withCookies();
  }

  public function logout()
  {
    delete_cookie('access_token');
    delete_cookie('refresh_token');
    return redirectWithMessage('login', 'success', 'Logout berhasil!')->withCookies();
  }
}