$(document).ready(function () {

	$("#salvarUsuario").click( function () {

		
		var cadNome = $('#userCadNome').val();
		var cadEmpresa = $('#userCadEmpresa').val();
		var cadLogin = $('#userCadLogin').val();
		var cadSenha = $('#userCadSenha').val();
		var cadNvlAcesso = $('#userCadNvlAcesso').val();
		
		if(cadNome && cadEmpresa && cadLogin && cadSenha && cadNvlAcesso){
			$.ajax({
				url: "../controller/ajax/cadastro_usuario.php",
				method: "POST",
				data: {
					cadNome		: cadNome,
					cadEmpresa	: cadEmpresa,
					cadLogin	: cadLogin,
					cadSenha	: cadSenha,
					cadNvlAcesso : cadNvlAcesso
				},
				success: function(res) {
					if('S' == res) {
						alert('Usuário incluído com sucesso!');
						location.reload();
					}else {
						alert('Erro na inclusão!!!');
						$("#userCadNome").focus();
					}
				}
			});
		}else{
			alert("Todos campos são obrigatórios!");
		}
		
	});
	
})