<?php 
//author : Younes zaidi
include ('blog.php');    
class Article extends Blog{
	
	    public $id;
		public $title;
		public $desc;
		public $date;
		public $user;
		public $img;
		
	    function _init($id,$title,$desc,$date,$user,$img){
			$this->id    = $id;
			$this->title = $title;
			$this->desc  = $desc;
			$this->date  = $date;
			$this->user  = $user;
			$this->img  =  $img;
		}
		
		function SelectArticleOne($idA){
			$query = blog::select('select * from article where id='.$idA.' ');
			return current($query);
		}
		
		function SelectArticle(){
			$query = blog::select('select * from article order by date desc');
			return $query;
		}
		
		function CreateArticle(){
			$query = blog::update('insert into article(title,body,date,user,img) values("'.$this->title.'","'.$this->desc.'","'.$this->date.'",'.$this->user.',"'.$this->img.'") ');
			if($query)
				return $query;
			else
				return false;
		}
		
		function DeleteArticle($idA){
			$query = blog::update('delete from article where id='.$idA.' ');
			if($query)
				return true;
			else
				return false;

		}
		
		function UpdateArticle(){
			$query = blog::update('update article set title="'.$this->title.'",body="'.$this->desc.'",img="'.$this->img.'" where id='.$this->id.' ');
			if($query)
				return true;
			else
				return false;

		}
}











?>