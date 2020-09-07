$(function(){


    $("#top-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table.table-mise tr:not(.no)").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });


    $("input[name=quantite]").change(function(){
        var url = "../../webapp/agence/modules/production/production/ajax.php";
        var formdata = new FormData();
        $this = $(this);
        formdata.append('id', $(this).attr('id'));
        formdata.append('val', $(this).val());
        formdata.append('action', "calcul");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            $this.parent().parent().parent().find("div.ajax").html(data);
        }, 'html')
    })



        $("#formProductionJour").submit(function(event) {
            Loader.start();
            var url = "../../webapp/agence/modules/production/production/ajax.php";
            var formdata = new FormData($(this)[0]);
            formdata.append('action', "productionjour");
            $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
                if (data.status) {
                    window.location.reload();
                }else{
                    Alerter.error('Erreur !', data.message);
                }
            }, 'json')
            return false;
        });



    
    annulerProduction = function(id){
        alerty.confirm("Voulez-vous vraiment annuler cette mise en agence ?", {
            title: "Annuler la mise en agence",
            cancelLabel : "Non",
            okLabel : "OUI, annuler",
        }, function(){
            var url = "../../webapp/agence/modules/production/miseenagence/ajax.php";
            alerty.prompt("Entrer votre mot de passe pour confirmer l'opération !", {
                title: 'Récupération du mot de passe !',
                inputType : "password",
                cancelLabel : "Annuler",
                okLabel : "Valider"
            }, function(password){
                Loader.start();
                $.post(url, {action:"annulerMiseenagence", id:id, password:password}, (data)=>{
                    if (data.status) {
                        window.location.reload()
                    }else{
                        Alerter.error('Erreur !', data.message);
                    }
                },"json");
            })
        })
    }


    $("#formValiderMiseenagence").submit(function(event) {
        Loader.start();
        $(this).find("input.vendus").last().change();
        var url = "../../webapp/agence/modules/production/miseenagence/ajax.php";
        var formdata = new FormData($(this)[0]);
        var tableau = new Array();
        $(this).find("table tr input.recu").each(function(index, el) {
            var id = $(this).attr('data-id');
            
            var vendu = $(this).val();
            tableau.push(id+"-"+vendu);
        });
        formdata.append('tableau', tableau);

        formdata.append('action', "validerMiseenagence");
        $.post({url:url, data:formdata, contentType:false, processData:false}, function(data){
            if (data.status) {
                window.location.reload()
            }else{
                Alerter.error('Erreur !', data.message);
            }
        }, 'json');
        return false;
    });


})