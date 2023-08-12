<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php
#.....................................
#DO NOT EDIT BELOW
#.....................................
class Dbh {
#Database Connection Area#####################################################################
    private $host = PK_DB_HOST;
    private $user = PK_DB_USER;
    private $pwd = PK_DB_PASS;
    protected $dbName = PK_DB_NAME;
    protected $pdo;
    
    protected function connect(){
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName. ';charset=utf8';
        
        $this->pdo = new PDO($dsn, $this->user, $this->pwd);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
         //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $this->pdo;
    }

    protected function setColNames($tableName){
        //return $this->selectColNmaes($tableName);
         $sql = "SELECT column_name,column_type,data_type
                 FROM information_schema.columns
                 WHERE table_schema = DATABASE()
                 AND table_name = '$tableName'
                 ORDER BY ordinal_position;";
         $stmt = $this->connect()->prepare($sql);
         $stmt->execute();
         $reults = $stmt->fetchAll();
         return $reults;
    }

    public function dbtable($tableName)
    {
        return $this->setColNames($tableName);
    }
    
    public function transStart()
    {
        return $this->pdo->beginTransaction();
    }
    
    public function transCommit()
    {
        return $this->pdo->commit();
    }

    public function transRollback()
    {
        return $this->pdo->rollback();
    }
    
}
$pdo = null;
?>