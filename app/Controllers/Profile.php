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

  private function handleCacheImage($imageData, $userId)
  {
    if (isset($imageData)) {
      $image = pg_unescape_bytea($imageData);
      if (cache()->get("avatar_$userId")) {
        cache()->delete("avatar_$userId");
      }
      cache()->save("avatar_$userId", $image, 3600);
    }
  }

  private function isDataValid($data, $file)
  {
    $validation = service('validation');
    if (empty($data)) {
      return redirect()->back()->with('error', 'Tidak ada data untuk diperbarui!');
    }

    if ($file && $file->isValid()) {
      $data['foto'] = pg_escape_bytea(file_get_contents($file->getTempName()));
    }

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
      return;
    }
  }

  public function edit()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $token = getDatabyToken();
    if (!$token) {
      return null;
    }
    $userId = $token->uid;
    $user = $this->userModel->where('id', $userId)->first();
    $postData = $this->request->getPost();
    $data = ['nama' => $postData['nama']];
    $file = $this->request->getFile('avatar');

    $data = array_filter($data, fn($value) => !$value && $value !== '');

    if (!$this->isDataValid($data, $file)) {
      return;
    }

    $this->handleCacheImage($data['foto'], $userId);

    $isUpdate = $this->userModel->update($user['id'], $data);
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