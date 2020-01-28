<?php
class Util {

	public function bloquearPagina() {
		if ($_SESSION["sessao_logado"]!="OK"){
			header("Location: index.php");
			exit();
		}
	}
 
   public function filtro($value) {
		$newVal = trim($value);
		$newVal = htmlspecialchars($newVal);
		//$newVal = mysqli_real_escape_string($newVal);
		if(get_magic_quotes_gpc())  {
			$newVal = stripslashes($newVal);
		}
		$newVal = $this->ValidarDados($newVal);
		return $newVal;
	}
		
	public function ValidarDados($input) {
	  $textoOK=$input;
	  $lixo=array("select", "drop", "shutdown", "where", "create table", "show table", "show tables", ";", "--", "insert", "delet", "delete", "xp_", "&", "--", "'OR USERNAME IS NOT NULL OR USERNAME='", "UNION ALL", "DESC USERS", "ODBC", "SYSCOLUMNS", "SYSTYPES", "SYSOBJECTS", "SYS.OBJECTS", "INFORMATION_SCHEMA.COLUMNS", "INFORMATION_SCHEMA.TABLES", "INFORMATION_SCHEMA.ROUTINES", "ON SELECT ALL FROM WHERE", "UPDATE ", "DECLARE ", "syscolumns");
	  for ($i=0; $i<=count($lixo)-1; $i++) {
		$textoOK=str_replace($lixo[$i], "", $textoOK); 
	  }
	  if (!($textoOK == "" || !isset($textoOK))) {
		$textoOK=str_replace("convert(","",$textoOK);
		$textoOK=str_replace("CONVERT(","",$textoOK);
		$textoOK=str_replace("char(","",$textoOK);
		$textoOK=str_replace("CHAR(","",$textoOK);
		$textoOK=str_replace("'or'1'='1'","",$textoOK);
		$textoOK=str_replace("'1='1'","",$textoOK);
		$textoOK=str_replace("1=1","",$textoOK);
		$textoOK=str_replace("1'1","",$textoOK);
	  }
	  //Remover HTML do texto que foi validado
	  $textoOK=$this->RemoveHTML($textoOK); 
	  //Remover JavaScript do texto que foi validado
	  $textoOK=$this->clearJS($textoOK); 
	  return $textoOK;
	}
	
	public function RemoveHTML($strText) {
		return strip_tags($strText);
	}	

	public function clearJS($s) {
		 $do = true;
		while ($do) {
			$start = stripos($s,'<script');
			$stop = stripos($s,'</script>');
			if ((is_numeric($start))&&(is_numeric($stop))) {
				$s = substr($s,0,$start).substr($s,($stop+strlen('</script>')));
			} else {
				$do = false;
			}
		}
		return trim($s);

	}
 
}
?>