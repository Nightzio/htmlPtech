<?php
require "constants.php";


session_start();

if($_SESSION['loggedin']){
	$_SESSION['message'] = "";
	header('Location:'. PAGE_INDEX);
	exit();
} 
if(!empty($_SESSION['message'])){
	 $message = $_SESSION['message'];
	 
 }
 else{
 }
?>
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link href="css/signin.css" rel="stylesheet">
<title>Streaming <?php echo SDIS ;?></title>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
  </head>
  <body class="text-center">
    <form class="form-signin" action="Auth_ldap.php" method="post">
  <img class="mb-4" src="<?php echo  LOGO; ?>" alt="" width="120" height="150" />
  <h1 class="h3 mb-3 font-weight-normal redSDIS">Se connecter</h1>
  <label for="username" class="sr-only">Identifiant</label>
  <input type="text" id="username" name="username" class="form-control" placeholder="Identifiant" required autofocus />
  <label for="Password" class="sr-only">Mot de passe</label>
  <input type="password" id="password" name="password"  class="form-control" placeholder="Mot de Passe" required />
<?php
 if(!empty($message)){
	 echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  <strong>'.$message.'</strong>
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	</div>';
 }
  
?>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
  <p class="mt-5 mb-3 text-muted"><?php echo SDIS ;?> &copy; 2019</p>
</form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>