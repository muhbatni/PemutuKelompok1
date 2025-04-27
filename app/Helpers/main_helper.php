<?php

function alert($redirectPath, $type, $message)
{
  return redirect()->to(base_url("public/$redirectPath"))->with($type, $message);
}

?>