<?php
function getUserType()
{
  return match (session()->get('user_type')) {
    "1" => "Dosen",
    "2" => "Laboran",
    "3" => "Mahasiswa",
    default => "Undefined"
  };
}