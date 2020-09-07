<!DOCTYPE html>
<html>

<?php include($this->rootPath("webapp/agence/elements/templates/head.php")); ?>


<body class="fixed-sidebar">

    <div id="wrapper">

        <?php include($this->rootPath("webapp/agence/elements/templates/sidebar.php")); ?>  

        <div id="page-wrapper" class="gray-bg">

          <?php include($this->rootPath("webapp/agence/elements/templates/header.php")); ?>  

          <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-9">
                <h2 class="text-uppercase text-warning gras">Les achats de stocks </h2>
            </div>
            <div class="col-sm-3">
                <button style="margin-top: 5%" data-toggle='modal' data-target="#modal-achat-stock" class="btn btn-warning dim"><i class="fa fa-plus"></i> Nouvel Achat de stock</button>
            </div>
        </div>

        <div class="wrapper wrapper-content">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Tous les achats de stocks</h5>

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
                <div class="ibox-content" style="min-height: 300px;">

                    <?php if (count($datas + $encours) > 0) { ?>
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                                <tr>

                                    <th data-toggle="true">Status</th>
                                    <th>Reference</th>
                                    <th>Fournisseur</th>
                                    <th>Montant</th>
                                    <th data-hide="all"></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php foreach ($encours as $key => $achat) {
                                $achat->actualise(); 
                                $lots = $achat->fourni("ligneachatstock");
                                ?>
                                <tr style="border-bottom: 2px solid black">
                                    <td class="project-status">
                                        <span class="label label-<?= $achat->etat->class ?>"><?= $achat->etat->name ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase gras">Achat de Stock</span><br>
                                        <span><?= $achat->reference ?></span>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $achat->fournisseur->name() ?></h6>
                                        <small>Effectué <?= depuis($achat->created) ?></small>
                                    </td>
                                    <td>
                                        <h3 class="gras text-orange"><?= money($achat->montant) ?> <?= $params->devise  ?></h3>
                                        <span><?= $achat->operation->structure ?> - <?= $achat->operation->numero ?></span>
                                    </td>
                                    <td class="border-right" style="width: 30%">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="no">
                                                    <?php foreach ($achat->ligneachatstocks as $key => $ligne) { 
                                                        $ligne->actualise(); ?>
                                                        <th class="text-center text-uppercase"><?= $ligne->produit->name() ?></th>
                                                    <?php } ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="no">
                                                    <?php foreach ($achat->ligneachatstocks as $key => $ligne) { ?>
                                                       <td class="text-center gras <?= ($achat->etat_id == Home\ETAT::VALIDEE)?'text-primary':'' ?>"><?= $ligne->quantite_recu ?></td>
                                                   <?php   } ?>
                                               </tr>
                                           </tbody>
                                       </table>
                                   </td>
                                   <td>
                                    <a href="<?= $this->url("fiches", "master", "achatstock", $achat->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
                                    <?php if ($employe->isAutoriser("modifier-supprimer")) { ?>
                                        <button onclick="annuler(<?= $achat->id ?>)" class="btn btn-white btn-sm"><i class="fa fa-close text-red"></i></button>
                                    <?php } ?>
                                    <button onclick="terminer(<?= $achat->id ?>)" class="btn btn-white btn-sm text-green"><i class="fa fa-check"></i> Valider</button>

                                </td>
                            </tr>
                        <?php  } ?>
                        <tr />
                        <?php foreach ($datas as $key => $achat) {
                            $achat->actualise(); 
                            $lots = $achat->fourni("ligneachatstock");
                            ?>
                            <tr style="border-bottom: 2px solid black">
                                <td class="project-status">
                                    <span class="label label-<?= $achat->etat->class ?>"><?= $achat->etat->name ?></span>
                                </td>
                                <td>
                                    <span class="text-uppercase gras">Achat de Stock</span><br>
                                    <span><?= $achat->reference ?></span>
                                </td>
                                <td>
                                    <h6 class="text-uppercase text-muted gras" style="margin: 0"><?= $achat->fournisseur->name() ?></h6>
                                    <small>Effectué <?= depuis($achat->created) ?></small>
                                </td>
                                <td>
                                    <h3 class="gras text-orange"><?= money($achat->montant) ?> <?= $params->devise  ?></h3>
                                    <span><?= $achat->operation->structure ?> - <?= $achat->operation->numero ?></span>
                                </td>
                                <td class="border-right" style="width: 30%">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="no">
                                                <?php foreach ($achat->ligneachatstocks as $key => $ligne) { 
                                                    $ligne->actualise(); ?>
                                                    <th class="text-center text-uppercase"><?= $ligne->produit->name() ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="no">
                                                <?php foreach ($achat->ligneachatstocks as $key => $ligne) { ?>
                                                   <td class="text-center gras <?= ($achat->etat_id == Home\ETAT::VALIDEE)?'text-primary':'' ?>"><?= $ligne->quantite_recu ?></td>
                                               <?php   } ?>
                                           </tr>
                                       </tbody>
                                   </table>
                               </td>
                               <td>
                                <a href="<?= $this->url("fiches", "master", "achatstock", $achat->id) ?>" target="_blank" class="btn btn-white btn-sm"><i class="fa fa-file-text text-blue"></i></a>
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

        <?php }else{ ?>
            <h1 style="margin: 6% auto;" class="text-center text-muted"><i class="fa fa-folder-open-o fa-3x"></i> <br> Aucun achat pour le moment</h1>
        <?php } ?>

    </div>
</div>
</div>


<?php include($this->rootPath("webapp/agence/elements/templates/footer.php")); ?>
<?php include($this->rootPath("composants/assets/modals/modal-achat-stock.php")); ?> 



<?php 
foreach ($encours as $key => $achat) {
    include($this->rootPath("composants/assets/modals/modal-achat-stock2.php"));
} 
?>

</div>
</div>


<?php include($this->rootPath("webapp/agence/elements/templates/script.php")); ?>


</body>

</html>
