<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
  protected $table = 'm_user'; // Name of the database table
  protected $primaryKey = 'id'; // Primary key of the table

  // Fields that are allowed to be inserted or updated
  protected $allowedFields = ['username', 'password', 'tipe'];

  // Validation rules for user data
  protected $validationRules = [
    'username' => 'required|min_length[5]|max_length[50]|is_unique[m_user.username]',
    'password' => 'required|min_length[8]',
    'tipe' => 'required|in_list[1,2,3]', // Assuming 'tipe' can be 'admin' or 'user'
  ];

  protected $validationMessages = [
    'username' => [
      'required' => 'Username perlu diisi.',
      'min_length' => 'Username harus terdiri dari 5 karakter atau lebih.',
      'max_length' => 'Username tidak bisa melebihi 50 karakter.',
      'is_unique' => 'Username telah digunakan.',
    ],
    'password' => [
      'required' => 'Password perlu diisi.',
      'min_length' => 'Password harus terdiri dari 8 karakter atau lebih.',
    ],
    'tipe' => [
      'required' => 'User type perlu diisi.',
      'in_list' => 'User type harus antara 1 (dosen), 2 (laboran), atau 3 (peserta/mahasiswa).',
    ]
  ];
}