<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/agence/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/agence/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/agence/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">

                <div class="border-bottom white-bg dashboard-header" style="border-top: dashed 3px #ddd">
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="height: 70px;" alt=""> 
                                <h3 class="text-uppercase mp0 text-warning"><?= $params->societe ?></h3>                            
                            </div>                      


                            <ul class="list-group clear-list m-t">
                                <li class="list-group-item fist-item cursor" data-toggle="modal" data-target="#modal-listecommande">
                                    Commandes passées aujourd'hui <span class="text-success float-right"><?= start0(count($commandes)); ?></span> 
                                </li>
                                <li class="list-group-item cursor" data-toggle="modal" data-target="#modal-listelivraisons">
                                    Livraisons du jour <span class=" text-success float-right"><?= start0(count($livraisons)); ?> </span>
                                </li>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                        <div class="col-md-6 border-right border-left text-center">
                            <div class="" style="margin-top: 0%">
                                <div id="ct-chart" style="height: 270px;"></div>
                            </div><hr>
                            <small class="text-uppercase">Courbe représentative du stock de produits en fonction des commandes actuelles</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <h3 class="text-uppercase">Stock des ressources</h3>
                            <ul class="list-group  text-left clear-list m-t">
                                <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                    <li class="list-group-item">
                                        <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp; <?= $ressource->name() ?>
                                        <span class="float-right">
                                            <span class="text-blue gras"><?= round($ressource->stock(Home\PARAMS::DATE_DEFAULT, dateAjoute(1), $agence->id), 2) ?> <?= $ressource->abbr ?></span>
                                        </span>
                                    </li>
                                <?php } ?>
                                <li class="list-group-item"></li>
                            </ul>

                        </div>
                    </div>   
                    <hr style="border-top: dashed 3px #ddd"><br>
                    <div class="row">
                        <?php foreach ($tableau as $key => $produit) { ?>
                            <div class="col-md border-right">
                                <h6 class="text-uppercase text-center"><img class="border" src="<?= $this->stockage("images", "produits", $produit->image) ?>" style="height: 20px;"> Stock de <u class="gras"><?= $produit->name ?></u></h6>
                                <ul class="list-group clear-list m-t">
                                    <li class="list-group-item">
                                        <i class="fa fa-cubes"></i> <small>Livrable</small>          
                                        <span class="float-right">
                                            <span title="en agence" class="gras text-<?= ($produit->livrable > 0)?"green":"danger" ?>"><?= money($produit->livrable) ?></span>
                                        </span>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-cubes"></i> <small>Non rangée</small>          
                                        <span class="float-right">
                                            <small title="en agence"><?= money($produit->attente) ?></small>
                                        </span>
                                    </li>
                                    <li class="list-group-item"></li>
                                </ul>
                            </div>
                        <?php } ?>
                    </div> 
                </div>

            </div>
        </div>
        <br>

        <?php include($this->rootPath("webapp/agence/elements/templates/footer.php")); ?>

        <?php include($this->rootPath("composants/assets/modals/modal-clients.php")); ?> 
        <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?> 


        <div class="modal inmodal fade" id="modal-listecommande">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                 <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Commandes passées aujourd'hui</h4>
                    <span>Double-cliquez pour selectionner la commande voulue !</span>
                </div>
                <form method="POST">
                    <div class="modal-body">
                       <table class="table table-hover no-margins">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Client</th>
                                <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                                    <th class="text-center"><?= $produit->name() ?></th>
                                <?php } ?>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commandes as $key => $commande) {
                                $commande->actualise();
                                $datas = $commande->fourni("lignecommande"); ?>
                                <tr>
                                    <td title="Voir le bon de commande"><a href="<?= $this->url("agence", "fiches", "boncommande", $commande->getId()) ?>" target="_blank"><i class="fa fa-file-text-o fa-2x"></i></a></td>
                                    <td><a href="<?= $this->url("agence", "master", "client", $commande->groupecommande->client_id)  ?>"><?= $commande->groupecommande->client->name() ?></a></td>
                                    <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { 
                                        $a = ""; ?>
                                        <?php foreach ($datas as $key => $ligne) { 
                                            if($ligne->produit_id == $produit->getId()){
                                                $a = $ligne->quantite;
                                                break;
                                            } } ?>
                                            <th class="text-center"><?= $a ?></th>
                                        <?php  } ?>
                                        <td class="text-center"><span class="label label-<?= $commande->etat->class ?>"><?= $commande->etat->name ?></span> </td>
                                        <td class="text-center">
                                            <?php if ($commande->etat_id == Home\ETAT::PARTIEL) { ?>
                                                <button onclick="validerProg(<?= $commande->getId() ?>)" class="cursor simple_tag pull-right"><i class="fa fa-file-text-o"></i> Faire la commande</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>



</div>
</div>


<?php include($this->rootPath("webapp/agence/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../production/programmes/script.js") ?>"></script>

<script>
    $(document).ready(function() {

        var id = "<?= $this->getId();  ?>";
        if (id == 1) {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success('Content de vous revoir de nouveau!', 'Bonjour <?= $employe->name(); ?>');
            }, 1300);
        }


 // Stocked horizontal bar

 new Chartist.Bar('#ct-chart', {
    labels: [<?php foreach ($tableau as $key => $data){ ?>"<?= $data->name ?>", " ", " ",<?php } ?>],
    series: [
    [<?php foreach ($tableau as $key => $data){ ?><?= $data->attente ?>, 0, 0,<?php } ?>],
    [<?php foreach ($tableau as $key => $data){ ?><?= $data->livrable ?> , 0, 0,<?php } ?>],
    [<?php foreach ($tableau as $key => $data){ ?>0, <?= $data->commande ?>, 0,<?php } ?>],
    ]
}, {
   stackBars: true,
   axisX: {
    labelInterpolationFnc: function(value) {
        if (value >= 1000) {
            return (value / 1000) + 'k';            
        }
        return value;
    }
},
reverseData:true,
seriesBarDistance: 10,
horizontalBars: true,
axisY: {
    offset: 80
}
});



 var ctx3 = document.getElementById("polarChart").getContext("2d");
 new Chart(ctx3, {type: 'polarArea', data: polarData, options:polarOptions});

 var doughnutData = {
    labels: ["App","Software","Laptop" ],
    datasets: [{
        data: [300,50,100],
        backgroundColor: ["#a3e1d4","#dedede","#b5b8cf"]
    }]
} ;


var doughnutOptions = {
    responsive: true
};


});
</script>


</body>

</html>