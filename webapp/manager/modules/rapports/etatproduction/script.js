$(function(){

	filtrer = function(){
		var url = "../../webapp/manager/modules/caisse/etatproduction/ajax.php";
		var formdata = new FormData($("#formFiltrer")[0]);
		formdata.append('action', "filtrer");
		$.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
			window.location.href = data.url;
		}, 'json')
	}


})