<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbbackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

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
      $ds = DIRECTORY_SEPARATOR;

      $return_var = NULL;
      $output = NULL;
      $command = "cd C:\laragon\bin\mysql\mysql-5.7.24-winx64\bin && mysqldump -u root -h 127.0.0.1 -paptika112277 db_rekom_pegawai > ".database_path() . $ds . 'backup/db.sql';
      exec($command, $output, $return_var);
      $this->info("Mysql Dump Success");
      
      shell_exec('git add .');
      $this->info("Git add success");
      shell_exec('Git commit -m "Backup Database"');
      $this->info("Git commit Success");
      shell_exec('git push');
      $this->info("Git Push Success");
      $this->info("Complete");
    }

}
