<?php 
//author : Younes zaidi
 class config{

   function _connection(){
	   $db = new PDO('mysql:host=localhost;dbname=blog','root','');
	   return $db;
   }
   
   function _select($db,$query){
	   $query = $db->query($query);
	   $result = $query->fetchAll(PDO::FETCH_ASSOC);
	   return $result;
   }
   
   function _update($db,$query){

	   $exe  = $db->prepare($query);
	   $res  = $exe->execute();
       return $res;   
   }


}



?>