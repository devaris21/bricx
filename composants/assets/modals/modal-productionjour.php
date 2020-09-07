
<div class="modal inmodal fade" id="modal-productionjour" style="z-index: 1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="ibox-content">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="row">
                        <div class="col-sm-7">
                            <h2 class="title text-uppercase gras text-orange">Fiche de rapport journalier</h2>
                        </div>
                        <div class="col-sm-5 text-right">
                            <h5 class="text-uppercase">Dernière mise à jour: // <span style="font-weight: normal;"><?= $productionjour->employe->name()  ?></span></h5>
                            <h5><?= datelong($productionjour->modified) ?></h5>
                        </div>
                    </div><hr>

                    <form id="formProductionJour" classname="productionjour">
                        <h3 class="text-uppercase"><u>Productions du jour</u></h3>
                        <div class="row">
                            <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                                <div class="col-sm col-md">
                                    <label><b><?= $produit->name() ?></b> produits</label>
                                    <input type="number" data-toggle="tooltip" title="Production du jour" value="0" min=0 number class="gras form-control text-center" name="prod-<?= $produit->getId() ?>">
                                </div>
                            <?php } ?>
                        </div><br>

                        <h3 class="text-uppercase"><u>Autres perte du jour</u></h3>
                        <div class="row">
                            <?php foreach (Home\PRODUIT::getAll() as $key => $produit) { ?>
                                <div class="col-sm col-md">
                                    <label class="text-danger"><b><?= $produit->name() ?></b> perdus</label>
                                    <input type="number" value="0" min=0 number class="gras form-control text-center text-danger" name="perte-<?= $produit->getId() ?>">
                                </div>
                            <?php } ?>
                        </div><br>

                        <h3 class="text-uppercase"><u>Consommation du jour</u></h3>
                        <div class="row">
                            <?php foreach (Home\RESSOURCE::getAll() as $key => $ressource) { ?>
                                <div class="col-md">
                                    <label class=" text-blue"><?= $ressource->name() ?> (<?= $ressource->abbr ?>) consommé</label>
                                    <input data-toggle="tooltip" title="Quantité consommé aujourd'hui" type="number" value="0" min=0 number class="gras form-control text-center" name="conso-<?= $ressource->getId() ?>">
                                </div>
                            <?php } ?>
                        </div><hr>
       
                        <div class="">
                            <button class="btn pull-right dim btn-primary" ><i class="fa fa-check"></i> Mettre à jour le rapport</button>
                        </div><br>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
