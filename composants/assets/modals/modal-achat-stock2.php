
<div class="modal inmodal fade" id="modal-achat-stock<?= $achat->getId() ?>" style="z-index: 99999999">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Validation de l'achat de stock</h4>
            <small class="font-bold">Renseigner ces champs pour terminer l'achat de stock</small>
        </div>
        
            <form class="formValiderAchat">
        <div class="row">
                <div class="col-md-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="text-uppercase">Les produits effectivement reçus</h5>
                        </div>
                        <div class="ibox-content"><br>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody class="commande">
                                        <?php foreach ($achat->ligneachatstocks as $key => $ligne) {
                                            $ligne->actualise(); ?>
                                            <tr class="border-0 border-bottom " id="ligne<?= $ligne->getId() ?>" data-id="<?= $ligne->produit->getId() ?>">
                                                <td >
                                                    <img style="width: 40px" src="<?= $this->stockage("images", "produits", $ligne->produit->image) ?>">
                                                </td>
                                                <td class="text-left">
                                                    <h4 class="mp0 text-uppercase"><?= $ligne->produit->name() ?></h4>
                                                    <small><?= $ligne->produit->description ?></small>
                                                </td>
                                                <td width="105">
                                                    <label>Quantité livrée</label>
                                                    <input type="number" number class="form-control text-center gras" value="<?= $ligne->quantite ?>" max="<?= $ligne->quantite ?>">
                                                </td>
                                                <td> / <?= $ligne->quantite ?></td>
                                            </tr>
                                        <?php }  ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-4 ">
                    <div class="ibox"  style="background-color: #eee">
                        <div class="ibox-title" style="padding-right: 2%; padding-left: 3%; ">
                            <h5 class="text-uppercase">Finaliser l'achat de stock</h5>
                        </div>
                        <div class="ibox-content"  style="background-color: #fafafa">
                            <div>
                                <label>Commentaire </label>
                                <textarea class="form-control" rows="4" name="comment"></textarea>
                            </div><br>
                            <button class="btn btn-primary btn-block dim"><i class="fa fa-check"></i> Terminer l'achat</button>
                        </div>
                    </div>

                </div>
        </div>
            </form>

    </div>
</div>
</div>


