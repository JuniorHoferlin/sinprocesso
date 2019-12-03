<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class limparDatabase extends Command
{
    protected $signature = 'limpar-database';
    protected $description = 'DROP and CREATE DATABASE gepec';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        \DB::unprepared('DROP DATABASE gepec;');
        \DB::unprepared('CREATE DATABASE gepec DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;');
    }
}
