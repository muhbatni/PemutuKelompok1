<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class UserModel extends Model
{
  protected $table = 'm_user';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = false;
  protected $allowedFields = ['username', 'password', 'tipe', 'nama', 'foto'];

  protected $beforeInsert = ['generateUUID'];

  protected function generateUUID(array $data)
  {
    $data['data']['id'] = Uuid::uuid4()->toString();
    return $data;
  }

  /**
   * Get the display name of a user by username.
   *
   * @param string $username
   * @return string|null
   */
  public function getDisplayName()
  {
    $userModel = new UserModel();
    $user_id = session()->get('user_id');
    if (!$user_id) {
      return null;
    }
    $user = $userModel->where('id', $user_id)->first();
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
    $user_id = session()->get('user_id');
    if (!$user_id) {
      return null;
    }
    if (session()->get('user_avatar')) {
      $encoded_image = base64_encode(session()->get('user_avatar'));
      return "data:image/*;base64,$encoded_image";
    }
    $user = $userModel->where('id', $user_id)->first();
    if (!$user['foto']) {
      return null;
    }
    $image = pg_unescape_bytea($user['foto']);
    $encoded_image = base64_encode($image);
    session()->set('user_avatar', $image);
    return "data:image/*;base64,$encoded_image";
  }
}