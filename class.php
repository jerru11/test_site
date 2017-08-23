<?php

final class myTest
{
    /**
     *
     * @var null будет хранить в себе объект PDO
     *
     */
    private $pdo=null;

    /**
     * конструктор, выхывает функции по созданию и автозаполнению таблицы
     */
    function __construct()
    {
        $this->install();

        $this->fill();
    }

    /**
     * @return PDO Возвращает объект подключения PDO , если он ещё не создан
     */
    private function db()
    {
        if ($this->pdo===null)
        {
        $host="localhost";

        $user="root";

        $password="";

        $dbname="test_base";

        $this->pdo = new PDO("mysql:host=$host; dbname=$dbname",$user, $password);
        }

        return $this->pdo;

    }

    /**
     * Метод создаёт таблицу MySQL с заданными параметрами
     */
    private function install()
    {
        $this->db()->query("CREATE TABLE `myTable` ( `id` INT NOT NULL  AUTO_INCREMENT , `script_name` VARCHAR(25) NOT NULL ,
         `script_execution_time` DECIMAL(10,2) NOT NULL , `script_result` ENUM('active','failed','success') NOT NULL, PRIMARY KEY (`id`))");

    }

    /**
     * Метод заполняет случайными данными таблицу, полученную методом install()
     */
    private function fill()
    {
        for ($i=1;$i<=500;$i++)
        {
            $name=substr(md5(uniqid()),0,25);

            $time=rand(1,1000000)/100;

//            $vars=array(`script_name`,`script_execution_time`,`script_result`);
            $res=rand(1,3);

            $exec=$this->db()->prepare("insert into `myTable`(`script_name`,`script_execution_time`,`script_result`) values (?,?,?)");

            $exec->execute(array($name,$time,$res));

        }

    }

    /**
     * @param $option ('active', 'failed', 'success') выводит строки с таким параметром столбца `script_result`
     */
    public function get($option=null)
    {
        if($option===null)
        {
            $option='failed';
        }
        $rez1=$this->db()->prepare("select * from myTable where `script_result`=?");

        $rez1->execute(array($option));

        $rez=$rez1->fetch(PDO::FETCH_ASSOC);


        echo '<table class="table"><tr>';

        foreach($rez as $k=>$v)
        {
            echo "<th>";

            echo "$k";

            echo "</th>";
        }

        echo '</tr><tr>';

        foreach($rez as $k=>$v)
        {
            echo "<th>";

            echo "$v";

            echo "</th>";
        }


        while($rez=$rez1->fetch(PDO::FETCH_ASSOC))
        {
            echo '</tr><tr>';

            foreach($rez as $k=>$v)
            {
                echo "<th>";

                echo "$v";

                echo "</th>";
            }
            echo '</tr><tr>';

        };

        echo "</tr></table>";

    }




}



?>
