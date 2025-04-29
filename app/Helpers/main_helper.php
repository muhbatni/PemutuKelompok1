<?php

function redirectTo($redirectPath)
{
  return redirect()->to(base_url("public/$redirectPath"));
}

function redirectWithMessage($redirectPath, $type, $message)
{
  return redirectTo($redirectPath)->with($type, $message);
}

function handleUpload($path, $file, $prefix = null)
{
  if ($file->hasMoved()) {
    return null;
  }
  $filePath = WRITEPATH . 'uploads/' . $path;
  if (!is_dir($filePath)) {
    mkdir($filePath, 0777, true);
  }
  $prefix = $prefix ? "$prefix-" : '';
  $fileName = $prefix . $file->getRandomName();
  $file->move($filePath, $fileName);
  return $fileName;
}

?>