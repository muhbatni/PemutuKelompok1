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

  public function edit()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $validation = service('validation');
    $token = getDatabyToken();
    if (!$token) {
      return null;
    }
    $userId = $token->uid;
    $user = $this->userModel->where('id', $userId)->first();
    $postData = $this->request->getPost();
    $data = ['nama' => $postData['nama']];
    $file = $this->request->getFile('avatar');
    if ($file && $file->isValid()) {
      $data['foto'] = pg_escape_bytea(file_get_contents($file->getTempName()));
    }
    if (!$this->validate("profile")) {
      echo view('layouts/header', ['title' => 'Profile']);
      echo view(
        'profile/index',
        [
          'errors' => $validation->getErrors(),
          'old' => $postData
        ]
      );
      echo view('layouts/footer');
      return;
    }

    $data = array_filter($data, fn($value) => !$value && $value !== '');
    if (empty($data)) {
      return redirect()->back()->with('error', 'No data to update.');
    }

    $this->handleCacheImage($data['foto'], $userId);

    $isUpdate = $this->userModel->update($user['id'], $data);
    if (!$isUpdate) {
      return redirectWithMessage('profile', 'error', 'Failed to update the profile!');
    }
    return redirectWithMessage('profile', 'success', 'Profile updated successfully!');
  }

  public function reset_password()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
  }
}