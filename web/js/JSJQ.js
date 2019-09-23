


/***************************************************************/
/***ADMIN TRAITEMENT RECHERCHE ARTICLE A MODIFIER/SUPPRIMER****/
/***************************************************************/


$(document).ready(function(){

	/****https://stackoverflow.com/questions/44087779/submit-symfony-3-form-with-ajax****/
	$.fn.serializeObject = function(){
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
	        if (o[this.name] !== undefined) {
		        if (!o[this.name].push) {
		        	o[this.name] = [o[this.name]];
		        }
	        	o[this.name].push(this.value || '');
	        } else {o[this.name] = this.value || '';}
        });
	        return o;
      };

	/*********************Formulaire de recherche*******************/
	$("#formRecherche").submit(function(event){
		event.preventDefault();
		var id    = $("#recherche_article option:selected").text();
		var path = 'formulaireModification';
		$.ajax({
			type: 'post',
			data:'id='+id,
			url: path,
			dataType: 'json',
			cache: false,
			success: function(data){
				if (data.success == true) {
					$('#container_form').slideToggle(500);
					$('#container_form').html(data.formarticle);
				}else{
						$('#container_form').slideToggle(500);
						$('#container_form').html(data.message);
						}
			}
		}); return false;
	});

	/*********************Formulaire de Modification*******************/
	$(document).on("submit", "#form_update_article", function(e){
		e.preventDefault();
		var categorie =  $('#article_categorie option:selected').text();
		var rubrique  =  $('#article_rubrique option:selected').text();
		var reference = $('#article_reference').val();
		var prix      = $('#article_prix').val();
		var photo_url = $('#article_photo_url').val();
		var photo_alt = $('#article_photo_alt').val();
		var level     = $('#article_level').val();
		var url       = $('#article_url').val();
		var infos     = $('#article_infos').val();
		var stock     = $('#article_stock').val();
		var path = "updateArticle";
		$.ajax({
		    type: "POST",
		    data:'categorie='+ categorie + '&rubrique='+ rubrique  + '&reference='+ reference + '&prix='+ prix + '&prix='+ prix + '&url='+ url + '&infos='+ infos + '&stock='+ stock + '&level='+ level + '&photo_url='+ photo_url + '&photo_alt=' + photo_alt,
		    url: path,
		    cache: false,
		    success: function(data){
		        if (data.success == true) {
					alert(data.message);
				}else{}
		    } 
		}); return false;
	})

	
});





 