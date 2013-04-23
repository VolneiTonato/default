$(function(){
	if($(".table-order").size() > 0)
		$(".table-order").dataTable();
});

$(function(){
	$('body').delegate(".enter",'keydown',function(e){
		
	});
});

$(function(){
	if($('form').size()>0){
		var i = 1;
		$('form').find('input,select,textarea').each(function(){
			var $obj = $(this);
			if($obj.is("input[type=text]") || 
			   $obj.is("input[type=radio]") || 
			   $obj.is("input[type=checkbox]") ||
			   $obj.is("input[type=submit]") ||
			   $obj.is("input[type=reset]")){
					$obj.attr("tabindex",i);
					$obj.addClass("enter");
			}else if ($obj.is("select")) {
				$obj.attr("tabindex",i);
				$obj.addClass("enter");
			}
			i++;
		});
	}
});




$(function(){
	setInterval('Blink()',450);
});

$(function(){
	if($(".date").size() > 0)
		$(".date").datepicker();
	
});

$(function(){
	if($(".mask-cnpj").size() >0)
		$(".mask-cnpj").mask('99.999.999/9999-99');
});

$(function(){
	if($("#mensagem-principal").size() > 0)
		$("#mensagem-principal").alert();
		//$("#mensagem-principal").alert().delay(5000).fadeOut("slow");
});

$(function(){
	if($("form").size() > 0)
		$("form").validationEngine();
});

$(function(){
	 $('input[type=text]').attr('autocomplete', 'off');
	 $('textarea').css({'resize':'none'});
});


$(function(){
	if($(".mensage-interface").size() > 0){
		var $mensagem = $(".mensagem-interface");
		$mensagem.alert();
		$mensagem.delay(5000).fadeOut(2000);
	}
});

function Blink(){
	if($(".blink").size() > 0)
		$(".blink").fadeToggle();
}

function BaseUrl(){
	if($("#base-url").size() > 0)
		return $("#base-url").text();
}

/* Classe ou id */
function AddLoader(obj){
	var html = '<div class="loader-dinamico"><img src="'+BaseUrl()+'Images/Geral/Loader/ajax-loader(7).gif" /></div>';
	$(obj).append(html);
}

/*Classe ou id */
function RemoveLoader(obj){
	$(obj).find(".loader-dinamico").remove();
}



function MontarTabela(){
	$(".table-order").dataTable();
}

function BarraProgresso(i, total){
	var percent = (i * 100) / total;
	var html = '<div class="progress">';
		html+= '<div class="bar" style="width:'+ percent +'%"></div></div>';
	
	var $bar = $("#barra-progresso");
	
	if(!$bar.is(":visible"))
		$bar.show();
	
	$bar.empty().html(html);
}

function BarraProgressoPesquisa(mensagem){
	var html = '<div class="progress progress-striped active">';
		html+= '<div class="bar" style="width:100%">'+mensagem+'</div></div>';
	
	var $bar = $("#barra-progresso");
	
	if(!$bar.is(":visible"))
		$bar.show();
	
	$bar.empty().html(html);
}

function BarraProgressoClose(){
	var $bar = $("#barra-progresso");
	$bar.empty().delay(2000).fadeOut();
}

function SendEnter(obj, e){
	
}




/* Brazilian initialisation for the jQuery UI date picker plugin. */
/* Written by Leonildo Costa Silva (leocsilva@gmail.com). */
jQuery(function($){
        $.datepicker.regional['pt-BR'] = {
                closeText: 'Fechar',
                prevText: '&#x3c;Anterior',
                nextText: 'Pr&oacute;ximo&#x3e;',
                currentText: 'Hoje',
                monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
                'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
                'Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
                dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});