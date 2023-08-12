<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php
/**
 * 
 */
class Dbobjects extends Dbh
{
    public $tableName; // set tablename
    public $sql;//get your sql query
    public $qry;//get current qury
    public $insertData;//set data to update, delete


    public function dbpdo()
    {
        $stmt = $this->connect();
        return $this->pdo;
    }
    
    public function tables() // returns indexed array
    {
            $arr = array();
            $this->sql = "SHOW TABLES";
            $allTables = $this->show($this->sql);
            for ($i = 0; $i < count($allTables); $i++) {
                $arr[] = $allTables[$i]["Tables_in_".PK_DB_NAME];
            }
            return $arr;
    }
    public function id()
        {
            $this->sql = "SHOW KEYS FROM `$this->tableName` WHERE Key_name = 'PRIMARY';";
            return $this->show($this->sql)[0]['Column_name'];
        }

// read start
    public function columns()
    {
        $this->sql = "SELECT column_name,column_type, data_type
        FROM information_schema.columns
        WHERE table_schema = DATABASE()
        AND table_name='$this->tableName'
        ORDER BY ordinal_position;";
        foreach($this->show($this->sql) as $k => $value){
            $this->{$value['column_name']} = $value['column_name'];
        }
        return $this->show($this->sql);
    }

    public function all($ord = '',$limit = 5,$change_order_by_col=""){
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        $this->sql = "SELECT * FROM `$this->tableName` ORDER BY `$id` $ord LIMIT $limit";
        return $this->show($this->sql);
    }
 
    public function filter($assoc_arr, $ord='',$limit = 9999999,$change_order_by_col="")
    {
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        foreach ($assoc_arr as $col => $val):
            $arr[] = "`{$col}` = '".addslashes($val)."'";
        endforeach;
        // $ord = $ord=='RAND()'?'RAND()':$ord;
        $id = $ord=='RAND()'?null:"$id";
        $this->sql = "SELECT * FROM `$this->tableName` WHERE " .implode(" and ", $arr). " ORDER BY $id $ord LIMIT $limit;";
        $this->qry = implode(" and ", $arr);
        $assoc_arr = null;
        // echo $this->sql;
        return $this->show($this->sql);
    }
    public function filter_where_not($assoc_arr, $not_arr=array(), $not_operator="=",$ord='',$limit = 9999999,$change_order_by_col="")
    {
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        $whr_not_arr = array();
        foreach ($not_arr as $not_col => $not_val):
            $whr_not_arr[] = "`{$not_col}` $not_operator '".addslashes($not_val)."'";
        endforeach;
        foreach ($assoc_arr as $col => $val):
            $arr[] = "`{$col}` = '".addslashes($val)."'";
        endforeach;
        // $ord = $ord=='RAND()'?'RAND()':$ord;
        $id = $ord=='RAND()'?null:"`$id`";
        $whr[] = implode(" and ", $arr);
        $whr[] = implode(" and ", $whr_not_arr);

        $this->sql = "SELECT * FROM `$this->tableName` WHERE " . implode(" and ", $whr). " ORDER BY $id $ord LIMIT $limit;";
        $this->qry = implode(" and ", $arr);
        $assoc_arr = null;
        // echo $this->sql;
        return $this->show($this->sql);
    }
    public function filter_by_conditions($assoc_arr, $assoc_operator="=", $cunjunction="and", $not="", $ord='DESC',$limit = 9999999,$change_order_by_col="")
    {
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        foreach ($assoc_arr as $col => $val):
            $arr[] = "`{$col}` $assoc_operator '".addslashes($val)."'";
        endforeach;
        $this->sql = "SELECT * FROM `$this->tableName` WHERE $not (" .implode(" $cunjunction ", $arr). ") ORDER BY `$id` $ord LIMIT $limit;";
        $this->qry = implode(" $cunjunction ", $arr);
        $assoc_arr = null;
        return $this->show($this->sql);
    }
    public function filter_distinct_whr($col="",$assoc_arr, $ord='',$limit = 99999999,$change_order_by_col="")
    {
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        foreach ($assoc_arr as $colwhr => $val):
            $arr[] = "`{$colwhr}` = '".addslashes($val)."'";
        endforeach;
        $this->sql = "SELECT DISTINCT $col FROM `$this->tableName` WHERE " .implode(" and ", $arr). " ORDER BY `$id` $ord LIMIT $limit;";
        $this->qry = null;
        $assoc_arr = null;
        return $this->show($this->sql);
    }
    public function filter_distinct($col="", $ord='',$limit = 999999999,$change_order_by_col="")
    {
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        $this->sql = "SELECT DISTINCT $col FROM `$this->tableName` ORDER BY `$id` $ord LIMIT $limit;";
        $this->qry = null;
        return $this->show($this->sql);
    }
    public function search($assoc_arr, $ord='',$limit = 9999999,$change_order_by_col="",$whr_arr=array())
    {
        $whrstr = "";
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        foreach ($assoc_arr as $col => $val):
            $arr[] = "(`{$col}` LIKE '%".addslashes($val)."%')";
        endforeach;
        if ($whr_arr!=false) {
            foreach ($whr_arr as $colwhr => $valwhr):
                $arrwhr[] = "`{$colwhr}` = '".addslashes($valwhr)."'";
            endforeach;
            $whrstr = ' AND ('.implode(" and ", $arrwhr).')';
        }
        $this->sql = "SELECT * FROM `$this->tableName` WHERE (" .implode(" or ", $arr).')'. $whrstr. " ORDER BY `$id` $ord LIMIT $limit;";
        $this->qry = implode(" or ", $arr);
        $assoc_arr = null;
        return $this->show($this->sql);
    }

    public function get($assoc_arr = null, $ord='',$change_order_by_col="")
    {
        if ($change_order_by_col!="") {
            $id = $change_order_by_col;
        }
        else{
            $id = $this->id();
        }
        foreach ($assoc_arr as $col => $val):
            $arr[] = "`{$col}` = '".addslashes($val)."'";
        endforeach;
        $this->sql = "SELECT * FROM `$this->tableName` WHERE " .implode(" and ", $arr). " ORDER BY `$id` $ord LIMIT 1;";
        $this->qry = "`{$id}` = {$this->show($this->sql)[0][$id]}";
        $assoc_arr = null;
        return $this->show($this->sql)[0];        
    }

    public function pk($pk = null)
    {
        $id = $this->id();
        $this->qry = "`$id` = {$pk}";
        $this->sql = "SELECT * FROM `$this->tableName` WHERE `$this->tableName`.`$id` = $pk";
        $this->qry = "`$id` = {$this->show($this->sql)[0][$id]}";
        $pk = null;
        return $this->show($this->sql)[0];
    }
    
    
    public function show($sql)
    {
     
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $results;
           
    }
	
// read end


//update start
    public function update()
    {
        $id = $this->id();
            $tablCols = $this->setColNames($this->tableName);
            foreach ($tablCols as $k => $v) {
                if (isset($this->insertData["{$v['column_name']}"])) {
                    $col = $v['column_name'];
                    $colval = addslashes($this->insertData["{$v['column_name']}"]);
                    if ($v['column_name'] != "{$id}") {
                        $this->pdo->exec("UPDATE `$this->tableName` SET `$col` = '$colval' WHERE $this->qry;");
                    }
                }
            }
            $this->insertData = null;//remove insert data after execution
            return true;
    }
    
    // update end
 
    public function updateTransaction()
    {
        $id = $this->id();
        try{
            $tablCols = $this->setColNames($this->tableName);
            $this->pdo->beginTransaction();
            foreach ($tablCols as $k => $v) {
                if (isset($this->insertData["{$v['column_name']}"])) {
                    $col = $v['column_name'];
                    $colval = addslashes($this->insertData["{$v['column_name']}"]);
                    if ($v['column_name'] != "{$id}") {
                        $this->pdo->exec("UPDATE `$this->tableName` SET `$col` = '$colval' WHERE $this->qry;");
                    }
                }

            }
            $this->pdo->commit();
            $this->insertData = null;//remove insert data after execution
            return true;
            }
        catch(PDOException $e) 
            {
                    // roll back the transaction if something failed
                    $this->pdo->rollback();
                    return false;
            }
    }

    // craet start

    //get insert sql query of any row
	public function create_sql()
	{
        $cols = $this->setColNames($this->tableName);
        foreach ($cols as $key => $value) {
                if (isset($value['column_name'])) {
                    if (isset($this->insertData[$value['column_name']])) {
                        $keys[] = "`{$value['column_name']}`";
                        $values[] = '"'.addslashes($this->insertData[$value['column_name']]).'"';
                    }
                }
        }
        if (isset($keys) && isset($values)) {
            $sql = "INSERT INTO {$this->tableName} (" . implode(",", $keys) . ") VALUES (" . implode(",", $values) . ");";
            return $sql;
        }
            
	}
    public function update_sql()
	{
        $id = $this->id();
            $tablCols = $this->setColNames($this->tableName);
            foreach ($tablCols as $k => $v) {
                if (isset($this->insertData["{$v['column_name']}"])) {
                    $col = $v['column_name'];
                    $colval = addslashes($this->insertData["{$v['column_name']}"]);
                        $keys = "`{$col}`";
                        $values = '"'.addslashes($colval).'"';
                        $arr[] = ($keys ." = ". $values);
                }
            }
            if ($v['column_name'] != "{$id}") {
                return "UPDATE `$this->tableName` SET " . implode(",", $arr) . " WHERE $this->qry;";
            }
            
	}
    public function create()
    {
        $sql = $this->create_sql();
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $cnt = $stmt->rowCount();
        return $this->pdo->lastInsertId();
    }

    public function transact()
    {
        try
        {
            $sql = $this->create_sql();
            $stmt = $this->connect()->prepare($sql);
            $this->pdo->beginTransaction();
            $stmt->execute();
            $insertId = $this->pdo->lastInsertId();
            $this->pdo->commit();
            return $insertId;
        }
        catch(PDOException $e) 
        {
            // roll back the transaction if something failed
            $this->pdo->rollback();
            return 0;
        }
    }
    // create end

    // delete start
    public function del_sql()
    {
        $sql = "DELETE FROM `$this->tableName` WHERE $this->qry;";
        return $sql;
    }
    public function delete()
    {
        $sql = $this->del_sql();
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        $cnt = $stmt->rowCount();
        return $cnt;
    }
    // delete end


    public function transaction($sqlarr)
    {
        try {  
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
            $this->pdo->beginTransaction();
            foreach ($sqlarr as $sql) {
                $this->pdo->exec($sql);
            }
            $this->pdo->commit();
            return  true;
          } 
          catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
          }
    }
}

