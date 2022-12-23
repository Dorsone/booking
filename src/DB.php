<?php

namespace Dorsone\Booking;

use Exception;
use mysqli;

class DB
{
    private static ?DB $instance = null;

    public static function connect(): DB
    {
        if (is_null(static::$instance)) {
            static::$instance = new DB(
                Config::DB_HOSTNAME->value,
                Config::DB_USERNAME->value,
                Config::DB_PASSWORD->value,
                Config::DB_NAME->value
            );
        }

        return static::$instance;
    }

    private function __construct($host, $username, $password, $name)
    {
        $this->database = new mysqli($host, $username, $password, $name);
    }

    protected mysqli $database;

    protected string $tableName;

    protected string $whereCondition = '';
    protected string $innerJoin = '';

    public function table(string $tableName): static
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function get($columns = ['*']): bool|array|null
    {
        try {
            $sql = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $this->tableName . $this->innerJoin . $this->formatWhereCondition() . ';';
            $this->innerJoin = '';
            return $this->database->query($sql)->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $exception) {
            return [];
        }
    }

    protected function formatWhereCondition(): string
    {
        $where = $this->whereCondition === '' ? '' : ' WHERE ' . $this->whereCondition;
        $this->whereCondition = '';
        return $where;
    }

    public function where(string $column, string $operator, string $value): static
    {
        $sql = "`$column` $operator \"$value\"";
        if ($this->whereCondition === '') {
            $this->whereCondition .= $sql;
            return $this;
        }
        $this->whereCondition .= " and $sql";
        return $this;
    }

    public function insert(array $data): bool
    {
        try {
            $columns = "`".implode('`, `', array_keys($data))."`";
            $values = implode(', ', array_map(fn($value) => "\"$value\"", $data));
            $sql = "INSERT INTO $this->tableName ($columns) VALUES ($values)";
            $this->database->query($sql);
            return true;
        } catch (Exception $exception) {
            print_r($exception);
            die();
            return false;
        }
    }

    public function innerJoin(string $relatedTableName, string $localKeyName, string $foreignKeyName): static
    {
        $this->innerJoin = ' INNER JOIN ' . $relatedTableName . ' ON ' . $this->tableName . '.' . $localKeyName . '=' . $relatedTableName . '.' . $foreignKeyName;
        return $this;
    }

    private function __clone()
    {
    }

    /**
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('__wakeup() method unsupported!');
    }
}