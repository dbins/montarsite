function checkform_usuario ( form )	{
	var continuar = true;
	var mensagem = "";

	if (form.nome.value == "") {
		mensagem = mensagem + 'Preencha o nome\n';
		form.nome.style.backgroundColor='#FFFF99';
		continuar = false;
	} else {
		//Funciona apenas com nome e 1 sobrenome
		//var expressao = /^[a-zA-Z]+ [a-zA-Z]+$/;
		var conteudo = form.nome.value.split(' ');
		
		if (conteudo.length < 2){
			mensagem = mensagem + 'Por favor informe o seu nome e sobrenome\n';
			form.nome.style.backgroundColor='#FFFF99';
			continuar = false;
		} else {
			var nome_valido = false;
			let regex = /^[a-záàâãéèêíïóôõöúçñ]+$/i;
			conteudo.some(function (value, index, _arr) {
				nome_valido = value.split(/ +/).every(parte => regex.test(parte));
				if (!nome_valido) {
					return true;
				}
			});
			if (!nome_valido){
				mensagem = mensagem + 'Por favor verifique o nome informado, você deve informar nome e sobrenome e o campo deve conter apenas letras ou espaços!\n';
				form.nome.style.backgroundColor='#FFFF99';
				continuar = false;
			}
		}			
	}
	
	if (continuar) {
		return true;
	} else {
		alert(mensagem);
		return false;
	}
}

function confirmarClique() {
	if(confirm("Você deseja excluir este registro?")) {
		return true;
	} else {
		return false;
	}
};