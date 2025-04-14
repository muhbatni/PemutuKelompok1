<?php

namespace App\Controllers;

use App\Models\UserModel; // Ensure you have a UserModel for database interaction

class Auth extends BaseController
{
  public function register()
  {
    $userModel = new UserModel();
    $data = [
      'username' => $this->request->getPost('username'),
      'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
      'tipe' => $this->request->getPost('tipe'),
    ];

    if ($userModel->insert($data)) {
      return redirect()->to(base_url('public/login'))->with('success', 'Registrasi berhasil!');
    } else {
      return redirect()->to(base_url('public/registrasi'))->with('error', 'Registrasi gagal, silahkan coba lagi!');
    }
  }

  public function login()
  {
    $userModel = new UserModel();
    $username = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $user = $userModel->where('username', $username)->first();
    if (!$user) {
      return redirect()->to(base_url('public/login'))->with('error', 'Username atau password salah!');
    }
    if (password_verify($password, $user['password'])) {
      session()->set([
        'username' => $user['username'],
        'tipe' => $user['tipe'],
        'isLoggedIn' => true,
      ]);
      return redirect()->to(base_url('public/dashboard'))->with('success', 'Login berhasil!');
    }
    return redirect()->to(base_url('public/login'))->with('error', 'Username atau password salah!');
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to(base_url('public/login'))->with('success', 'Logout berhasil!');
  }
}