$(document).ready( function(){
	
	if($('.nome.autocomplete').length>0){
		$('.nome.autocomplete').prop('readonly', true);
		showWait();
	    $.ajax({
	        type:'POST',
	        url:'/personagens/busca',

	        dataType: "json",
	   
	        success: function(msg){
	        //	console.log(msg);
	        var availableTags = msg;

		        $(".nome").autocomplete({
	            	source: availableTags, // source é a origem dos dados ok
	            	minLength: 2,
	            	noResults: 'nenhum encontrado',
			        results: function(amount) {
			            return amount + 'resultados.';
			        },
	            	select: function( event, ui ) {  

	            		exibe_detalhes(ui.item.value); 

	        		}
	    		});

	    		$('.nome.autocomplete').prop('readonly', false);
	    		hideWait();
			}
		});
	}
});
	

function showWait(){
	$('#waitloader').show();
}

function hideWait(){
	$('#waitloader').hide();
}

function exibe_detalhes(nome){
	$('.nome').val('');
	
	showWait();
    $.ajax({
        type:'POST',
        url:'/personagens/detalhesapi',

        dataType: "text/html",
        data:{"nome":nome},
   		complete: function(data){
   			console.log(data);
   			$('#personagem-detalhes').html(data.responseText);
   			hideWait();
   		}
	});

}