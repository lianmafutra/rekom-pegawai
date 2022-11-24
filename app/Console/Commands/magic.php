<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class magic extends Command
{
   protected $signature = 'magic';

   protected $description = 'Command description';

   public function __construct()
   {
      parent::__construct();
   }

   public function handle()
   {
      // Generate Model
      $collection = collect(json_decode(file_get_contents('generator/generator.json'), true));
      $model = $collection->get('model');
      $path = $collection->get('path');

      $template = file_get_contents('generator/model.txt');

      $template = strtr($template, [
         '@MODEL' => ucwords($model),
         '@model' => strtolower($model),
      ]);
      $this->info($template);
      File::put('app/Models/' . ucwords($model) . '.php', $template);

      // generate Create View
      $template_base = file_get_contents('generator/form/base.txt');
      $template_input = file_get_contents('generator/form/input-text.txt');

      $template_input = strtr($template_input, [
         '@required' => 'required',
         '@Name' => ucwords($model),
         '@name' => strtolower($model),
      ]);

      $template_base = strtr($template_base, [
         '@input' => $template_input,
      ]);
      File::makeDirectory($path . '/' . strtolower($model));
      File::put($path . '/' . strtolower($model) . '/' . 'create.blade.php', $template_base);
   }
}
