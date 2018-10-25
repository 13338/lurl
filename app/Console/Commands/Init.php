<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init project';

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
     * @return mixed
     */
    public function handle()
    {

        $this->comment('Initialize project');
        if (!config('app.key')) {
            $this->info('Generating app key');
            Artisan::call('key:generate');
        } else {
            $this->comment('App key exists -- skipping');
        }
        $env = false;
        while (!$env) {
            try {
                Artisan::call('config:clear');
                DB::reconnect()->getPdo();
                $env = true;
            } catch (Exception $e) {
                $this->error($e->getMessage());
                $this->setUpDatabase();
            }
        }

        $this->info('Migrating database');
        try {
            Artisan::call('migrate');
            if ($info = Artisan::output()){
                $this->info($info);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Prompt user for valid database credentials and set up the database.
     */
    private function setUpDatabase()
    {
        $config = [
            'DB_CONNECTION' => '',
            'DB_HOST' => '',
            'DB_PORT' => '',
            'DB_DATABASE' => '',
            'DB_USERNAME' => '',
            'DB_PASSWORD' => '',
        ];

        $config['DB_CONNECTION'] = $this->choice(
            'DB_CONNECTION',
            [
                'mysql' => 'MySQL',
                'sqlite-e2e' => 'SQLite',
            ],
            'mysql'
        );
        if ($config['DB_CONNECTION'] === 'sqlite-e2e') {
            $config['DB_DATABASE'] = $this->ask('Absolute path to the DB file');
        } else {
            $config['DB_HOST'] = $this->anticipate('DB host', ['127.0.0.1', 'localhost']);
            $config['DB_PORT'] = (string) $this->ask('DB port (leave empty for default)', false);
            $config['DB_DATABASE'] = $this->anticipate('DB name', ['lurl']);
            $config['DB_USERNAME'] = $this->anticipate('DB user', ['lurl']);
            $config['DB_PASSWORD'] = (string) $this->ask('DB password', false);
        }

        foreach ($config as $key => $value) {
            DotenvEditor::setKey($key, $value);
        }
        DotenvEditor::save();

        // Set the config so that the next DB attempt uses refreshed credentials
        config([
            'database.default' => $config['DB_CONNECTION'],
            "database.connections.{$config['DB_CONNECTION']}.host" => $config['DB_HOST'],
            "database.connections.{$config['DB_CONNECTION']}.port" => $config['DB_PORT'],
            "database.connections.{$config['DB_CONNECTION']}.database" => $config['DB_DATABASE'],
            "database.connections.{$config['DB_CONNECTION']}.username" => $config['DB_USERNAME'],
            "database.connections.{$config['DB_CONNECTION']}.password" => $config['DB_PASSWORD'],
        ]);
    }
}
