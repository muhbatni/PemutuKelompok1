<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{

  public function register()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $postData = $this->request->getPost();
    $validation = service('validation');
    $userModel = new UserModel();
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
    if ($userModel->insert($data)) {
      return alert('login', 'success', 'Registrasi berhasil, silahkan login!');
    }
    return alert('registrasi', 'error', 'Registrasi gagal, silahkan coba lagi!');
  }

  public function login()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $postData = $this->request->getPost();
    $userModel = new UserModel();
    $data = ['username' => $postData['username'], 'password' => $postData['password']];
    $user = $userModel->where('username', $data['username'])->first();
    if (!$user) {
      return alert('login', 'error', 'Username atau password salah!');
    }
    $hashedPassword = $user['password'];
    if (password_verify($data['password'], $hashedPassword)) {
      session()->set([
        'user_id' => $user['id'],
        'user_type' => $user['tipe'],
        'user_avatar' => $user['foto'] ? pg_unescape_bytea($user['foto']) : null,
      ]);
      return alert('dashboard', 'success', 'Login berhasil!');
    }
    return alert('login', 'error', 'Username atau password salah!');
  }

  public function logout()
  {
    if (!session()->get('user_id')) {
      return alert('login', 'error', 'Anda belum login!');
    }
    session()->remove('user_id');
    session()->remove('user_type');
    if (session()->get('user_avatar')) {
      session()->remove('user_avatar');
    }
    return alert('login', 'success', 'Logout berhasil!');
  }
}