<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
  // --------------------------------------------------------------------
  // Setup
  // --------------------------------------------------------------------

  /**
   * Stores the classes that contain the
   * rules that are available.
   *
   * @var list<string>
   */
  public array $ruleSets = [
    Rules::class,
    FormatRules::class,
    FileRules::class,
    CreditCardRules::class,
  ];

  /**
   * Specifies the views that are used to display the
   * errors.
   *
   * @var array<string, string>
   */
  public array $templates = [
    // 'list' => 'CodeIgniter\Validation\Views\list',
    // 'single' => 'CodeIgniter\Validation\Views\single',
  ];

  // --------------------------------------------------------------------
  // Rules
  // --------------------------------------------------------------------
  public array $signup = [
    'username' => 'required|min_length[5]|max_length[50]|is_unique[m_user.username]',
    'password' => 'required|min_length[8]|regex_match[/^[A-Za-z\d\W]+$/]',
    'konfirmasi_password' => 'required_with[password]|matches[password]',
    'tipe' => 'required|in_list[1,2,3]',
  ];

  public array $signup_errors = [
    'username' => [
      'required' => 'Username perlu diisi.',
      'min_length' => 'Username harus terdiri dari 5 karakter atau lebih.',
      'max_length' => 'Username tidak bisa melebihi 50 karakter.',
      'is_unique' => 'Username telah digunakan.',
    ],
    'password' => [
      'required' => 'Password perlu diisi.',
      'min_length' => 'Password harus terdiri dari 8 karakter atau lebih.',
      'regex_match' => 'Password harus terdiri dari huruf dan angka.'
    ],
    'konfirmasi_password' => [
      'required_with' => 'Password perlu diisi terlebih dahulu.',
      'matches' => 'Konfirmasi password harus sama dengan password.'
    ],
    'tipe' => [
      'required' => 'User type perlu diisi.',
      'in_list' => 'User type harus antara 1 (dosen), 2 (laboran), atau 3 (peserta/mahasiswa).',
    ]
  ];

  public array $profile = [
    'nama' => 'max_length[50]',
    'avatar' => 'is_image[avatar]|max_size[avatar,2048]|ext_in[avatar,jpg,jpeg,png]',
  ];

  public array $profile_errors = [
    'nama' => [
      'max_length' => 'Nama tidak bisa melebihi 50 karakter.'
    ],
    'avatar' => [
      'max_size' => 'Ukuran foto tidak boleh lebih dari 2MB.',
      'ext_in' => 'Ekstensi foto harus jpg, jpeg, atau png.'
    ]
  ];
}
