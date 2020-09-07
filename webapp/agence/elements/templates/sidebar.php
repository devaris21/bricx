<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <h1 class="logo-name text-center" style="font-size: 50px; letter-spacing: 5px; margin: 0% auto !important; padding: 0% !important;">BRICX</h1>
            <li class="nav-header" style="padding: 15px 10px !important; background-color: orange">
                <div class="dropdown profile-element">                        
                    <div class="row">
                        <div class="col-3">
                            <img alt="image" class="rounded-circle" style="width: 35px" src="<?= $this->stockage("images", "employes", $employe->image) ?>"/>
                        </div>
                        <div class="col-9">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold"><?= $employe->name(); ?></span>
                                <span class="text-muted text-xs block"><?= $agence->name(); ?></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="<?= $this->url("main", "access", "locked") ?>">Vérouiller la session</a></li>
                                <li><a class="dropdown-item" href="#" id="btn-deconnexion" >Déconnexion</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="logo-element">
                    BRICX
                </div>
            </li>

            <?php 
            $groupes__ = Home\GROUPECOMMANDE::encours();
            $approvisionnements__ = Home\APPROVISIONNEMENT::encours();

            ?>
            <ul class="nav metismenu" id="side-menu">
                <li class="" id="dashboard">
                    <a href="<?= $this->url($this->section, "master", "dashboard") ?>"><i class="fa fa-tachometer"></i> <span class="nav-label">Tableau de bord</span></a>
                </li>
                <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>


                <?php if ($employe->isAutoriser("production")) { ?>
                    <li class="" id="production">
                        <a href="<?= $this->url($this->section, "production", "production") ?>"><i class="fa fa-free-code-camp"></i> <span class="nav-label">Les Productions</span></a>
                    </li>
                    <li class="" id="achatstock">
                        <a href="<?= $this->url($this->section, "production", "achatstock") ?>"><i class="fa fa-free-code-camp"></i> <span class="nav-label">Achats de stock</span></a>
                    </li>
                    <li class="" id="perteagence">
                        <a href="<?= $this->url($this->section, "production", "perteagence") ?>"><i class="fa fa-trash"></i> <span class="nav-label">Perte en agence</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                <?php } ?>

                
                <?php if ($employe->isAutoriser("stock")) { ?>
                    <li class="" id="fournisseurs">
                        <a href="<?= $this->url($this->section, "stock", "fournisseurs") ?>"><i class="fa fa-address-book-o"></i> <span class="nav-label">Liste des Fournisseurs</span></a>
                    </li>
                    <li class="" id="approvisionnements">
                        <a href="<?= $this->url($this->section, "stock", "approressource") ?>"><i class="fa fa-truck"></i> <span class="nav-label">Approvisionnements</span></a>
                    </li>
                    <li class="" id="ressources">
                        <a href="<?= $this->url($this->section, "stock", "ressources") ?>"><i class="fa fa-address-book-o"></i> <span class="nav-label">Stock de ressources</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #000; "></li>
                <?php } ?>


                <?php if ($employe->isAutoriser("rapports")) { ?>
                    <li class="" id="rapportproduction">
                        <a href="<?= $this->url($this->section, "rapports", "rapportproduction") ?>"><i class="fa fa-file-text-o"></i> <span class="nav-label">Rapport de production</span></a>
                    </li>
                    <li style="margin: 3% auto"><hr class="mp0" style="background-color: #aaa; "></li>
                <?php } ?>
                


            </ul>

        </ul>

    </div>
</nav>

<style type="text/css">
    li.dropdown-divider{
       !important;
   }
</style>