<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/vente/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/vente/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/vente/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-blue gras">Les livraisons programmées</h2>
            </div>
            <div class="col-sm-3">

            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 class="text-capitalize">Du <?= datecourt($date1) ?> au <?= datecourt($date2) ?></h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content" style="min-height: 300px">
                    <?php if (count($encours) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>

                                    <th data-toggle="true">Status</th>
                                    <th>Reference</th>
                                    <th>Commercial</th>
                                    <th></th>
                                    <th>Montant</th>
                                    <th data-hide="all">Produits</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($encours as $key => $livraison) {
                                    $livraison->actualise(); 
                                    $livraison->fourni("ligneprospection");
                                    ?>
                                    <tr style="border-bottom: 2px solid black">
                                        <td class="project-status">
                                            <span class="label label-<?= $livraison->etat->class ?>"><?= $livraison->etat->name ?></span>
                                        </td>
                                        <td>
                                            <span class="text-uppercase gras">Livraison de commande</span><br>
                                            <span><?= $livraison->reference ?></span>
                                        </td>
                                        <td>
                                            <h5 class="text-uppercase"><?= $livraison->commercial->name() ?></h5>
                                        </td>
                                        <td>
                                            <h6 class="text-uppercase text-muted" style="margin: 0">Zone de livraison :  <?= $livraison->zonelivraison->name() ?></h6>
                                            <small><?= depuis($livraison->created) ?></small>
                                        </td>
                                        <td>
                                            <h3 class="gras text-orange"><?= money($livraison->montant) ?> <?= $params->devise  ?></h3>
                                        </td>
                                        <td class="border-right">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr class="no">
                                                        <th></th>
                                                        <?php foreach ($livraison->ligneprospections as $key => $ligne) {
                                                            $ligne->actualise(); ?>
                                                            <th class="text-center" style="padding: 2px"><span class="small"><?= $ligne->produit->name() ?></span><br>
                                                                <img style="height: 20px" src="<?= $this->stockage("images", "emballages", $ligne->emballage->image) ?>" >
                                                                <small><?= $ligne->emballage->name() ?></small>
                                                            </th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="no">
                                                        <td><h4 class="mp0">Qté : </h4></td>
                                                        <?php foreach ($livraison->ligneprospections as $key => $ligne) { ?>
                                                            <td class="text-center"><?= start0($ligne->quantite) ?></td>
                                                        <?php   } ?>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td>
                                            <?php if ($date == dateAjoute()) { ?>
                                                <button style="margin-top: -3%" onclick="validerProg(<?= $livraison->getId() ?>)" class="cursor simple_tag pull-right"><i class="fa fa-file-text-o"></i> Faire la livraison</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php }else { ?>
                        <h1 style="margin-top: 30% auto;" class="text-center text-muted aucun"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucune livraison programmée en cours pour le moment !</h1>
                    <?php } ?>

                </div>
            </div>
        </div>


        <?php include($this->rootPath("webapp/vente/elements/templates/footer.php")); ?>

    </div>
</div>


<?php include($this->rootPath("webapp/vente/elements/templates/script.php")); ?>
<script type="text/javascript" src="<?= $this->relativePath("../../master/client/script.js") ?>"></script>


</body>

</html>
