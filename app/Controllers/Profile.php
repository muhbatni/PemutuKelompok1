<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
  protected $userModel;
  public function __construct()
  {
    $this->userModel = new UserModel();
  }

  public function index()
  {
    $data = ['title' => 'Profile'];
    echo view("layouts/header.php", $data);
    echo view("profile/index.php");
    echo view("layouts/footer.php");
  }
  private function isDataValid($data)
  {
    $validation = service('validation');
    if (!$validation->run($data, "profile")) {
      echo view('layouts/header', ['title' => 'Profile']);
      echo view(
        'profile/index',
        [
          'errors' => $validation->getErrors(),
          'old' => $data
        ]
      );
      echo view('layouts/footer');
      return false;
    }
    return true;
  }

  public function edit()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $token = getDecodedToken();
    if (!$token) {
      return null;
    }
    $userId = $token->uid;
    $data = [
      "nama" => $this->request->getPost('nama'),
    ];

    if (!$this->isDataValid($data)) {
      return;
    }

    $file = $this->request->getFile('foto');
    if ($file->isValid()) {
      $this->userModel->setAvatar($file);
    }

    $isUpdate = $this->userModel->update($userId, $data);
    if (!$isUpdate) {
      return redirectWithMessage('profile', 'error', 'Gagal memperbarui profil!');
    }
    return redirectWithMessage('profile', 'success', 'Berhasil memperbarui profil!');
  }

  public function reset_password()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
  }
}