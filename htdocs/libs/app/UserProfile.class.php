<?php

include_once __DIR__ . "/../traits/SQLGetterSetter.trait.php";

class UserProfile
{
    use SQLGetterSetter;
    private $conn;
    public $id;
    public $table;
    

    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = 'user_profile';
    }
}