<?php

use Illuminate\Support\Facades\Log;

function debug($var)
{
  if(is_string($var)) {
    Log::debug('<START DEBUG>');
    Log::debug($var);
    Log::debug('<END DEBUG>');
  } else {
    Log::debug('<START DEBUG>');
    Log::debug(var_export($var, true));
    Log::debug('<END DEBUG>');
  }
}
