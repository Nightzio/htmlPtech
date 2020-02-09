<?php
require "constants.php";
session_start();

//---------------------------------------------------------------------------
// /!\ décommenter les lignes ci dessous pour réactiver la page de connexion 
//----------------------vvvv-------------------------------------------------

//if(!empty($_POST['disconnect'])) {
//    session_destroy();
//	header('Location:'.PAGE_INDEX);
//	exit;
//}
//if ( isset( $_SESSION['username'] ) ) {
//					$username=$_SESSION['username'];
					$username="Utilisateur"; //affectation temporaire en l'absence d'indentification de connexion. A supprimer. 
					$scanned_dir = array_diff(scandir(URL_REPLAY), array('..', '.'));
					$replays = "";
					$replays = preg_grep('~\.(mp4)$~',$scanned_dir);
					$ReplaysCount = count($replays);
					$replays =array();
					foreach($replays as $r){

							$val=substr($r, 0, strrpos($r, "."));

							array_push($replays,$val);
					}

//}else {
    // Redirect a la  page login
//    header('Location:'.PAGE_LOGIN);
//	exit;
//}

?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="https://vjs.zencdn.net/7.5.5/video-js.css" rel="stylesheet">
	<script src="//vjs.zencdn.net/7.5.5/video.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/videojs-flash@2/dist/videojs-flash.min.js"></script>
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
	<link href="/LineIcons/LineIcons.min.css" rel="stylesheet">

    <!--  support IE8  -->
    <script src="https://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>

    <title>Streaming <?php echo SDIS; ?></title>

</head>
  <body>
  <header>
	    <nav class="navbar navbar-expand-lg navbar-light bg-light">
	  
	   	<a class="navbar-brand" href="#"><?php echo SDIS; ?></a>
		<ul class="navbar-nav mr-auto mt-2 mt-lg-0 ul-hs">
			<!-- Retour -->
			<li class="nav-item dropdown">
<!-- =================================================== -->			
<!-- MODIFIER IP_ADDR par l'adresse IP du serveur utilisé-->
<!-- =================================================== -->		
				<span class="nav-link return" onclick="window.location.href='http://IP_ADDR/'"><span> Retour </span> </span>
			</li>
			<!-- Menu Replay -->
			<li class="nav-item dropdown">
				<span class="dropdown-replays-count" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span>Replay <span class="badge badge-pill badge-danger">&nbsp;</span> </span>
				</span>
			</li>
		</ul>
		<span class="navbar-text mr-2">
			<?php echo $username; ?>
		</span>
		<form class="form-inline my-2 my-lg-0" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			  <button class="btn btn-danger my-2 my-sm-0" type="submit" name="disconnect" id="disconnect" value="disconnect">  <i class="lni-exit"></i></button>
		</form>
	</nav>
  </header>

	  <div class="jumbotron jumbotron-fluid" id="MainContainer">
			<div class="container">
				<h3 class="display-5"> Streaming du <?php echo SDIS; ?> </h1>
				<p class="lead">Rediffusion des streams précédents </p>
			</div>
	  </div>
	  <div id="Main" class="container mt-5">
		<div class="row" id="MainRow">
		</div>
	</div>


    <!-- JavaScript -->
	<script src='https://vjs.zencdn.net/7.5.5/video.js'></script>
    <!-- jQuery , Popper.js, Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
	$(document).ready(function() {
		getReplaysCount();
		getReplaysNames();
		timer3 = setInterval("getReplaysCount()",6000);
		timer4 = setInterval("getReplaysNames()",6000);
		$('.refresh').click(function(){
			var xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("test").innerHTML = this.responseText;
					alert(" nombre de live : "+this.responseText);
					}
			};
			xmlhttp.open("GET", "getreplay.php", true);
			xmlhttp.send();
		});	
	});

<!-- =================================================== -->			
<!-- MODIFIER IP_ADDR dans la chaine (balise <source...) par l'adresse IP du serveur utilisé-->
<!-- =================================================== -->
	$(document).on('click', '.link', function(e) {
		$("#MainRow").append('<div id="videoContainer-'+event.target.id+'" class="pl-3 col"><h5 class="card-title">'+event.target.id+'<span class="btn btn-danger ml-5 close-video" name="'+event.target.id+'"> Fermer</span></h5><video id="my-video-'+event.target.id+'" class="video-js" controls preload="auto" width="340" height="264" poster="img/drones.jpg" data-setup="{}"><source src="http://IP_ADDR/replay/'+event.target.id+'.mp4" type="video/mp4" /><p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that<a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p></video></div>');	
		videojs("my-video-"+event.target.id).ready(function(){
			var myPlayer = this;
			myPlayer.play();
		});
	});
	$(document).on('click', '.close-video', function(e) {
		$("#videoContainer-"+event.target.getAttribute('name')).remove();
	});


		// retourne le nombre de replays disponibles via getreplay.php timer  à 6000 ms
		function getReplaysCount(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText == 0){
						//$('.dropdown').empty();
						$('.dropdown').append('<span class="dropdown-replays-count" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Replay <span class="badge badge-pill badge-danger">&nbsp;</span> </span></span>');
					}
					else{
						$('.dropdown-replays-count').empty();
						$('.dropdown-replays-count').append('<span class="mr-2 nav-link dropdown-toggle">Replay <span class="badge badge-pill badge-success" id="replaysCount"> '+this.responseText+' </span> </span>');
						$('.dropdown').append('<div class="dropdown-menu dropdown-replays" aria-labelledby="navbarDropdownMenuLink"></div>');
					}
				}
			};
			xmlhttp.open("GET", "getreplay.php", true);
			xmlhttp.send();
		}
		
	
		// retourne les noms des streams en cours via getLivesNames.php timer  à 6000 ms
		function getReplaysNames(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$( ".dropdown-replays" ).empty();
					 var names = this.responseText.split(';')
					//document.getElementById("test").innerHTML = names;
					names.forEach(function(name){
						
						$('.dropdown-replays').append('<a href="#" id='+ name+' class="dropdown-item link">'+name+'</a>');
					});
					
					}
			};
			xmlhttp.open("GET", "getReplaysNames.php", true);
			xmlhttp.send();
		}
	
	</script>
  </body>
</html>
