<?php
    class Patron
    {
        private $id;
        private $name;

        function __construct($name, $id = null)
        {
            $this->id = $id;
            $this->name = $name;
        }

        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $queries = $GLOBALS['DB']->query("SELECT * FROM patrons;");
            $patrons = $queries->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Patron" , array("name","id"));
            return $patrons;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons;");
        }

        static function find($search_id)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM patrons WHERE id = {$search_id};");
            $query->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, "Patron", array("name","id"));
            $author = $query->fetch();
            return $author;
        }

        function updateProperty($property, $value)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET {$property} = '{$value}' WHERE id = {$this->getId()};");
            $this->$property = $value;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id = {$this->getId()};");
        }


    }
?>
