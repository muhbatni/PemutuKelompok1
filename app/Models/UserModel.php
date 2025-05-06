<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;
use Exception;

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
    $user = $userModel->select('username')->where('id', $userId)->first();
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
    $user = $userModel->select('nama, username')->where('id', $userId)->first();
    if ($user) {
      return $user['nama'] ?? $user['username'];
    }
    return null;
  }

  public function setAvatar($file)
  {
    if ($file->getError() !== 0) {
      return false;
    }
    $file_contents = file_get_contents($file->getTempName());
    $token = getDecodedToken();
    if (!$token) {
      return false;
    }
    $userId = $token->uid;
    handleCache("avatar", $file_contents);
    $hexData = bin2hex($file_contents);
    $sql = "UPDATE m_user SET foto = decode(?, 'hex') WHERE id = ?";
    $result = $this->db->query($sql, [$hexData, $userId]);
    return $result;
  }

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
    try {
      $sql = "SELECT encode(foto, 'hex') AS encoded_foto FROM m_user WHERE id = ?";
      $query = $this->db->query($sql, [$userId]);
      $user = $query->getRowArray();
      if (!$user || empty($user['encoded_foto'])) {
        return null;
      }
      $image = hex2bin($user['encoded_foto']);
      handleCache("avatar", $image);
      $mimeType = $this->getMimeType($image);
      $encodedImage = base64_encode($image);
      return "data:$mimeType;base64,$encodedImage";
    } catch (Exception $exception) {
      log_message('error', 'Avatar get error: ' . $exception->getMessage());
      return null;
    }
  }

  /**
   * Determine the MIME type of an image.
   *
   * @param string $image
   * @return string
   */
  private function getMimeType($image)
  {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_buffer($finfo, $image);
    finfo_close($finfo);
    return $mimeType;
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
    $user = $userModel->select('tipe')->where('id', $userId)->first();
    return match ($user['tipe']) {
      "1" => "Dosen",
      "2" => "Laboran",
      "3" => "Mahasiswa",
      default => "Undefined"
    };
  }

}