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
					$scanned_dir = array_diff(scandir(URL_HLS), array('..', '.'));
					$streams = "";
					$streams = preg_grep('~\.(m3u8)$~',$scanned_dir);
					$LivesCount = count($streams);
					$lives =array();
					foreach($streams as $l){

							$val=substr($l, 0, strrpos($l, "."));

							array_push($lives,$val);
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
			<!-- Menu Live -->
			<li class="nav-item dropdown">
				<span class="dropdown-lives-count" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span>Hors-ligne <span class="badge badge-pill badge-danger">&nbsp;</span> </span>
				</span>
			</li>
			<!-- Menu Replay -->
			<li class="nav-item">
<!-- ====================================================================================== -->			
<!-- MODIFIER IP_ADDR dans la chaine (balise <source...) par l'adresse IP du serveur utilisé-->
<!-- ====================================================================================== -->
				<span class="nav-link replays-count" onclick="window.location.href='http://IP_ADDR/replay.php'"> Replay <span class="badge badge-pill badge-danger">&nbsp;</span> </span>
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
				<p class="lead">Bienvenue <?php echo $username; ?> </p>
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
		getLivesCount();
		getLivesNames();
		getReplaysCount();
		timer = setInterval("getLivesCount()", 6000);
		timer2 = setInterval("getLivesNames()",6000);
		timer3 = setInterval("getReplaysCount()",6000);
		$('.refresh').click(function(){
			var xmlhttp = new XMLHttpRequest();
			
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					document.getElementById("test").innerHTML = this.responseText;
					alert(" nombre de live : "+this.responseText);
					}
			};
			xmlhttp.open("GET", "getlives.php", true);
			xmlhttp.send();
			xmlhttp.open("GET", "getreplay.php", true);
			xmlhttp.send();
		});	
	});
<!-- ====================================================================================== -->			
<!-- MODIFIER IP_ADDR dans la chaine (balise <source...) par l'adresse IP du serveur utilisé-->
<!-- ====================================================================================== -->
	$(document).on('click', '.link', function(e) {
		$("#MainRow").append('<div id="videoContainer-'+event.target.id+'" class="pl-3 col"><h5 class="card-title">'+event.target.id+'<span class="btn btn-danger ml-5 close-video" name="'+event.target.id+'"> Fermer</span></h5><video id="my-video-'+event.target.id+'" class="video-js" controls preload="auto" width="340" height="264" poster="img/drones.jpg" data-setup="{}"><source src="http://IP_ADDR/hls/'+event.target.id+'.m3u8" type="application/x-mpegURL" /><p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that<a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p></video></div>');	
		videojs("my-video-"+event.target.id).ready(function(){
		var myPlayer = this;
		myPlayer.play();

	});
	$(document).on('click', '.close-video', function(e) {
		$("#videoContainer-"+event.target.getAttribute('name')).remove();
	});
});
		// retourne le nombre de streams en cours via getlives.php timer  à 6000 ms
		function getLivesCount(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText == 0){
						$('.dropdown').empty();
						$('.dropdown').append('<span class="dropdown-lives-count" href="#"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Hors-ligne <span class="badge badge-pill badge-danger">&nbsp;</span> </span></span>');
						document.title = 'Streaming : Hors-ligne';
					}
					else{
						$('.dropdown-lives-count').empty();
						$('.dropdown-lives-count').append('<span class="mr-2 nav-link dropdown-toggle">En Direct <span class="badge badge-pill badge-success" id="liveCount"> '+this.responseText+' </span> </span>');
						$('.dropdown').append('<div class="dropdown-menu dropdown-lives" aria-labelledby="navbarDropdownMenuLink"></div>');
						document.title = 'Streaming : En Direct ( '+this.responseText+')';
					} 
				}
			};
			xmlhttp.open("GET", "getlives.php", true);
			xmlhttp.send();
		}
		// retourne les noms des streams en cours via getLivesNames.php timer  à 6000 ms
		function getLivesNames(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					$( ".dropdown-lives" ).empty();
					 var names = this.responseText.split(';')
					//document.getElementById("test").innerHTML = names;
					names.forEach(function(name){
						
						$('.dropdown-lives').append('<a href="#" id='+ name+' class="dropdown-item link">'+name+'</a>');
					});
					
					}
			};
			xmlhttp.open("GET", "getLivesNames.php", true);
			xmlhttp.send();
		}

		// retourne le nombre de replays disponibles via getreplay.php timer  à 6000 ms
		function getReplaysCount(){
			var xmlhttp = new XMLHttpRequest();
			xmlhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					if(this.responseText == 0){
						$('.dropdown').empty();
						$('.dropdown').append('<span class="replays-count" href="/replay.php"  role="button"><span>Replay <span class="badge badge-pill badge-danger">&nbsp;</span> </span></span>');
					}
					else{
						$('.replays-count').empty();
						$('.replays-count').append('<li><span class= "replays-count" href="/replay.php" role="button">Replay <span class="badge badge-pill badge-success" id="replaysCount"> '+this.responseText+' </span> </span></li>');

					}
				}
			};
			xmlhttp.open("GET", "getreplay.php", true);
			xmlhttp.send();
		}

	</script>
  </body>
</html>
