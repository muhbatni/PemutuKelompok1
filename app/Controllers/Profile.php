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
    // if ($this->request->getMethod() !== 'post') {
    //   return;
    // }

    // $validation = service('validation');
    $userModel = new UserModel();
    $user = $userModel->where('username', session()->get('username'))->first();

    $data = [
      'nama' => $this->request->getPost('nama'),
    ];

    $foto = $this->request->getFile('foto');
    // if ($foto && $foto->isValid()) {
    //   // Generate a random name for the file and move it to the uploads directory
    //   $newName = $foto->getRandomName();
    //   // $foto->move(WRITEPATH . 'uploads', $newName);

    //   // Save the file path to the database
    //   $data['foto'] = $foto->store('users/', $newName);
    // }
    if ($foto && $foto->isValid()) {
      $data['foto'] = pg_escape_bytea(file_get_contents($foto->getTempName()));
    }

    // Remove empty fields
    $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');

    if (empty($data)) {
      return redirect()->back()->with('error', 'No data to update.');
    }

    if ($userModel->update($user['id'], $data)) {
      if (!session()->get('foto')) {
        session()->set('foto', $data['foto']);
      }
      return redirect()->to(base_url('public/profile'))->with('success', 'Profile updated successfully!');
    }

    return redirect()->to(base_url('public/profile'))->with('error', 'Failed to update the profile!');
  }
}