<?php

namespace App\Utils;

interface  uploadFileBuilder
{
   public function path(string $path);
   public function uuid(string $uuid);
   public function parent_id(string $parent_id);
   public function file($file);
}
