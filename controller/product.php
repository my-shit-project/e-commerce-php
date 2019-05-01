<?php
class Product
{
    private $database, $fields, $limit, $slug;
    function __construct($database){
        $this->database = $database;
        $this->limit = 12;
        $this->fields  = array("name", "description","price","categoryID","producerID","images","status");
        $this->sorting = array("`createAt` DESC", "`createAt` ASC", "`price` ASC", "`price` DESC", "`name` ASC", "`name` DESC");
    }
    function createSlug($name){

        $name = trim(mb_strtolower($name));
        $name = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $name);
        $name = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $name);
        $name = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $name);
        $name = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $name);
        $name = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $name);
        $name = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $name);
        $name = preg_replace('/(đ)/', 'd', $name);
        $name = preg_replace('/[^a-z0-9-\s]/', '', $name);
        $name = preg_replace('/([\s]+)/', '-', $name);
        return $name;
        
    }


    function showProduct($limit){
        return $this->database->fetchAll("SELECT * FROM `product` LIMIT ". $limit ?? $this->limit ." ORDER BY createAt ASC");
    }
    function showProductById($id){
        return $this->database->fetchOne("SELECT * FROM `product` WHERE `id` = {$id}");
    }
    function showProductByCategoryId($id, $limit){
        return $this->database->fetchAll("SELECT * FROM `product` WHERE `categoryID` = {$id} LIMIT ". $limit ?? $this->limit ." ORDER BY createAt DESC");
    }
    function showProductByProducerId($id, $limit){
        return $this->database->fetchAll("SELECT * FROM `product` WHERE `producerID` = {$id} LIMIT ". $limit ?? $this->limit ." ORDER BY createAt DESC");
    }
    function searchProduct($query, $limit){
        if(count($query) == 0) return false;
        $__store = Array();
        $__sort = "createAt DESC";
        if(!empty($query['keyword'])){
            
           if(!empty($query['exactSearch'])){               
                $__store[] = "`name` = '".addslashes($query['keyword'])."'";
            }
           else $__store[] = "`name` LIKE '%".addslashes($query['keyword'])."%'";
        }
        if(!empty($query['producers']) && is_array($query['producers'])){
            $__store[] = "`producerID` IN (". implode(' , ', $query['producers']) .")";
        }
        if(!empty($query['categories']) && is_array($query['categories'])){
            $__store[] = "`categoryID` IN (". implode(' , ', $query['categories']) .")";
        }
        if(!empty($query['price']) && is_array($query['price']) && is_numeric($query['price'][0]) && is_numeric($query['price'][1])){
            $__store[] = "`price` >= '".$query['price'][0]."' AND `price` <= '".$query['price'][1]."'";
        }
        if(!empty($query['sorting'])){
            $__sort = $this->sorting[$query['sorting']];
        }
        // if(!empty($query['noPrice'])){
        //     $__store[] = "`price` = 0"; 
        // }
        $sql = "SELECT * FROM `product` WHERE ". implode(' AND ', $__store) ." ORDER BY ".$__sort." LIMIT ".($limit ?? $this->limit);
        return $this->database->fetchAll($sql);
    }
    

    function showCategory($limit){
        return $this->database->fetchAll("SELECT * FROM `category` LIMIT ". $limit ?? $this->limit ." ORDER BY `category`.`name` ASC");
    }
    function showCategoryById($id){
        return $this->database->fetchOne("SELECT * FROM `category` WHERE `id` = {$id}");
    }
    function searchCategory($query, $limit){
        return $this->database->fetchAll("SELECT * FROM `category` WHERE `name` LIKE '%{$query}%' LIMIT ". $limit ?? $this->limit ." ORDER BY `category`.`name` ASC");
    }

    function showProducer($limit){
        return $this->database->fetchAll("SELECT * FROM `producer` LIMIT ". $limit ?? $this->limit ." ORDER BY `producer`.`name` ASC");
    }
    function showProducerById($id){
        return $this->database->fetchOne("SELECT * FROM `producer` WHERE `id` = {$id}");
    }
    function searchProducer($query, $limit){
        return $this->database->fetchAll("SELECT * FROM `producer` WHERE `name` LIKE '%{$query}%' LIMIT ". $limit ?? $this->limit ." ORDER BY `producer`.`name` ASC");
    }

    function insertProduct($data){
        if(count($this->showCategoryById($data['categoryID'])) == 0 || count($this->showCategoryById($data['producerID'])) == 0){
           return false;
        }
        $sql = "INSERT INTO `product` (`name`,`slug`, `description`, `price`, `images`, `memberID`, `categoryID`, `producerID`) VALUES ('".
        addslashes($data['name']) ."', '". $this->createSlug($data['name']) ."', '". trim($data['description']) ."', ". (int)($data['price']) 
        .", '".implode("\n", (isset($data['images']) ? $data['images'] : Array())) ."' , ". $data['memberID'] .", ". $data['categoryID'] .", ". $data['producerID'] .")";
        return $this->database->exec($sql);
    }
    function editProduct($id, $data){        
        if(count($this->showProductById($id)) == 0) return false;
        //UPDATE `product` SET `price` = '10000000', `images` = `images` WHERE `product`.`id` = 1
        $sql = "UPDATE `product` SET ";
        $__store = Array();
        foreach ($this->fields as $field) {
            $__store[] = "`{$field}` = ".(isset($data[$field]) ? "'".addslashes($data[$field])."'": "`{$field}`");
        }
        $sql .= implode(", ", $__store)." WHERE `product`.`id` = {$id}";
        return $this->database->exec($sql);
    }
    function deleteProduct($id){
        if(count($this->showProductById($id)) == 0) return false;
        return $this->database->exec("DELETE FROM `product` WHERE `product`.`id` = {$id}");
    }
}

?>