<?php

function alert($redirectPath, $type, $message)
{
  return redirect()->to(base_url("public/$redirectPath"))->with($type, $message);
}

function handleUpload($path, $file)
{
  if (!$file->isValid()) {
    throw new \RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
  }
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