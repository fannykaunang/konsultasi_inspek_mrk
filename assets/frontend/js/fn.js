$(function(){$(".tips").tooltip({placement:'right'});});function confirm(heading,question,cancelButtonTxt,okButtonTxt,callback){var confirmModal=$('<div class="modal fade"'+'tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+'<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title">'+heading+'</h3></div><div class="modal-body">'+question+'</div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> '+cancelButtonTxt+'</button><button type="submit" class="btn btn-primary" id="okButton"><i class="fa fa-check"></i> '+okButtonTxt+'</button></div></div></div></div>');confirmModal.find('#okButton').click(function(event){callback();confirmModal.modal('hide');});confirmModal.modal('show');}
function myModal(heading,question,cancelButtonTxt){var contentModal=$('<div class="modal fade"'+'tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+'<div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3 class="modal-title">'+heading+'</h3></div><div class="modal-body">'+question+'</div><div class="modal-footer"><button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> '+cancelButtonTxt+'</div></div></div></div>');contentModal.find('#okButton').click(function(event){contentModal.modal('hide');});contentModal.modal('show');}
function ShowMenu(id,param){var show=$("."+id+param).show();if(show==false){$("."+id+param).fadeIn(500);}else{$("#"+id+param).mouseleave(function(){$("."+id+param).fadeOut(500);});}
$("#"+id+param).tooltip();}
function showTime(){var today=new Date();var h=today.getHours();var m=today.getMinutes();var s=today.getSeconds();h=checkTime(h);m=checkTime(m);s=checkTime(s);$("#clock").text(h+":"+m+":"+s);t=setTimeout('showTime()',1000);}
function checkTime(i){if(i<10){i="0"+i;}
return i;}
function resetForm($form){$form.find('input:text, input:password, input:file, select, textarea').val('');$form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');}
$(function(){$.fn.dataTableExt.oApi.fnPagingInfo=function(oSettings){return{"iStart":oSettings._iDisplayStart,"iEnd":oSettings.fnDisplayEnd(),"iLength":oSettings._iDisplayLength,"iTotal":oSettings.fnRecordsTotal(),"iFilteredTotal":oSettings.fnRecordsDisplay(),"iPage":oSettings._iDisplayLength===-1?0:Math.ceil(oSettings._iDisplayStart/oSettings._iDisplayLength),"iTotalPages":oSettings._iDisplayLength===-1?0:Math.ceil(oSettings.fnRecordsDisplay()/oSettings._iDisplayLength)};}
$.extend($.fn.dataTableExt.oPagination,{"bootstrap":{"fnInit":function(oSettings,nPaging,fnDraw){var oLang=oSettings.oLanguage.oPaginate;var fnClickHandler=function(e){e.preventDefault();if(oSettings.oApi._fnPageChange(oSettings,e.data.action)){fnDraw(oSettings);}};$(nPaging).addClass('pagination').append('<ul>'+'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+'</ul>');var els=$('a',nPaging);$(els[0]).bind('click.DT',{action:"previous"},fnClickHandler);$(els[1]).bind('click.DT',{action:"next"},fnClickHandler);},"fnUpdate":function(oSettings,fnDraw){var iListLength=5;var oPaging=oSettings.oInstance.fnPagingInfo();var an=oSettings.aanFeatures.p;var i,j,sClass,iStart,iEnd,iHalf=Math.floor(iListLength/2);if(oPaging.iTotalPages<iListLength){iStart=1;iEnd=oPaging.iTotalPages;}else if(oPaging.iPage<=iHalf){iStart=1;iEnd=iListLength;}else if(oPaging.iPage>=(oPaging.iTotalPages-iHalf)){iStart=oPaging.iTotalPages-iListLength+1;iEnd=oPaging.iTotalPages;}else{iStart=oPaging.iPage-iHalf+1;iEnd=iStart+iListLength-1;}
for(i=0,iLen=an.length;i<iLen;i++){$('li:gt(0)',an[i]).filter(':not(:last)').remove();for(j=iStart;j<=iEnd;j++){sClass=(j==oPaging.iPage+1)?'class="active"':'';$('<li '+sClass+'><a href="#">'+j+'</a></li>').insertBefore($('li:last',an[i])[0]).bind('click',function(e){e.preventDefault();oSettings._iDisplayStart=(parseInt($('a',this).text(),10)-1)*oPaging.iLength;fnDraw(oSettings);});}
if(oPaging.iPage===0){$('li:first',an[i]).addClass('disabled');}else{$('li:first',an[i]).removeClass('disabled');}
if(oPaging.iPage===oPaging.iTotalPages-1||oPaging.iTotalPages===0){$('li:last',an[i]).addClass('disabled');}else{$('li:last',an[i]).removeClass('disabled');}}}}});$("#DataTable").dataTable({"oLanguage":{"sLengthMenu":"Tampilkan _MENU_ data per halaman","sZeroRecords":"Data tidak ada","sInfo":"Ditampilkan _START_ sampai _END_ dari _TOTAL_ data","sInfoEmpty":"Ditampilkan 0 sampai 0 dari 0 data","sInfoFiltered":"(saring dari _MAX_ total data)","sSearch":"Cari","oPaginate":{"sFirst":"Awal","sPrevious":"Sebelumnya","sNext":"Selanjutnya","sLast":"Akhir"}},"sPaginationType":"bootstrap"});});var myLoader=function(){var contentModal=$('<div class="modal fade" data-keyboard="false" data-backdrop="static" '+'tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+'<div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h3 class="modal-title">Tunggu...</h3></div> <div class="modal-body"><div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">100% Complete</span></div></div></div></div></div></div>');return{show:function(){contentModal.modal();},hide:function(){contentModal.modal('hide');}}}
()
$(function () {
	$(".tooltip").tooltip({
		placement : 'right'
	});
	$(".tooltip-right").tooltip({
		placement : 'right'
	});
	$(".tooltip-bottom").tooltip({
		placement : 'bottom'
	});
	$(".tooltip-top").tooltip({
		placement : 'top'
	});
	$(".beli").tooltip({
		placement : 'right'
	});
	$(".lihat").tooltip({
		placement : 'right'
	});
	$(".cek").tooltip({
		placement : 'bottom'
	});
	$(".cek").tooltip({
		placement : 'bottom'
	});
})