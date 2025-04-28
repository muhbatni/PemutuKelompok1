<?php

function redirectTo($redirectPath)
{
  return redirect()->to(base_url("public/$redirectPath"));
}

function redirectWithMessage($redirectPath, $type, $message)
{
  return redirectTo($redirectPath)->with($type, $message);
}

function handleUpload($path, $file)
{
  if ($file->hasMoved()) {
    return;
  }
  $filePath = WRITEPATH . 'uploads/' . $path;
  if (!is_dir($filePath)) {
    mkdir($filePath, 0777, true);
  }
  $fileName = $file->getRandomName();
  $file->move($filePath, $fileName);
  return $fileName;
}

?>