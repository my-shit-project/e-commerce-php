<?php
class Member
{
    private $database;
    function __construct($database){
        $this->database = $database;
    }
    
    function exitEmail($email){        
        $user = $this->database->fetchOne("SELECT COUNT(*) AS EXIT_USER FROM `member` WHERE email ='". addslashes($email) ."'");
        return $user['EXIT_USER'] == 1;
    }

    function checkLogin($email, $password){        
        $user = $this->database->fetchOne("SELECT COUNT(*) AS EXIT_USER , `pass` = '". md5(md5($password)) ."' AS CORRECT_PASS, id FROM `member` WHERE email ='". addslashes($email) ."'");
        return $user;
    }

    function getInfo($id){        
        $user = $this->database->fetchOne("SELECT * FROM `member` WHERE id = {$id}");
        return $user;
    }

    function createMember($email, $password, $name){ 
        $sql = "INSERT INTO `member` (`email`, `pass`, `name`) VALUES ('". addslashes($email)."', '". md5(md5($password)) ."', '".addslashes($name)."');"; 
        return $this->database->insert($sql);
    }
}

?>