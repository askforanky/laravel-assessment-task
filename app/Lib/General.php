<?php

namespace App\Lib;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class General
{
  static function error_res($msg = "", $data = [])
  {
    $msg = $msg == "" ? "Error" : $msg;
    $json = array('flag' => 0, 'msg' => $msg, 'data' => $data);
    return $json;
  }

  static function success_res($msg = "", $data = [])
  {
    $msg = $msg == "" ? "Success" : $msg;
    $json = array('flag' => 1, 'msg' => $msg, 'data' => $data);
    return $json;
  }

  static function validation($fields, $rules, $msg = [])
  {
    $validator = Validator::make($fields, $rules, $msg);
    if ($validator->fails()) {
      $error = $validator->messages()->all();
      return self::error_res($error[0]);
    }
    return self::success_res();
  }
}
