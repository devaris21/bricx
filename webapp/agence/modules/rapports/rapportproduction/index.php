<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/agence/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/agence/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/agence/elements/templates/header.php")); ?>  

          <div class="animated fadeInRightBig">

            <div class="ibox ">
                <div class="ibox-title">
                    <h5 class="float-left">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
                    <div class="ibox-tools">
                        <form id="formFiltrer" method="POST">
                            <div class="row" style="margin-top: -1%">
                                <div class="col-5">
                                    <input type="date" value="<?= $date1 ?>" class="form-control input-sm" name="date1">
                                </div>
                                <div class="col-5">
                                    <input type="date" value="<?= $date2 ?>" class="form-control input-sm" name="date2">
                                </div>
                                <div class="col-2">
                                    <button type="button" onclick="filtrer()" class="btn btn-sm btn-white"><i class="fa fa-search"></i> Filtrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-12 border-right border-left">
                            <div class="row">
                                <div class="col-sm-3 border-right">
                                    <h5 class="text-uppercase gras text-center">Production par produit</h5>
                                    <ul class="list-group clear-list m-t">
                                        <?php foreach ($produits as $key => $item) {  ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                                <i class=" float-right"><?= money($item->produit) ?> Unités</i>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <div class="flot-chart" style="height: 240px">
                                        <div class="flot-chart-content" id="flot-dashboard-chart" ></div>
                                    </div><hr class="mp3">
                                    <h2 class="mp0 gras"><?= money(comptage($produits, "produit", "somme"));  ?></h2>
                                    <span class="small">briques produites</span>
                                    <hr class="mp3">
                                </div>
                                <div class="col-sm-3 border-left">
                                    <h5 class="text-uppercase gras text-center">Consommation des ressources</h5>
                                    <ul class="list-group clear-list m-t">
                                        <?php foreach ($ressources as $key => $item) {  ?>
                                            <li class="list-group-item">
                                                <i class="fa fa-flask" style="color: "></i> <span><?= $item->name()  ?></span>          
                                                <i class=" float-right"><?= money($item->consomme) ?> <?= $item->abbr ?></i>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item"></li>
                                    </ul>
                                </div>
                            </div><hr style="border: dashed 1px orangered"> 
                        </div>
                    </div>



                </div>
            </div>


        </div>

        <br><br>
        <?php include($this->rootPath("webapp/agence/elements/templates/footer.php")); ?>


    </div>
</div>


<?php include($this->rootPath("webapp/agence/elements/templates/script.php")); ?>



<script>
    $(document).ready(function() {

        var data1 = [<?php foreach ($stats as $key => $lot) { ?>[gd(<?= $lot->year ?>, <?= $lot->month ?>, <?= $lot->day ?>), <?= $lot->total ?>], <?php } ?> ];

        var dataset = [
        {
            label: "Evolution de la production",
            data: data1,
            color: "#1ab394",
            lines: {
                lineWidth:1,
                show: true,
                fillColor: {
                    colors: [{
                        opacity: 0.2
                    }, {
                        opacity: 0.4
                    }]
                }
            },
            splines: {
                show: false,
                tension: 0.6,
                lineWidth: 1,
                fill: 0.1
            },

        }
        ];


        var options = {
            xaxis: {
                mode: "time",
                tickSize: [<?= $lot->nb  ?>, "day"],
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
