<?php

namespace App\Rules;

class DateValidationRules
{
  public function startEnd($value, string $params, array $data, ?string &$error = null)
  {
    [$startField, $endField] = explode(',', $params);
    $startDate = $data[$startField] ?? null;
    $endDate = $data[$endField] ?? null;
    return strtotime($startDate) <= strtotime($endDate);
  }
}
?>