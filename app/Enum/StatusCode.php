<?php
namespace App\Enum;

enum StatusCode : int 
{
  case SUCCESS = 200;
  case NOT_FOUND = 404;
}