<?php 
//author : Younes zaidi

  include ('config.php');
  abstract class Blog {
	   
       function select($query){
			$select = config::_select(config::_connection(),$query);
			return $select;
	   }
	   
	   function update($query){
			$select = config::_update(config::_connection(),$query);
			return $select;
	   }
	   
   }















?>