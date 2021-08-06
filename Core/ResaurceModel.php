<?php
namespace mvc\Core;

use mvc\Config\Database;
use mvc\Core\ResaurceModelInterface;
use PDO;

class ResaurceModel implements ResaurceModelInterface
{
   private $table;
   private $id;
   private $model;

   function _init($table, $id, $model)
   {
        $this->table = $table;
        $this->id = $id;
        $this->model = $model;

   }

   function save($model)
   {
     
      $placeName = [];
      $properties = $model->getProperties();
      
      // nếu id  bằng null thì sẽ loại bỏ id 
       if($model->getId() === null){
          unset($properties['id']);  
       }

       foreach ($properties as $key => $value) {
          array_push($placeName, ':' . $key);
       }

       $cols = [];

       foreach (array_keys($properties) as $key => $value){
         if ($value !== 'id') {
            array_push($cols, $value . '= :' . $value);
         }
       }
   
       $cols = implode(',', $cols);   
       $colsString = implode(',', array_keys($properties));
       $placeColString = implode(',', $placeName);

      
       if ($model->getId() !== null) {
         $sql = "UPDATE {$this->table} SET " . $cols . ', updated_at = :updated_at WHERE '.$this->id.' = :id';
         $req = Database::getBdd()->prepare($sql);
         $date = array("id" => $model->getId(), 'updated_at' => date('Y-m-d H:i:s'));

         return $req->execute(array_merge($properties, $date));

        
     } else  if ($model->getId() === null) {
         $sql = "INSERT INTO {$this->table} ({$colsString}, created_at, updated_at) VALUES ({$placeColString}, :created_at, :updated_at)";
         $req = Database::getBdd()->prepare($sql);
         $date = array("created_at" => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'));

         return $req->execute(array_merge($properties, $date));        
     } 
   }

   //tìm theo id
   function find($id) 
   {
      $sql = "SELECT * FROM {$this->table} WHERE id = :id";
      $req = Database::getBdd()->prepare($sql);
      $req->execute([':id' => $id]);
      
      return $req->fetchAll(PDO::FETCH_OBJ);
   }

   // show ra tất cả bản ghi
   function all($model)
   {
      $properties = implode(',', array_keys($model->getProperties()));
      $sql = "SELECT {$properties} FROM {$this->table}";
      $req = Database::getBdd()->prepare($sql);
      $req->execute();

      return $req->fetchAll(PDO::FETCH_OBJ);
   
   }

   // xóa theo id
   function delete($model)
   {   
       $sql =  "DELETE FROM {$this->table} WHERE id = :id";
       $req = Database::getBdd()->prepare($sql);
      return $req->execute([':id' => $model->getId()]);
   }

} 

