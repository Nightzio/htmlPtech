<?php
require "constants.php";
session_start();


if(!empty($_POST)){
	if ( isset( $_POST['username'] ) && isset( $_POST['password'] ))
	{
		$user = $_POST["username"];// timo.boll
		$ldap_dn = $user."@sdis60.fr"; // timo.boll@pingpong.fr
		$ldap_pwd = $_POST["password"];
		//$ldap_DN = "DC=SDIS60,DC=FR";
		//ini_set('display_errors', 1);
		//ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		// Connexion au serveur LDAP
		$conn = ldap_connect(LDAP_SERVER) or die("Impossible de se connecter au serveur LDAP.");
		ldap_set_option($conn, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		if ($conn) {
			

			// LDAP
			$ldapbind = ldap_bind($conn,$ldap_dn,$ldap_pwd);
			if ($ldapbind) {
			
				// Recherche AD
				$filter ="(sAMAccountName=" .$user.")";
				$attr = array("memberof","givenname","sn","mail","distinguishedname");
				$result = ldap_search($conn,LDAP_DN,$filter,$attr) or exit ("impossible de rechercher dans le LDAP");
				$entries = ldap_get_entries($conn,$result);
				$memberof = $entries[0]['memberof'];
				$givenname = $entries[0]['givenname'][0]." ".$entries[0]['sn'][0];// timo boll
				echo "Connexion reussi pour ".$givenname. "<BR />";
				echo "<BR>";
				$isMember = false;
				
				//nom du groupe dans l'AD 
				
				foreach($memberof as $group){
					$groupNames = explode(",",$group);
					$groupName = substr($groupNames[0],3);						
					if($groupName == DRONE_GROUP) $isMember = true;
				}
				if($isMember){
					echo "vous êtes Membre du groupe ".DRONE_GROUP. " ! <a href='".PAGE_INDEX."'>Acces au Stream</a> ";
					$_SESSION['username'] = $givenname;
					$_SESSION['loggedin'] = true;
					$_SESSION['message'] = "";
					
					
					header('Location:'.PAGE_INDEX);
					exit(); 
				} 
			}
			else
			{
				$_SESSION['message'] = "Identifiants Incorrects";
				echo "Droits invalides !!";
				header('Location:'.PAGE_LOGIN);
					exit(); 
			}
	
		}
	}
}





		
	
?>