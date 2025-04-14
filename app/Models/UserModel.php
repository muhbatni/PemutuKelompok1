<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'm_user';
  protected $primaryKey = 'id';
  protected $allowedFields = ['username', 'password', 'tipe', 'nama', 'foto'];

  /**
   * Get the display name of a user by username.
   *
   * @param string $username
   * @return string|null
   */
  public function getDisplayName()
  {
    $userModel = new UserModel();
    if (session()->get('username') == null) {
      return null;
    }
    $user = $userModel->where('username', session()->get('username'))->first();
    if ($user) {
      return $user['nama'] ?? $user['username'];
    }
    return null;
  }

  /**
   * Get the display name of a user by username.
   *
   * @return object|string
   */
  public function getAvatar()
  {
    $userModel = new UserModel();
    if (!session()->get('username')) {
      return null;
    }
    if (session()->get('foto')) {
      $encoded_image = base64_encode(session()->get('foto'));
      return "data:image/*;base64,$encoded_image";
    }
    $user = $userModel->where('username', session()->get('username'))->first();
    if (!$user['foto']) {
      return null;
    }
    $image = pg_unescape_bytea($user['foto']);
    $encoded_image = base64_encode($image);
    session()->set('foto', $image);
    return "data:image/*;base64,$encoded_image";
  }
}