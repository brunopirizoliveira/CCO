$(document).ready(function () {

	$("#salvarTecnologia").click( function () {
		
		var form = $("#frmTecno");
		var validate = form.valid();
		
		var sensor = [];
		$('[name="sensor[]"]:checked').each( function (index, value) {
			sensor.push(value.value);
		});

		var identificacao = [];
		$('[name="identificacao[]"]:checked').each(function (index, value) {
			identificacao.push(value.value);
		});

		var atuador = [];
		$('[name="atuador[]"]:checked').each( function (index, value) {
			atuador.push(value.value);
		});		

		var comunicacao = [];
		$('[name="comunicacao[]"]:checked').each( function (index, value) {
			comunicacao.push(value.value);
		});		

		var sinal = [];
		$('[name="sinal[]"]:checked').each( function (index, value) {
			sinal.push(value.value);
		});		

		var avisos = [];
		$('[name="avisos[]"]:checked').each( function (index, value) {
			avisos.push(value.value);
		});	

		var fornecedor = $('[name="fornecedor"]:checked').val();	
		var medicao    = $('[name="medicao"]:checked').val();
		var tipo       = $('[name="tipo"]:checked').val();
		var idcco      = $('#idcco').val();
		var idccoant   = $('#idccoant').val();
		var numAntena  = $('#codigo_antena').val();
		var serial	   = $('#serial').val();
		var serialant  = $('#serialant').val();
		var numAntenaant = $('#codigo_antenaant').val();
		var modelo     = $('#modelo').val();
		var modeloant  = $('#modeloant').val();
		var idTecno	   = $('#idTecno').val();
		
		$.ajax({
			url: "../controller/ajax/cadastro_tecnologia.php",
			method: "POST",
			data: {
				identificacao : identificacao,
				sensor 		  : sensor,
				atuador 	  : atuador,
				comunicacao   : comunicacao,
				sinal         : sinal,
				fornecedor    : fornecedor,
				medicao       : medicao, 
				avisos 	      : avisos,
				idcco         : idcco,
				idccoant      : idccoant,
				numAntena     : numAntena,
				numAntenaant  : numAntenaant,
				serial		  : serial,
				serialant	  : serialant,
				modelo		  : modelo,
				modeloant     : modeloant,
				tipo		  : tipo,
				idTecno		  : idTecno,
				action: "insereTecnologia"
			},
			success: function(res) {
				alert(res);
				if('Incluído com sucesso!!!' == res) {
					location.reload();
				} else if('Atualizado com sucesso!!!' == res) {					
					location.href = "../controller/consulta_tecnologia.php";
				}else {
					alert('Erro na inclusão!!!');
					$("#idcco").focus();
				}
			}
		});

	});
	
	$("#frmTecno").validate(
    {
      errorLabelContainer: "#validateMsg",
      errorElement: "el",
      errorPlacement: function(error,element){
        element.parent("td").next("td").html(error);
      },
      success: function (){
        $("el").filter(".error").remove();  //ou removeClass("error")
      },
      rules: {

        idcco: {
          required: true
        },
        modelo: {
          required: true
        },
        /*codigo_antena: {
          required: true
        },*/
		tipo: {
          required: true
        },
		fornecedor: {
			required: true
		},
		medicao: {
			required: true
		}

      },
      messages: {

        idcco: {
          required:"O campo ID CCO é obrigatório.<br />"
        },
        modelo: {
          required:"O campo MODELO é obrigatório.  <br />"
        },
        /*codigo_antena: {
          required:"O campo CODIGO ANTENA é obrigatório. <br />"
        },*/
		tipo: {
			required:"O campo TIPO é obrigatório. <br />"
		},
		fornecedor: {
			required:"O campo FORNECEDOR é obrigatório. <br />"
		},
		medicao: {
			required:"O campo MEDIÇÃO é obrigatório. <br />"
		}

      }

    });


});		