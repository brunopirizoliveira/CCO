$(document).ready(function () {
  var medicao    = "";
  var fornecedor = "";

  $("#selEquipOcorrencia").hide();

  $("#linEquip2").hide();
  $("#linEquip3").hide();

  $("#edtEquip1").hide();
  $("#edtEquip2").hide();
  $("#edtEquip3").hide();

  $("#dadosManutencao").hide();

  $( "#tabs-itens" ).tabs();
  $( "#tabs-acompanhamento" ).tabs();

  $("#add_equip").click( function () {
    if ($("#linEquip2").is(":visible")) {

      if ($("#linEquip3").is(":visible")) {
        alert("Você só pode cadastrar 3 equipamentos para cada veículo");
      } else {
        $("#linEquip3").show();
      }
    
    } else {
      $("#linEquip2").show();
    }
  });

  $("#rem_equip").click( function() {

    if ($("#linEquip3").is(":visible")) {
      $("#linEquip3").hide();
    
    } else {

        if($("#linEquip2").is(":visible")) {
          $("#linEquip2").hide();
        } else {
          alert("Você precisa cadastrar pelo menos um equipamento para cada veículo");
        }
    }

  });
  

  $("#frtPrefixo").change( function() {
    $.ajax({
      url: "../controller/ajax/cadastro_frota.php",
      method: "POST",
      data: {
        frota: $("#frtPrefixo").val(),
        action: "buscaDadosFrota"
      },
      success: function(res) {
        var response = JSON.parse(res);

        if(response.bool == true) {
          location.href = "../../CCO_Tecnologias_Embarcadas/controller/editar_frota.php?frota="+response.frota+"";          
        } else {
          $("#frtEmpresa").val(response.empresa);
          $("#frtFilial").val(response.filial);
          $("#frtGaragem").val(response.garagem);
          $("#frtPlaca").val(response.placa);
          $("#frtMarca").val(response.marca);
          $("#frtTipo").val(response.tpfrota);
          $("#frtOperacao").val(response.operacao);  
        }
        
      }
    })
  });


  $("#frtSelEquipamento1").focus( function() {

    $.ajax({
      url: "../controller/ajax/cadastro_frota.php",
      method: "POST",
      data: {
        medicao:    $('#frtMediEquipamento1').val(),
        fornecedor: $('#frtFornEquipamento1').val(),        
        action:     "buscaDadosEquipamento"
      },      
      success: function(res) {   
        $("#targetEquip").val(1);     
        
        var response = JSON.parse(res);
        
        $.each(response.dados, function (index, val) {
          $("#tabSelEquip tbody").append('<tr><td><input type="radio" name="equipSelecionado1" id="equipSelecionado1" value="'+val.idtecnologia+'"></td><td>' + val.idtecnologia + '</td><td>' + val.idcco + '</td><td>' + val.numeroantena + '</td></tr>');                    
        });
      }

    });   

    $("#selEquipamento").modal();

  });

  $("#frtSelEquipamento2").focus( function() {

    $.ajax({
      url: "../controller/ajax/cadastro_frota.php",
      method: "POST",
      data: {
        medicao:    $('#frtMediEquipamento2').val(),
        fornecedor: $('#frtFornEquipamento2').val(),
        action:     "buscaDadosEquipamento"
      },      
      success: function(res) {       
        $("#targetEquip").val(2);

        var response = JSON.parse(res);
        
        $.each(response.dados, function (index, val) {
          $("#tabSelEquip tbody").append('<tr><td><input type="radio" name="equipSelecionado2" id="equipSelecionado2" value="'+val.idtecnologia+'"></td><td>' + val.idtecnologia + '</td><td>' + val.idcco + '</td><td>' + val.numeroantena + '</td></tr>');                    
        });
      }

    });   

    $("#selEquipamento").modal();

  });

  $("#frtSelEquipamento3").focus( function() {

    $.ajax({
      url: "../controller/ajax/cadastro_frota.php",
      method: "POST",
      data: {
        medicao:    $('#frtMediEquipamento3').val(),
        fornecedor: $('#frtFornEquipamento3').val(),
        action:     "buscaDadosEquipamento"
      },      
      success: function(res) {        
        $("#targetEquip").val(3);

        var response = JSON.parse(res);

        $.each(response.dados, function (index, val) {
          $("#tabSelEquip tbody").append('<tr><td><input type="radio" name="equipSelecionado3" id="equipSelecionado3" value="'+val.idtecnologia+'"></td><td>' + val.idtecnologia + '</td><td>' + val.idcco + '</td><td>' + val.numeroantena + '</td></tr>');                    
        });
      }

    });   

    $("#selEquipamento").modal();

  });

  $("#selectEquip").click(function () {    

    var target = $("#targetEquip").val();
    
    $("#frtSelEquipamento"+target+"").val($('[name="equipSelecionado'+target+'"]:checked').val());
    $("#frtEquipIDTecnologia"+target+"").val($('[name="equipSelecionado'+target+'"]:checked').val());
    $("#tabSelEquip tbody").empty();
    $("#selEquipamento").modal("hide");    
  });


  $("#salvarFrota").click( function() {
    var form = $("#frmFrota");
    var validate = form.valid();

    // if(validate) {
      // $("#frmFrota").submit();
      $.ajax({
        url: "../controller/ajax/executa_cadastro_frota.php",
        method: "POST",
        data:{
          form: form.serialize(),
          idFrota: $('[name="idFrota"]').val()
        },
        success: function(res) { 
          if(res == 'S'){

            alert('Frota incluido com sucesso!');
            location.reload();
          
          }else if(res == 'A'){
      			alert('Frota alterado com sucesso!');
      			location.reload();
			
		  }else {
            alert('Erro na inclusão!!!');
            $("#frtPrefixo").focus();
          }
        }
      });
    // }

  });

  // $("#checklist").jqGrid({
  //     url: "../controller/json/checklist.php",
  //     datatype: "json",
  //     mtype: "GET",
  //     colNames: [
  //       "Número",
  //       "Data",
  //       "Arquivo"
  //     ],
  //     colModel: [
  //         { name: "numero", width: 100, align: "center" },
  //         { name: "data", width: 100, align: "center" },
  //         { name: "arquivo", width: 100, align: "center" }
  //     ],
  //     pager: "#pagerChecklist",
  //     viewrecords: true,
  //     gridview: true,
  //     shrinkToFit: true ,
  //     rowNum:30,
  //     sortname: "frota",
  //     sortable: "true",
  //     sortorder: "desc",
  //     loadonce: true,
  //     gridview: true,
  //     autoencode: true,
  //     // height: "auto",
  //     rowList: [10, 20, 30,],
  //     altclass: "ui-priority-secondary",
  //     caption: "Checklist"
  // });

  $("#manutencao").jqGrid({
      url: "../controller/json/manutencao.php",
      datatype: "json",
      mtype: "GET",
      colNames: [
        "Número",
        "Data",
        "Problema",
        "Data Abertura OS",
        "Data Agendamento",
        "Local de Atendimento",
        "Número OS",
        "Registro Fotográfico",
        "Último Registro"
      ],
      colModel: [
          { name: "numero", width: 100, align: "center" },
          { name: "data", width: 100, align: "center" },
          { name: "problema", width: 120, align: "center" },
          { name: "dtAberturaOS", width: 120, align: "center" },
          { name: "dtAgendamento", width: 120, align: "center" },
          { name: "local", width: 150, align: "center" },
          { name: "os", width: 100, align: "center" },
          { name: "foto", width: 130, align: "center" },
          { name: "ultRegistro", width: 100, align: "center" }
      ],
      pager: "#pagerManutencao",
      viewrecords: true,
      gridview: true,
      shrinkToFit: true ,
      rowNum:30,
      sortname: "frota",
      sortable: "true",
      sortorder: "desc",
      loadonce: true,
      gridview: true,
      autoencode: true,
      // height: "auto",
      rowList: [10, 20, 30,],
      altclass: "ui-priority-secondary",
      caption: "Manutenção"
  });

  $("#novaOcorrencia").click( function () {
    $("#selEquipOcorrencia").show();    
  });

  $("#selEquipOcorrencia").change( function () {

    if($("#selEquipOcorrencia").val() != "") {

      $.ajax({
        url: "../controller/ajax/cadastro_manutencao.php",
        method: "POST",
        data:{
          action: 'buscaItensFrota'          
        },
        success: function(res) {
          var response = JSON.parse(res);

          $.each(response, function (index, val) {

            switch (val.idSubGrupo) {
              case '1':                
                $.each(val.itens, function (i, vl) {
                  $("#tabs-sensores").append('<div class="row"><div class="span3"><label>'+vl.item+'</label></div><div class="span3"><select value="'+vl.iditem+'"><option></option><option>Funcionando</option><option>Com defeito</option></select></div></div>');                    
                });
              break; 

              case '2':
                $.each(val.itens, function (i, vl) {
                  $("#tabs-avisos").append('<div class="row"><div class="span3"><label>'+vl.item+'</label></div><div class="span3"><select value="'+vl.iditem+'"><option></option><option>Funcionando</option><option>Com defeito</option></select></div></div>');                    
                });
              break; 

              case '3':
                $.each(val.itens, function (i, vl) {
                  $("#tabs-comunicacao").append('<div class="row"><div class="span3"><label>'+vl.item+'</label></div><div class="span3"><select value="'+vl.iditem+'"><option></option><option>Funcionando</option><option>Com defeito</option></select></div></div>');                    
                });
              break; 

              case '4':
                $.each(val.itens, function (i, vl) {
                  $("#tabs-atuadores").append('<div class="row"><div class="span3"><label>'+vl.item+'</label></div><div class="span3"><select value="'+vl.iditem+'"><option></option><option>Funcionando</option><option>Com defeito</option></select></div></div>');                    
                });
              break; 

              case '5':
                $.each(val.itens, function (i, vl) {
                  $("#tabs-sinal").append('<div class="row"><div class="span3"><label>'+vl.item+'</label></div><div class="span3"><select value="'+vl.iditem+'"><option></option><option>Funcionando</option><option>Com defeito</option></select></div></div>');                    
                });
              break; 
            }

          });
        }
      });

      $('#regManutencao').modal();    

    }

  });   

  $("#frmFrota").validate(
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

        frtEmpresa: {
          required: true
        },
        frtFilial: {
          required: true
        },
        frtGaragem: {
          required: true
        },
        frtPrefixo: {
          required: true
        },
        frtOperacao: {
          required: true
        },
        frtPlaca: {
          required: true
        },
        frtTipo: {
          required: true
        }

      },
      messages: {

        frtEmpresa: {
          required:"O campo Empresa é obrigatório.<br />"
        },
        frtFilial: {
          required:"O campo Filial é obrigatório.  <br />"
        },
        frtGaragem: {
          required:"O campo Garagem é obrigatório. <br />"
        },
        frtPrefixo: {
          required:"O campo Prefixo é obrigatório. <br />"
        },
        frtOperacao: {
          required:"O campo Operação é obrigatório.<br />"
        },
        frtPlaca: {
          required:"O campo Placa é obrigatório.   <br />"
        },
        frtTipo: {
          required:"O campo Tipo é obrigatório.    <br />"
        }

      }

    });

    $('#frtDtEquipamento1').datepicker({
  		dateFormat: 'dd/mm/yy',
  	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
  	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
  	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
  	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
  	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
  	    nextText: 'Próximo',
  	    prevText: 'Anterior'
  	});

    $('#frtDtEquipamento2').datepicker({
      dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

    $('#frtDtEquipamento3').datepicker({
      dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
	
    $('#logDtIni, #logDtFim, #delEquipDt').datepicker({
      dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });

	$('#editDelEquip1, #editDelEquip2, #editDelEquip3').click( function() {
		
		var row = this.id;
		var row = row.substr(12,12);
		var idfrota = document.getElementById('idFrota').value;
		var idtecnologia = document.getElementById('idTecnologia'+row).value;
		var idtecnologiaorg = document.getElementById('idTecnologiaOrg'+row).value;
		
		$("#delEquip").modal();
  
		$("#deletaEquip").click(function () {  
			var motivo = document.getElementById('delEquipMotivo').value;
			var dt = document.getElementById('delEquipDt').value;
			
			if(motivo && dt){
				$.ajax({
					url: "../controller/ajax/edita_frota.php",
					method: "POST",
					data: {
						idFrota:		idfrota,
						idTecnologia:	idtecnologia,
						idTecnologiaOrg: idtecnologiaorg,
						motivo:			motivo,
						dtExclusao:		dt,
						action:			"desassociaTecnologiaFrota"
					},
					success: function() {
						location.reload();
					},
					
				});
			}else{
				alert("Os campos 'motivo' e 'data de exclusão' são obrigatórios!");
			}
			
			$("#delEquip").modal("hide");    
		})
		
		
		/*var idtecnologia = document.getElementById('idTecnologia'+row).value;
		var idfrota = document.getElementById('idFrota').value;
		
		alert("ID TECNOLOGIA: "+idtecnologia+" e ID FROTA: "+idfrota);
		
		$("#delEquip").modal();
  
		$("#deletaEquip").click(function () {    
			$("#delEquip").modal("hide");    
		});*/
	});
	
	$('#confirmaEdtEquip1, #confirmaEdtEquip2, #confirmaEdtEquip3').click( function() {
		var target = $("#targetEquip").val();
		
		var idTecnologia = $("#frtEquipIDTecnologia"+target).val();
		var dtInstalacao = $("#frtDtEquipamento"+target).val();
		var idFrota = $("#idFrota").val();
		
		if(idTecnologia){
			$.ajax({
				url: "../controller/ajax/edita_frota.php",
				method: "POST",
				data: {
					idFrota:		idFrota,
					idTecnologia:	idTecnologia,
					dtInstalacao:	dtInstalacao,
					action:			"associaTecnologiaFrota"
				},
				success: function() {
					alert("Equipamento incluído com sucesso!");
					location.reload();
				},
				
			});
		}else{
			alert("O campo EQUIPAMENTO deve ser informado!");
		}
		
		//alert('target: '+target+' - idtecnologia: '+idTecnologia+' - dtinstalacao: '+dtInstalacao+' - idfrota: '+idFrota);
	});
	
	$('#alteraSitFrota').click( function(){
		var sitFrota = this.value;
		var idFrota = $("#idFrota").val();
		
		if(sitFrota == "I"){
			var inMsg = "in";
		}else{
			var inMsg = "";
		}
		
		$.ajax({
			url: "../controller/ajax/edita_frota.php",
			method: "POST",
			data: {
				sitFrota:		sitFrota,
				idFrota:		idFrota,
				action:			"alteraSituacaoFrota"
			},
			success: function() {
				alert("O frota foi "+inMsg+"ativado com sucesso");
				location.reload();
			},
			
		});
	});

});

function editEquip(row, act){
  for(j=1; j<4; j++){
    if(j == row){
      if(act == 1)
        $("#edtEquip"+row).show();
      else
        $("#edtEquip"+row).hide();
    }else{
      $("#edtEquip"+j).hide();
    }
  }
  
  var medicao = $('#data_'+row+'_1').text();
  var fornecedor = $('#data_'+row+'_2').text();
  var equipamento = $('#data_'+row+'_3').text();
  var numequipamento = $('#data_'+row+'_4').text();
  var instalacao = $('#data_'+row+'_5').text();
  
  switch(medicao){
    case  "Telemetria": var idmedicao = 1;
                break;
    case  "Rastreador": var idmedicao = 2;
                break;
	case       "Ambos": var idmedicao = 3;
				break;
  }
  
  switch(fornecedor){
    case  "FM300":    var idfornecedor = 1;
                break;
    case  "SASCAR":   var idfornecedor = 2;
                break;
    case  "SEVA":     var idfornecedor = 3;
                break;
    case  "SIGHRA":   var idfornecedor = 4;
                break;
    case  "TELEMETRIK": var idfornecedor = 5;
                break;
  }

  $('#frtMediEquipamento'+row).val(idmedicao);
  $('#frtFornEquipamento'+row).val(idfornecedor);
  $('#frtSelEquipamento'+row).val(numequipamento);
  $('#frtDtEquipamento'+row).val(instalacao);
}

function editNewEquip(row, act){
    for(j=1; j<4; j++){
      if(j == row){
      if(act == 1){
        $("#edtEquip"+row).show();
      }else{
        $("#edtEquip"+row).hide();
      }
    }else{
      $("#edtEquip"+j).hide();
    }
    
  }
}