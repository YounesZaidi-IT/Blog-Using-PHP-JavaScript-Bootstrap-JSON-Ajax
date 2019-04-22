<?php 
//author : Younes zaidi
    session_start();
	include('article.php');
	$article = new Article();
    if(isset($_SESSION['Username'])){
		 $function = $_SESSION['Type']; //  [administrateur,editeur]
		 $user     = $_SESSION['Username'];
		 $idUser   = $_SESSION['id'];
	}

	if(isset($_POST['Action'])){
		$article = new Article();
		$image = '';
		if(isset($_FILES['image']['tmp_name']) && !empty($_FILES['image']['tmp_name'])){
		$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
		}
		if($_POST['Action'] == 'add'){
			$desc   = $_POST['desc_Article'];
			$title  = $_POST['titleArticle'];
			$date   = date('Y-m-d H:i:s');
			$user   = $_SESSION['Username'];
			$article->_init('',$title,$desc,$date,$idUser,$image);
			$article->CreateArticle();
		}elseif($_POST['Action'] == 'View'){
            $current    = $article->SelectArticleOne($_POST['id']);
			$result     = "<div class='row' ><h6 style='margin-left:10px'>".$current['title']."</h6><img style='with:50%;height:10%' class='card-img-top' src='".'data:image/png;base64,' . base64_encode($current["img"])."'/> <p style='margin-top:20px;margin-left:10px'><div style='font-size:14px;padding-left:10px'>".$current['body']."</div></p></div><code style='witdh:100%'>".$current['date']."</code>";
			echo $result;
			die;
		}elseif($_POST['Action'] == 'delete'){
			$article->DeleteArticle($_POST['id']);
		}elseif($_POST['Action'] == 'update_get'){
			$current = $article->SelectArticleOne($_POST['id']);
			$json_data = array("id" => $current['id'],"title"=>$current['title'],"desc"=>$current['body'],"date"=>$current['date'],"img"=>base64_encode($current['img']));
			echo json_encode($json_data);
			die;
		}elseif($_POST['Action'] == 'update'){
			$title = $_POST['titleArticleUpdate'];
			$desc  = $_POST['desc_Article_update'];
			$id    = $_POST['update_id'];
			$date  = date('Y-m-d');
			$user  = $_SESSION['Username'];
			if(empty($image)){
			$image = addslashes(base64_decode($_POST['imgU']));
			}
			$article->_init($id,$title,$desc,$date,$idUser,$image);
			$article->UpdateArticle();
		}
	}
?>  

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport"    content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author"      content="Younes Zaidi"/>
	<title>Blog Development</title>
	
    <link href="images/blog/1Icon.gif"         rel="shortcut icon">
    <link href="/BlogTp/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/BlogTp/css/album.css"         rel="stylesheet"/>
	<link href="/BlogTp/css/product.css"       rel="stylesheet"/>
    <style>
	@media (min-width: 992px) {
		.modal-dialog {
			max-width: 42%;
		}
	}
	.container {
		max-width: 1390px !important;
	}	
	@media (min-width: 768px)
	.p-md-5 {
		padding: 2rem!important;
	}	
	</style>
  </head>
  <body>
    <header>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
		    <img src="images/blog/1Icon.gif" style="width:30px">
            <strong>Blog Development</strong>
          </a>
		  <?php  if(!isset($_SESSION['Username'])){ ?>
          <a class="navbar-toggler" href='/BlogTp/login.php' id='login'>
            <span class="navbar-toggler-icon" style='font-size:13px'> </span><span style="font-size:13px;color: #f8f9fa;"> Login</span>
          </a>
		  <?php }else{ ?>
          <a class="navbar-toggler" href='/BlogTp/logout.php' id='logout'>
            </span><span style='font-size:12px;'>Hello <?php echo $_SESSION['Username']; ?> - <span style='color:#f33823;font-size:14px'> Logout</span></span>
          </a>
		  <?php }?>
        </div>
      </div>
    </header>
    <main role="main">
      <div class="position-relative overflow-hidden p-3 p-md-3 m-md-3 text-center bg-light">
         <div class="col-md-5 p-lg-5 mx-auto my-5">
          <h1 class="display-5 font-weight-normal">Blog Development</h1>
           <p class="lead font-weight-normal">The powerful programming language.</p>
          <?php if(isset($function) &&  $function == 'administrateur'){?>
		    <p><a href="#" class="btn btn-primary my-2"  data-toggle="modal" data-target="#myModal">Add New Post</a></p>
		  <?php }?>         </div>
        <div class="product-device box-shadow d-none d-md-block"></div>
        <div class="product-device product-device-2 box-shadow d-none d-md-block"></div>		
      </div>

      <div class="album py-5 bg-light">
       <div class="container">
		<div class='row'>
		<?php 
		    $Article = $article->SelectArticle();
		    foreach($Article as $key){
		     echo"
		     <div class='col-md-4'>
              <div class='card mb-4 box-shadow'>
                <img class='card-img-top' src='".'data:image/png;base64,'.base64_encode($key["img"])."' style='width:100px225'alt='Card image cap'>
                <div class='card-body'>
                  <span class='card-text'>".$key['title']."</span><br>
				  <span style='color:#676767;font-size:11px'>". substr($key['body'], 0, 200)." ...</span>
                  <div class='d-flex justify-content-between align-items-center'>
                    <div class='btn-group'>";
					if(isset($function) &&  $function == 'administrateur' || isset($function) &&  $function == 'editeur'){
                      echo "<form method='POST' action='index.php'>";
					  		if($function == 'administrateur'){
							 echo "<button type='submit' name='Action' value='delete' class='btn btn-sm btn-outline-danger'>Delete</button> ";
							}
					  echo "<button type='button' data-toggle='modal' data-target='#myModalUpdate' class='btn btn-sm btn-outline-secondary'  onclick='update(\"".$key["id"]."\")'>Edit</button>
							   <input  type='hidden' name='id'     value='".$key["id"]."'></input>
							</form>";
			        }
					echo "&nbsp;<button type='button' data-toggle='modal' data-target='#myModalView' class='btn btn-sm btn-outline-secondary' onclick='view_article(\"".$key["id"]."\")'>View</button>
                    </div>
					<small class='text-muted'><code>".$key['date']."</code></small>
                  </div>
                </div>
              </div>
             </div>"; 
		    }
		?>
		</div>
       </div>
      </div>
    </main>

    <footer class="text-muted">
      <div class="container">
        <p class="float-right">
          <a href="#">Back to top</a>
        </p>
        <div class="container-fluid clearfix">
         <span class="text-muted d-block text-center text-sm-left d-sm-inline-block" style="color: #3a3a3a!important;font-size:12px">Copyright ©
         <a href="" class="text-danger" style="font-weight:600" target="_blank">Younes Zaidi</a>. All rights reserved.</span>
        </div>
      </div>
    </footer>
	
 <?php if(isset($function) &&  $function == 'administrateur'){?>	
 <!---Add new Article---->
   <div id="myModal" class="modal fade" role="dialog">
    <form method='post' action='index.php' enctype="multipart/form-data">
	 <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
          <h6 class="modal-title">Add New Post</h6>
         </div>
         <div class="modal-body">
		 <div class='card mb-4 box-shadow'>
           <input type='text' class='form-control' id='titleArticle' name='titleArticle' placeholder='Title'/>
		 </div>
		  <div class='card mb-4 box-shadow'>
		   <textarea id='desc_Article' rows="4" cols="70" class='form-control' name='desc_Article' placeholder='Description'></textarea>
		  </div> 
		    <input type='file' class='form-control'  name='image'/>
         </div>
        <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" name='Action' value='add'>Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
     </div>
	</form>
   </div>
  <?php }?>  
 <?php if(isset($function) &&  $function == 'administrateur' || isset($function) && $function == 'editeur'){?>	  
 <!---Update Article----->
   <div id="myModalUpdate" class="modal fade" role="dialog">
    <form method='post' action='index.php' enctype="multipart/form-data">
	 <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
          <h6 class="modal-title">Update Post <span id='update_id_title'></span> <span id='dateadd'></span></h6>
         </div>
         <div class="modal-body">
		 <div class='card mb-4 box-shadow'>
           <input id='titleArticleUpdate' name='titleArticleUpdate' type='text' class='form-control' placeholder='Title'/>
		   <input type='hidden' id='update_id' name='update_id'/>
		 </div>
		  <div class='card mb-4 box-shadow'>
		   <textarea id='desc_Article_update' rows="4" cols="70" class='form-control' name='desc_Article_update' placeholder='Description'></textarea>
		  </div> 
		    <input type='file' class='form-control'  name='image'/>
			<input type='hidden' id='imgU' name='imgU' />
         </div>
        <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" name='Action' value='update'>Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
     </div>
	</form>
   </div>
  <?php }?>
  <!---View Article---->
  <div id="myModalView" class="modal fade" role="dialog">
	<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
		  <div id='DivmyModalView'></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
   </div>
    <!-- JavaScript
	================================================== 
	-->
  <script src="/BlogTp/js/jquery-3.1.1.min.js"></script>	
  <script src="/BlogTp/js/popper.min.js"></script>
  <script src="/BlogTp/js/bootstrap.min.js"></script>
  <script src="/BlogTp/js/holder.min.js"></script>
  <script src="/BlogTp/js/misc.js"></script>
  </body>
  <script>
  
    function view_article(id){
		$.ajax({
            url:"/BlogTp/index.php",
	        type: "POST",
            data:{ "Action":"View","id":id},
            success:function(data) {
				$('#DivmyModalView').html(data);
	        }
	    });
	}
     
	function update(id){
		$.ajax({
            url:"/BlogTp/index.php",
	        type: "POST",
            data:{ "Action":"update_get","id":id},
            success:function(data) {
				console.log(data);
				var data =JSON.parse(data);
				$('#update_id_title').html(data.title+' - '+data.id);
				$('#update_id').val(data.id);
				$('#titleArticleUpdate').val(data.title);
				$('#desc_Article_update').html(data.desc);
				$('#imgU').val(data.img);
				$('#dateadd').html('<br><code>'+data.date+'</code>');
	        }
	    });	 
	}
  </script>
</html>


