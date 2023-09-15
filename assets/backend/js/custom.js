function ShowMenu(param) {
	//console.log($("."+param).parent());	
	var show = $("." + param).fadeIn();	
	/*$("." + param).mouseleave(function () {
		//$("." + param).fadeOut();
		show.fadeOut();
	});	
	*/
	$("."+param).parent().mouseleave(function(){
		show.fadeOut();
	});
}
var myLoader = function () {
	var contentModal = $('<div class="modal fade" data-keyboard="true" data-backdrop="static" ' + 'tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' + '<div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h3 class="modal-title">Proses...</h3></div> <div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div></div></div></div></div></div>');
	return {
		show : function () {
			contentModal.modal();
		},
		hide : function () {
			contentModal.modal('hide');
		}
	}
}()