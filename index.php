<?php
session_start();
include_once 'lib/util.php'; 
$mensagem = "";
$acao = "";
$token_valido = false;
$util = new Util();

foreach($_POST as $key => $value) {
	$_POST[$key] = $util->filtro($value);
}

if (isset($_POST["acao"])){
	$acao = $_POST["acao"];	
}

if ($acao == "enviar"){
	//Validar o token antes de gravar
	if (isset($_SESSION["LGcmp"])){
		$frmID = $_SESSION["LGcmp"] . "frmIDL";
		if (isset($_POST[$frmID])){
			if (isset($_SESSION["LGfrmsec"])){
				if ($_POST[$frmID] == $_SESSION["LGfrmsec"]){
					$token_valido = true;
				}
			}
		}
	}
	
	if ($token_valido){
		if (isset($_POST["login"]) && isset($_POST["senha"])){
			$login = $_POST["login"];
			$senha = $_POST["senha"];
			if ($login == "MONTAR" && $senha == "SITE"){
				$_SESSION["sessao_logado"]="OK";
				header("Location: admin.php");
				exit();
			} else {	
				$mensagem = "Senha inválida!";	
			}
		} else {
			$mensagem = "Não foram enviadas informações!";	
		}
	} else {
		$mensagem = "Houve um problema ao receber os dados...";	
	}
}
//Gerar token de seguranca
$campo_token =  rand();
$token = md5(uniqid(rand(), true));
$_SESSION["LGcmp"] = $campo_token;
$_SESSION["LGfrmsec"] = $token;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>:: MONTAR SITE ::</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
  <meta name="author" content="Bins - Desenvolvimento de sistemas">
  <meta name="description" content="Portfólio Bins - Desenvolvimento de sistemas para a web" />
  <meta name="keywords" content="Sistemas, Sites, PHP, ASP Clássico, SQL, MySQL, Mobile" />
</head>

<body id="index">

<div class="container">
    <div class="row" id="login">
    	<div class="col-12 d-flex justify-content-center ">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Admin</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" method="POST" onSubmit="return checkform_login(this);">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="Login" name="login" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Senha" name="senha" type="password" value="">
			    		</div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
			    	</fieldset>
					<input type="hidden" name="acao" value="enviar" />
					<input type="hidden" name="<?php echo $campo_token;?>frmIDL" value="<?php echo $token?>" />
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>
   <script src="js/jquery-3.4.1.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/login.js"></script>
   <script type="text/javascript">
   <?php
	if ($mensagem){
	?>
	alert('<?php echo $mensagem?>');
	<?php
	}
	?>
	</script>	
</body>

</html>