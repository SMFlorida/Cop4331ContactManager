<?php
// used to get mysql database connection
class Database{
 
    // specify your own database credentials
    private $host = "spadecontactmanager.com";
    private $db_name = "cop4311g_shelbydatabase";
    private $username = "cop4311g_shelbyuser";
    private $password = "g7KJzejTVvG6SLC";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>