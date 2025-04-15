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
    $validation = service('validation');
    $userModel = new UserModel();
    $data = [
      'username' => $this->request->getPost('username'),
      'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
      'tipe' => $this->request->getPost('tipe')
    ];
    if (!$this->validate('signup')) {
      return view(
        'registrasi/index',
        [
          'errors' => $validation->getErrors(),
          'old' => $this->request->getPost()
        ]
      );
    }
    if ($userModel->insert($data)) {
      return redirect()->to(base_url('public/login'))->with('success', 'Registrasi berhasil, silahkan login!');
    }
    return redirect()->to(base_url('public/registrasi'))->with('error', 'Registrasi gagal, silahkan coba lagi!');
  }

  public function login()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $userModel = new UserModel();
    $data = [
      'username' => $this->request->getPost('username'),
      'password' => $this->request->getPost('password'),
    ];
    $user = $userModel->where('username', $data['username'])->first();
    if (!$user) {
      return redirect()->to(base_url('public/login'))->with('error', 'Username atau password salah!');
    }
    if (password_verify($data['password'], $user['password'])) {
      session()->set([
        'username' => $user['username'],
        'tipe' => $user['tipe'],
        'logged_in' => true,
        'foto' => $user['foto'] ? pg_unescape_bytea($user['foto']) : null,
      ]);
      return redirect()->to(base_url('public/dashboard'))->with('success', 'Login berhasil!');
    }
    return redirect()->to(base_url('public/login'))->with('error', 'Username atau password salah!');
  }

  public function logout()
  {
    if (!session()->get('logged_in')) {
      return redirect()->to(base_url('public/login'))->with('error', 'Anda belum login!');
    }
    session()->remove('username');
    session()->remove('tipe');
    session()->remove('logged_in');
    session()->remove('foto');
    return redirect()->to(base_url('public/login'))->with('success', 'Logout berhasil!');
  }
}