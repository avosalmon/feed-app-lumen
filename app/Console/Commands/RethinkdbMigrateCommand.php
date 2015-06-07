<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use r;
use App\Avosalmon\Store\Connection;

class RethinkdbMigrateCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'rql:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate RethinkDB tables';

    /**
     * Variable to hold the instance of the injected dependency.
     *
     * @var App\Avosalmon\Store\Connection
     */
    protected $conn;

    /**
     * List of existing tables.
     *
     * @var array
     */
    protected $tableList = [];

    /**
     * Create a new instance.
     *
     * @param  App\Avosalmon\Store\Connection
     * @return void
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->tableList = r\tableList()->run($this->getConnection());

        $this->createBlogTable();
        // $this->createInstagramTable();
        // $this->createTwitterTable();
    }

    /**
     * Create blog table.
     *
     * @return void
     */
    protected function createBlogTable($table = 'blog')
    {
        if ($this->tableExists($table)) return $this->info('Table "' . $table . '" already exists.');

        r\tableCreate($table)->run($this->getConnection());
        r\table($table)->indexCreate('entry_date')->run($this->getConnection());
    }

    /**
     * Create instagram table.
     *
     * @return void
     */
    protected function createInstagramTable($table = 'instagram')
    {
        if ($this->tableExists($table)) return $this->info('Table "' . $table . '" already exists.');

        r\tableCreate($table)->run($this->getConnection());
        // r\table($table)->indexCreate('entry_date')->run($this->getConnection());
    }

    /**
     * Create twitter table.
     *
     * @return void
     */
    protected function createTwitterTable($table = 'twitter')
    {
        if ($this->tableExists($table)) return $this->info('Table "' . $table . '" already exists.');

        r\tableCreate($table)->run($this->getConnection());
        // r\table($table)->indexCreate('entry_date')->run($this->getConnection());
    }

    /**
     * Get RethinkDB connection.
     *
     * @return r\Connection
     */
    protected function getConnection()
    {
        return $this->conn->getConnection();
    }

    /**
     * Check if the specified table already exists.
     *
     * @param  string $table
     * @return bool
     */
    protected function tableExists($table)
    {
        return in_array($table, $this->tableList);
    }

}
