<?php

namespace App\Services\Database;

use Longman\TelegramBot\DB;
use \RedBeanPHP\R as R;

class DatabaseService extends R
{
    private $config;
    private static $instance = null;
    private static $pdo;

    public static function instance(): ?DatabaseService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        $this->config = require $_SERVER['DOCUMENT_ROOT'] . '/tg/config.php';
        self::$pdo = DB::getPdo();
        R::setup('mysql:host=' . $this->config['mysql']['host'] . '; dbname=' . $this->config['mysql']['database'] . '', $this->config['mysql']['user'], $this->config['mysql']['password']);
        self::initDatabase();
    }

    public static function getPdo()
    {
        return self::$pdo;
    }

    public static function initDatabase()
    {
        //TODO придумать что делать с этим костылем
        if (is_null(R::findOne('user','id>0'))){
            $database = file_get_contents(__DIR__.'/structure.sql');
            DatabaseService::exec($database);
        }
    }
}