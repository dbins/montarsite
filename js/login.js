function checkform_login ( form )	{
	var continuar = true;
	var mensagem = "";

	if (form.login.value == "") {
		mensagem = mensagem + 'Preencha o login\n';
		form.login.style.backgroundColor='#FFFF99';
		continuar = false;
	} 
	
	if (form.senha.value == "") {
		mensagem = mensagem + 'Preencha a senha\n';
		form.senha.style.backgroundColor='#FFFF99';
		continuar = false;
	} 
	
	if (continuar) {
		return true;
	} else {
		alert(mensagem);
		return false;
	}
}