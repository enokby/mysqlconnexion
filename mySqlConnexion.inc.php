<?php
class MySqlConnexion {
	private $mySqlHost;
	private $mySqlUser;
	private $mySqlPass;
	private $mySqlBd;
	public $base;
	public $requette;
	public $resultat;
	
	function __construct($fichierParametres){		
		require_once($fichierParametres);
		$this->mySqlHost = HOST;
		$this->mySqlUser = USER;
		$this->mySqlPass = PASS;
		$this->mySqlBd = DB;
		try{
			$idConn = new mysqli($this->mySqlHost,$this->mySqlUser,$this->mySqlPass,$this->mySqlBd); 
			if(!$idConn) { 
				throw new Exception("Echec Connexion Bd");
				} else $this->base = $idConn;
			}
		catch(Exception $exeption){
			print $exeption->getMessage();
			}			
		}

	function deconnecter(){//appele une seule fois dans un fichier.
		$this->base->close(); 
		}	
		
	function exeRequette($mode){ //select mode :1, insert,update mode: 2
		try{
			$tampon = $this->base->query($this->requette);
			if(!$tampon && $mode != 2) { 
				throw new Exception("Echec Execution Requette");
				} else $this->resultat = $tampon;
			}
		catch(Exception $exeption){
			print $exeption->getMessage();
			}		
		}
		
	function entreeSuivante(){
		if($this->resultat){
			$r = $this->resultat;
			return $r->fetch_object();
			}
		else
			return 0;
		}
		
	function operationBd($req){ //select
		$this->requette = $req;
		$this->exeRequette(1);
		return $this->resultat;		
		}

	function operationBdInsert($req){ //insert update
		$this->requette = $req;
		$this->exeRequette(2);
		return $this->resultat;		
		}		
		
	}
	
?>
