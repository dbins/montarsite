<?php
include_once 'lib/usuarios.php';  
$usuarios = new Usuarios();
$codigo = 0;
$nome = "";
$comando = "INSERIR";
if (isset($_GET["codigo"])){
	if (is_numeric($_GET["codigo"])){
		$codigo = $_GET["codigo"];	
	}
}
$resultado = $usuarios->RetornarUsuario($codigo);
if (isset($resultado[0]["usu_nome"])){
	$nome = $resultado[0]["usu_nome"];	
	$comando = "ATUALIZAR";
}
?>
<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog" aria-labelledby="modalUsuario" aria-hidden="true">
	<form method="POST" onSubmit="return checkform_usuario(this);">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastro de usuário</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				
					<div class="mb-3">
						<label for="nome">Nome</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">N</span>
							</div>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="nome"  maxlength="100" value="<?php echo $nome;?>">
						</div>
					</div>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-primary">Salvar</button>
			  </div>
			</div>
		</div>
		<input type="hidden" name="codigo" value="<?php echo $codigo;?>">
		<input type="hidden" name="acao" value="<?php echo $comando;?>">
	</form>
</div>