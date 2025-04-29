<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
  public function index()
  {
    $data = ['title' => 'Profile'];
    echo view("layouts/header.php", $data);
    echo view("profile/index.php");
    echo view("layouts/footer.php");
  }

  public function edit()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
    $validation = service('validation');
    $userModel = new UserModel();
    $token = getDatabyToken();
    if (!$token) {
      return null;
    }
    $userId = $token->uid;
    $user = $userModel->where('id', $userId)->first();
    $data = ['nama' => $this->request->getPost('nama')];
    $foto = $this->request->getFile('avatar');
    if ($foto && $foto->isValid()) {
      $data['foto'] = pg_escape_bytea(file_get_contents($foto->getTempName()));
    }
    if (!$this->validate("profile")) {
      echo view('layouts/header', ['title' => 'Profile']);
      echo view(
        'profile/index',
        [
          'errors' => $validation->getErrors(),
          'old' => $this->request->getPost()
        ]
      );
      echo view('layouts/footer');
      return;
    }
    // Remove empty fields
    $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');
    if (empty($data)) {
      return redirect()->back()->with('error', 'No data to update.');
    }
    if (isset($data['foto'])) {
      $image = pg_unescape_bytea($data['foto']);
      if (cache()->get("avatar_{$user['id']}")) {
        cache()->delete("avatar_{$user['id']}");
      }
      cache()->save("avatar_{$user['id']}", $image, 3600);
    }
    $isUpdate = $userModel->update($user['id'], $data);
    if (!$isUpdate) {
      return alert('profile', 'error', 'Failed to update the profile!');
    }
    return alert('profile', 'success', 'Profile updated successfully!');
  }

  public function reset_password()
  {
    if ($this->request->getMethod() !== 'POST') {
      return;
    }
  }
}