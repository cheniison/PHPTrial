<?php
/**
 * @file T_PDO.php
 * @brief 使用PDO操作数据库
 * @author cheniison
 * @version 1.0.0
 * @date 2017-06-30
 */

namespace PHPTrial\T_PDO;

class T_PDO{
    
    protected $pdo;

    public function __construct($host, $port, $dbname, $username, $userpassword, $charset=“utf8”)
    {
        try {
            $this->pdo = new PDO(sprintf(
                            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                            $host,
                            $port,
                            $dbname,
                            $charset
                        ),
                        $username,
                        $userpassword
                    );
        } catch (PDOException $e) {
            die("Database connection failed");
        }
    }

    public function query($sql, $args)
    {
        $statment = $this->pdo->prepare($sql);

        foreach($args as $arg){
            $statment->bindValue($arg[0], $arg[1], isset($arg[2])?$arg[2]:PDO::PARAM_STR);
        }

        return $statment->execute();
    }
}
