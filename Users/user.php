<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class User
{
    private $dbh;
    private $usersTableName = 'users';

    public function __construct($database, $host, $databaseUsername, $databaseUserPassword)
    {
        $dev = true;
        if ($dev) {
            $databaseUserPassword = "11223344";
            $databaseUsername = "dev";
            $host = "192.168.9.2";
            $database = "RextopiA";
        } else {
            $databaseUserPassword = "20@July2021";
            $databaseUsername = "DeesreX";
            $host = "localhost";
            $database = "Rextopia";
        }


        try {
            $this->dbh =
                new PDO(sprintf('mysql:host=%s;dbname=%s', $host, $database),
                    $databaseUsername,
                    $databaseUserPassword
                );

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function create($username, $password)
    {
        $password = password_hash($password, 0);

        $statement = $this->dbh->prepare(
            'INSERT INTO ' . $this->usersTableName . ' (username, password) VALUES (:username, :password)'
        );

        if (false === $statement) {
            throw new Exception('Invalid prepare statement');
        }

        if (false === $statement->execute([
                ':username' => $username,
                ':password' => $password,
            ])) {

            throw new Exception(implode(' ', $statement->errorInfo()));
        }
    }

    public function exists($username, $password)
    {
        $statement = $this->dbh->prepare(
            'SELECT * from ' . $this->usersTableName . ' where username = :username'
        );

        if (false === $statement) {
            throw new Exception('Invalid prepare statement');
        }

        $result = $statement->execute([':username' => $username]);

        if (false === $result) {
            throw new Exception(implode(' ', $statement->errorInfo()));
        }

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return false;
        }

        return password_verify($password, $row['password']);
    }

}