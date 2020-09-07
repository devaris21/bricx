<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/vente/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/vente/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/vente/elements/templates/header.php")); ?>  

          <div class="wrapper wrapper-content">
            <div class="animated fadeInRightBig">

                <div class=" border-bottom white-bg dashboard-header">
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <img src="<?= $this->stockage("images", "societe", $params->image) ?>" style="height: 70px;" alt=""><br>
                                <h2 class="text-uppercase"><?= $agence->name() ?></h2><br>
                            </div>
                            <small><?= $agence->lieu  ?> </small>
                            <ul class="list-group clear-list m-t">
                                <li class="list-group-item fist-item">
                                    Commandes en cours <span class="label label-success float-right"><?= start0(count($groupes__)); ?></span> 
                                </li>
                                <li class="list-group-item">
                                    Livraisons en cours <span class="label label-success float-right"><?= start0(count(Home\LIVRAISON::findBy(["etat_id ="=>Home\ETAT::ENCOURS]))); ?></span> 
                                </li>
                                <li class="list-group-item"></li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                                </div><hr>
                                <small>Graphe de comparaison des différents modes de ventes</small>
                            </div><hr>

                        </div>
                        <div class="col-md-3 border-left">
                            <div class="statistic-box" style="margin-top: 0%">
                               <div class="ibox">
                                <div class="ibox-content">
                                    <h5>Courbe des ventes</h5>
                                    <div id="sparkline2"></div>
                                </div>

                                <div class="ibox-content">
                                    <h5>Dette chez les clients</h5>
                                    <h2 class="no-margins"><?= money(Home\CLIENT::Dettes()); ?> <?= $params->devise  ?></h2>
                                </div>

                            </div>
                        </div>
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
                <hr>
            </div>


        </div>
    </div>
    <br>

    <?php include($this->rootPath("webapp/vente/elements/templates/footer.php")); ?>

    <?php include($this->rootPath("composants/assets/modals/modal-clients.php")); ?> 
    <?php include($this->rootPath("composants/assets/modals/modal-client.php")); ?> 

</div>
</div>


<?php include($this->rootPath("webapp/vente/elements/templates/script.php")); ?>

<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>
<script type="text/javascript" src="<?= $this->relativePath("../../production/miseenagence/script.js") ?>"></script>

<script>
    $(document).ready(function() {

        var id = "<?= $this->id;  ?>";
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



        var sparklineCharts = function(){

           $("#sparkline2").sparkline([24, 43, 43, 55, 44, 62, 44, 72], {
               type: 'line',
               width: '100%',
               height: '60',
               lineColor: '#1ab394',
               fillColor: "#ffffff"
           });

       };

       var sparkResize;

       $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineCharts, 500);
    });

       sparklineCharts();




       var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->commande ?>], <?php } ?> ];

       var data2 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->livraison ?>], <?php } ?> ];


       var dataset = [
       {
        label: "commandes",
        data: data1,
        color: "#1ab394",
        bars: {
            show: true,
            align: "left",
            barWidth: 12 * 60 * 60 * 600,
            lineWidth:0
        }

    }, {
        label: "Livraisons",
        data: data2,
        color: "#cc0000",
        bars: {
            show: true,
            align: "right",
            barWidth: 12 * 60 * 60 * 600,
            lineWidth:0
        }

    }
    ];


    var options = {
        xaxis: {
            mode: "time",
            tickSize: [2, "day"],
            tickLength: 0,
            axisLabel: "Date",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial',
            axisLabelPadding: 10,
            color: "#d5d5d5"
        },
        yaxes: [{
            position: "left",
            color: "#d5d5d5",
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelFontFamily: 'Arial',
            axisLabelPadding: 3
        }
        ],
        legend: {
            noColumns: 1,
            labelBoxBorderColor: "#000000",
            position: "nw"
        },
        grid: {
            hoverable: false,
            borderWidth: 0
        }
    };

    function gd(year, month, day) {
        return new Date(year, month - 1, day).getTime();
    }

    var previousPoint = null, previousLabel = null;

    $.plot($("#flot-dashboard-chart"), dataset, options);



});
</script>


</body>

</html>