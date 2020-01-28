<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'lib/usuarios.php';  
include_once 'lib/util.php'; 
$usuarios = new Usuarios();
$util = new Util();
$util->bloquearPagina();
$criterio = "";

foreach($_POST as $key => $value) {
	$_POST[$key] = $util->filtro($value);
}
foreach($_GET as $key => $value) {
	$_GET[$key] = $util->filtro($value);
}

if (isset($_GET["acao"])){
	if ($_GET["acao"] == "EXCLUIR"){
		$codigo=$util->filtro($_GET["codigo"]);
		$resultado = $usuarios->Excluir($codigo);
		if ($resultado){
			$_SESSION["mensagem"] = "Nome excluído!";
		} else {
			$_SESSION["mensagem"] = "Houve um problema ao excluir este registro!";
		}
		header("Location: admin.php");
		exit();
	}
}

if (isset($_POST["acao"])){
	
	if (isset($_POST["nome"]) && isset($_POST["codigo"])){
		$nome=$util->filtro($_POST["nome"]);
		$codigo=$util->filtro($_POST["codigo"]);
		$nome_existe = $usuarios->CadastroExistente($nome, $codigo);
		$nome_valido = $usuarios->ValidarNome($nome);
				
		if ($nome_existe){
			$_SESSION["mensagem"] = "Esse nome já foi cadastrado antes!";
			header("Location: admin.php");
			exit();
		} 
		
		if (!$nome_valido){
			$_SESSION["mensagem"] = "Por favor verifique o nome informado, você deve informar nome e sobrenome e o campo deve conter apenas letras ou espaços!";
			header("Location: admin.php");
			exit();
		} 
		
		if ($_POST["acao"] == "INSERIR"){
			$resultado = $usuarios->Inserir($nome);
			if ($resultado){ 
				$_SESSION["mensagem"] = "Usuário cadastrado com sucesso!";
			} else {
				$_SESSION["mensagem"] = "Houve um problema ao inserir um novo registro!";
			}
			header("Location: admin.php");
			exit();
		}
		if ($_POST["acao"] == "ATUALIZAR"){
			$resultado = $usuarios->Atualizar($nome, $codigo);
			if ($resultado){ 
				$_SESSION["mensagem"] = "Usuário atualizado com sucesso!";
			} else {
				$_SESSION["mensagem"] = "Houve um problema ao atualizar este registro!";
			}
			header("Location: admin.php");
			exit();
		}
		
	}
}
$resultados = $usuarios->Listar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>:: MONTARSITE ::</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/aviso.css" rel="stylesheet">
  <meta name="author" content="Bins - Desenvolvimento de sistemas">
  <meta name="description" content="Portfólio Bins - Desenvolvimento de sistemas para a web" />
  <meta name="keywords" content="Sistemas, Sites, PHP, ASP Clássico, SQL, MySQL, Mobile" />
</head>

<body id="index">

  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="admin.php" rel="tag">:: MONTARSITE ::</a>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="admin.php" rel="tag">Usuários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php" rel="tag">Sair</a>
        </li>
      </ul>
    </div>
  </nav>

  <section class="jumbotron text-center">
    <div class="container">
      <h1 class="jumbotron-heading">Usuários</h1>
      <p class="lead text-muted">Listagem de usuários do sistema</p>
    </div>
  </section>
  <div class="container">
	<div class="row">
		<div class="col">
			<button type="button" class="btn btn-success openModal" data-href="modal_usuario.php">Adicionar novo usuário</button>
			<hr/>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-right">
			:: <a href="javascript:;" onclick="$('.buttons-print').click();"><i class="fa fa-print"></i> Imprimir </a>
			:: <a href="javascript:;" onclick="$('.buttons-copy').click();"><i class="fa fa-print"></i> Copiar </a>
			:: <a href="javascript:;" onclick="$('.buttons-pdf').click();"><i class="fa fa-file-pdf-o"></i> PDF </a>
			:: <a href="javascript:;" onclick="$('.buttons-excel').click();"><i class="fa fa-file-excel-o"></i>  Excel</a>
			:: <a href="javascript:;" onclick="$('.buttons-csv').click();"><i class="fa fa-file-excel-o"></i>  CSV</a>
			<hr/>
		</div>
	</div>

			
    <div>
		<table class="table" id="tblUsuarios">
		  <thead>
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">Nome</th>
			  <th scope="col">Data de Cadastro</th>
			  <th scope="col">Data de Atualização</th>
			  <th scope="col">Atualizar</th>
			  <th scope="col">Excluir</th>
			</tr>
		  </thead>
		  <tbody>
			<?php
			if (count($resultados)==0){
			?>
			<tr>
				<td colspan="6" align="center">Não existem nomes cadastrados</td>
			</tr>
			<?php
			}			
			foreach ($resultados as $row) {
			?>
			<tr>
			  <th scope="row"><?php echo $row["usu_cod"]?></th>
			  <td><?php echo $row["usu_nome"]?></td>
			  <td><?php echo date('d/m/Y H:i:s', strtotime($row["usu_data_cad"]))?></td>
			  <td>
			  <?php 
			  if(!empty((int)$row['usu_data_atu'])){
				echo date('d/m/Y H:i:s', strtotime($row["usu_data_atu"]));
			  }
			  ?>
			  </td>
			  <td><button type="button" class="btn btn-primary openModal" data-href="modal_usuario.php?codigo=<?php echo $row["usu_cod"]?>">Atualizar</button></td>
			  <td><a href="admin.php?acao=EXCLUIR&codigo=<?php echo $row["usu_cod"]?>" class="btn btn-danger"  onClick="return confirmarClique(); ">Excluir</button></td>
			</tr>
			<?php
			}
			?>
		  </tbody>
		</table>
	</div>
	<div class="modal-container"></div>
	<?php
	if (isset($_SESSION["mensagem"])){
	?>
	<div id="snackbar"><?php echo $_SESSION["mensagem"]?></div>
	<?php
	}
	?>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/usuario.js"></script>
    <script src="js/datatables/datatables.min.js" type="text/javascript"></script>
	<script type="text/javascript">
		$('.openModal').on('click',function(){
			var dataURL = $(this).attr('data-href');
				$('.modal-container').load(dataURL,function(){
				$('#modalUsuario').modal({show:true});
			});
		}); 
		<?php
		if (isset($_SESSION["mensagem"])){
		?>
		var x = document.getElementById("snackbar");
		x.className = "show";
		setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		<?php
		}
		unset($_SESSION["mensagem"]);
		?>
		
		var table = $('#tblUsuarios');

		var oTable = table.dataTable({
			autoWidth: false,
			order: [],
			paging: false, //hide Pagination
			bFilter: false, //hide Search bar
			bInfo: false, // hide showing entries
			paging:   false,
			info:     false,
			dom: 'Bfrtip',
			buttons: [
				{ extend: 'print', className: 'btn dark btn-outline', exportOptions: {columns: [0, 1, 2, 3]}},
				{ extend: 'copy', className: 'btn red btn-outline', exportOptions: {columns: [0, 1, 2, 3]}},
				{ extend: 'pdf', className: 'btn green btn-outline', orientation: 'landscape', title: 'usuarios', exportOptions: {columns: [0, 1, 2, 3]}},
				{ extend: 'excel', className: 'btn yellow btn-outline', title: 'usuarios', exportOptions: {columns: [0, 1, 2, 3]}},
				{ extend: 'csv', className: 'btn purple btn-outline', title: 'usuarios', exportOptions: {columns: [0, 1, 2, 3]}},
				{ extend: 'colvis', className: 'btn dark btn-outline', text: 'Columns', exportOptions: {columns: [0, 1, 2, 3]}}
			]
		});
		$('.dt-buttons').hide();
	</script>
</body>

</html>