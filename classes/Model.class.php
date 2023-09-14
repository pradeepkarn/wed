<?php
class Model
{
    public $limit;
    public $ord;
    private $dbTableObj;
    public $table;
    public $json_obj;
    public function __construct($table)
    {
        $this->table = $table;
        $this->dbTableObj = new Dbobjects;
        $this->dbTableObj->tableName = $this->table;
        $this->json_obj = false;
    }
    public function index($ord="DESC",$limit="1000",$change_order_by_col="")
    {
        $data = $this->dbTableObj->all($ord,$limit,$change_order_by_col);
        if (count($data)>0) {
            if ($this->json_obj===true) {
                $data = json_encode($data);
            }
            return $data;
        }
        else{
            return array();
        }
    }
    public function filterIndex($assoc_arr, $ord='',$limit = 9999999,$change_order_by_col="")
    {
        $data = $this->dbTableObj->filter($assoc_arr, $ord,$limit,$change_order_by_col);
        if (count($data)>0) {
            if ($this->json_obj===true) {
                $data = json_encode($data);
            }
            return $data;
        }
        else{
            return array();
        }
    }
    public function filter_index($assoc_arr, $ord='DESC',$limit = 9999999,$change_order_by_col="")
    {
        $data = $this->dbTableObj->filter($assoc_arr, $ord,$limit,$change_order_by_col);
        if (count($data)>0) {
            if ($this->json_obj===true) {
                $data = json_encode($data);
            }
            return $data;
        }
        else{
            return array();
        }
    }
    public function filter_where_not($assoc_arr, $not_arry, $not_operator, $ord='DESC',$limit = 9999999,$change_order_by_col="")
    {
        $data = $this->dbTableObj->filter_where_not($assoc_arr, $not_arry, $not_operator, $ord,$limit,$change_order_by_col);
        if (count($data)>0) {
            if ($this->json_obj===true) {
                $data = json_encode($data);
            }
            return $data;
        }
        else{
            return array();
        }
    }
    public function filter_by_conditions($assoc_arr, $assoc_operator="=", $cunjunction="and", $not="", $ord='DESC',$limit = 9999999,$change_order_by_col="id")
    {
        $data = $this->dbTableObj->filter_by_conditions($assoc_arr, $assoc_operator, $cunjunction, $not, $ord,$limit,$change_order_by_col);
        if (count($data)>0) {
            if ($this->json_obj===true) {
                $data = json_encode($data);
            }
            return $data;
        }
        else{
            return array();
        }
    }
    public function show($id)
    {
        $data = $this->dbTableObj->filter(['id'=>$id]);
        if (count($data)>0) {
            if ($this->json_obj===true) {
                $data = json_encode($data);
            }
            return $data[0];
        }
        else{
            return false;
        }
    }
    public function exists($arr)
    {
        $data = $this->dbTableObj->filter($arr);
        if (count($data)>0) {
            return true;
        }
        else{
            return false;
        }
    }
    public function update($id,$arr)
    {
        $data = $this->dbTableObj->filter(['id'=>$id]);
        if (count($data)>0) {
            $this->dbTableObj->insertData = $arr;
            return $this->dbTableObj->update();
        }
        else{
            return false;
        }
    }
    public function store($arr)
    {
        try {
            $this->dbTableObj->insertData = $arr;
            $lastid = $this->dbTableObj->create();
            return $lastid;
        } catch (Exception $e) {
            return false;
        }
    }
    public function destroy($id)
    {
        $data = $this->dbTableObj->filter(['id'=>$id]);
        if (count($data)>0) {
            $this->dbTableObj->pk($id);
            return $this->dbTableObj->delete();
        }
        else{
            return false;
        }
    }
    public function show_unique($col, $ord='DESC',$limit = 10000)
    {
        $data = $this->dbTableObj->filter_distinct($col,$ord,$limit);
        if (count($data)>0) {
            return $data;
        }
        else{
            return array();
        }
    }
    public function show_unique_whr($col="",$whr_assoc_arr=[], $ord='DESC',$limit = 9999999)
    {
        $data = $this->dbTableObj->filter_distinct_whr($col,$whr_assoc_arr,$ord,$limit);
        if (count($data)>0) {
            return $data;
        }
        else{
            return array();
        }
    }
    public function search($assoc_arr, $ord='DESC',$limit =10,$change_order_by_col="",$whr_arr=false)
    {
        $data = $this->dbTableObj->search($assoc_arr,$ord,$limit,$change_order_by_col,$whr_arr);
        if (count($data)>0) {
            return $data;
        }
        else{
            return array();
        }
    }

}