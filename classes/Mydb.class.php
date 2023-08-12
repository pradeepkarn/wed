<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} 
class Mydb extends Dbobjects
{
    public function __construct($table)
    {
        $this->tableName = $table;
    }
    public function allData($ord = '',$limit = 5)
    {        
        return $this->all($ord,$limit);
    }
    public function filterData($assoc_arr, $ord='',$limit = 100)
    {
        return $this->filter($assoc_arr, $ord,$limit);
    }

    public function filterDistinct($col, $ord='',$limit = 100)
    {
        return $this->filter_distinct($col, $ord,$limit);
    }

    public function filterDistinctWhr($col="",$assoc_arr, $ord='',$limit = 9999999)
    {
        return $this->filter_distinct_whr($col,$assoc_arr, $ord,$limit);
    }
    public function pkData($pk = null)
    {
        return $this->pk($pk);
    }
    public function getData($assoc_arr = null, $ord='')
    {
        return $this->get($assoc_arr, $ord);
    }
    public function searchData($assoc_arr, $ord='',$limit = 10)
    {
        return $this->search($assoc_arr,$ord,$limit);
    }
    public function columnsData()
    {
        return $this->columns();
    }
    // public function startTrans()
    // {
    //     return $this->beginTrans();
    // }
    // public function endTrans()
    // {
    //     return $this->commitTrans();
    // }
    public function updateData($arr)
    {
        $this->insertData = $arr;
        return $this->update();
    }
    public function updateTransData($arr)
    {
        $this->insertData = $arr;
        return $this->updateTransaction();
    }
    public function createData($arr)
    {
        $this->insertData = $arr;
        return $this->create();
    }
    public function transactData($arr)
    {
        $this->insertData = $arr;
        return $this->transact();
    }
    public function deleteData()
    {
        return $this->delete();
    }
    public function transactionData($sqlarr)
    {
        return $this->transaction($sqlarr);
    }
        
    public function update_sqlData()
    {
        return $this->update_sql();
    }
    public function create_sqlData()
    {
        return $this->create_sql();
    }
}