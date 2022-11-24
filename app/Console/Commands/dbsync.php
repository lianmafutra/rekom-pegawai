<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class dbsync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      $tables = DB::select('SHOW TABLES');
      $tables_in_database = "Tables_in_".Config::get('database.connections.mysql.database');
      DB::statement('SET FOREIGN_KEY_CHECKS=0;');
      $this->info("Disabale FOREIGN_KEY_CHECKS");
      foreach ($tables as $table) {
          Schema::drop($table->$tables_in_database);
      }
      $this->info("Drop Database Success");

      DB::unprepared(file_get_contents('database/backup/db.sql'));
      $this->info("Success Import New Database");


    }
}
