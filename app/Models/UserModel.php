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

  /**
   * Get the display name of a user by username.
   *
   * @param array $data
   * @return array
   */

  protected function generateUUID(array $data)
  {
    $data['data']['id'] = Uuid::uuid4()->toString();
    return $data;
  }

  /**
   * Get the username by its id.
   *
   * @param string $username
   * @return string|null
   */

  public function getUsername()
  {
    $token = getDecodedToken();
    if (!$token) {
      return null;
    }
    $userModel = new UserModel();
    $userId = $token->uid;
    $user = $userModel->where('id', $userId)->first();
    if ($user) {
      return $user['username'];
    }
    return null;
  }

  /**
   * Get the display name of the user by the user's id.
   *
   * @param string $username
   * @return string|null
   */
  public function getDisplayName()
  {
    $token = getDecodedToken();
    if (!$token) {
      return null;
    }
    $userModel = new UserModel();
    $userId = $token->uid;
    $user = $userModel->where('id', $userId)->first();
    if ($user) {
      return $user['nama'] ?? $user['username'];
    }
    return null;
  }

  /**
   * Get the display name of the user by the user's id.
   *
   * @return object|string
   */
  public function getAvatar()
  {
    $token = getDecodedToken();
    if (!$token) {
      return null;
    }
    $userId = $token->uid;
    if (cache()->get("avatar_$userId")) {
      $image = cache()->get("avatar_$userId");
      $mimeType = $this->getMimeType($image);
      $encodedImage = base64_encode($image);
      return "data:$mimeType;base64,$encodedImage";
    }
    $userModel = new UserModel();
    $user = $userModel->where('id', $userId)->first();
    if (!$user['foto']) {
      return null;
    }
    $image = pg_unescape_bytea($user['foto']);
    cache()->save("avatar_$userId", $image, 3600);
    $mimeType = $this->getMimeType($image);
    $encodedImage = base64_encode($image);
    return "data:$mimeType;base64,$encodedImage";
  }

  /**
   * Get the user's type by its id.
   *
   * @return string
   */

  public function getUserType()
  {
    $token = getDecodedToken();
    if (!$token) {
      return null;
    }
    $userModel = new UserModel();
    $userId = $token->uid;
    if (!$userId) {
      return null;
    }
    $user = $userModel->where('id', $userId)->first();
    return match ($user['tipe']) {
      "1" => "Dosen",
      "2" => "Laboran",
      "3" => "Mahasiswa",
      default => "Undefined"
    };
  }

  /**
   * Determine the MIME type of an image.
   *
   * @param string $image
   * @return string
   */
  function getMimeType($image)
  {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_buffer($finfo, $image);
    finfo_close($finfo);
    return $mimeType;
  }

}