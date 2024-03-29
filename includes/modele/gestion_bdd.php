<?php
/**
 * Vérifie les identifiants de connexion et instancie les variables de session
 
 * @param $loginSaisi 
 * @param $mdpSaisi
 * @return un booléen true si utilisateur connu, false sinon 
*/
function verifierIdentification($loginSaisi,$mdpSaisi ) {
    require "connexion.php" ;
    $sql="select * from elior_utilisateur" ;
    $exec=$bdd->query($sql);
    $trouve = false ;
    $fin=false ;

    while (!$trouve && !$fin)
    {
        if ($ligne = $exec->fetch())
        {
        	/*
        	echo '<pre>';
     			var_dump($loginSaisi, $ligne['login'], md5($mdpSaisi), $ligne['mdp']);
     		echo '</pre>';*/
     		//var_dump($mdpSaisi);

            if ($ligne['login']==$loginSaisi && $ligne['mdp']==$mdpSaisi)
            {
                $trouve = true ;
                $_SESSION['ident']=$ligne['nom'].' '.$ligne['prenom']."&nbsp;&nbsp;&nbsp;&nbsp;" ;
                $_SESSION['idUtil']=$ligne['id'] ;
                $_SESSION['statut']=$ligne['statut'] ;
            }
        }
        else
        {
            $fin = true ;
        }
    }
    return $trouve ;
}

function getLesDatesCommandes($dateLimite, $idUtil)
{
    require "connexion.php" ;
    $sql="select distinct dateMenu "
            . "from elior_menu m "
            . "where dateMenu >= '$dateLimite' "
            . "and exists (select * from elior_commande c where m.dateMenu = c.dateMenu and c.idUtil = $idUtil) "
            . "order by dateMenu ASC" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}



function getLesDatesNonCommandes($dateLimite, $idUtil)
{
    require "connexion.php" ;
    $sql="select distinct dateMenu "
            . "from elior_menu m "
            . "where dateMenu >= '$dateLimite' "
            . "and not exists (select * from elior_commande c where m.dateMenu = c.dateMenu and c.idUtil = $idUtil) "
            . "order by dateMenu ASC" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesDatesMenus()
{
    require "connexion.php" ;
    $sql="select distinct dateMenu from elior_menu order by dateMenu DESC" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesMenus()
{
    require "connexion.php" ;
    $sql="select * from elior_menu ORDER BY dateMenu DESC, numMenu ASC LIMIT 0 , 120" ;
    $exec=$bdd->prepare($sql) ;   
    $exec->execute() ;
    return $exec;
}

function getLesMenusDate($dateJour)
{
    require "connexion.php" ;
    $sql="select * from elior_menu where dateMenu = '$dateJour' order by numMenu" ;
    $exec=$bdd->prepare($sql) ;
    
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesComptesEleves()
{
    require "connexion.php" ;
    $sql="select nom, prenom, idClasse, creditRepas from elior_utilisateur where (idClasse=1 OR idClasse=2) order by nom, prenom" ;
    $exec=$bdd->prepare($sql) ;  
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function getLesMenusJour($dateJour)
{
    require "connexion.php" ;
    $sql="select * from elior_menu where dateMenu = '$dateJour' order by numMenu" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function majMenu($dateMenu, $numMenu, $descMenu)
{       
    $descMenu = addslashes($descMenu) ;
    require "connexion.php" ;
    $sql="UPDATE elior_menu "
            . "SET descriptionMenu='$descMenu' "
            . "where dateMenu = '$dateMenu' and numMenu = $numMenu" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function getLesFormulesTableau()
{
    require "connexion.php" ;
    $sql="select libelle from elior_formule" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
}

function ajoutMenu($dateMenu, $numMenu, $descMenu, $id)
{       
    $descMenu = addslashes($descMenu) ;
    require "connexion.php" ;
    $sql="INSERT INTO elior_menu "
            . "values ('$dateMenu', $numMenu, '$descMenu', $id)" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function supMenu($dateMenu, $numMenu)
{       
    require "connexion.php" ;
    $sql="DELETE FROM elior_menu "
            . "where dateMenu = '$dateMenu' and numMenu = $numMenu" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function enrmdp($mdp, $idUtil)
{       
    require "connexion.php" ;
    $mdp=MD5($mdp);
    $sql="UPDATE elior_utilisateur "
            . "SET mdp='$mdp' "
            . "where id = '$idUtil'" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function majParams($heureDebutCde, $prixRepas, $nbRepasDecouvert)
{       
    require "connexion.php" ;
    $sql="UPDATE elior_params "
            . "SET heureDebutCde='$heureDebutCde', prixRepas='$prixRepas', nbRepasDecouvert=$nbRepasDecouvert" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
}

function getNbMenusDate($dateJour)
{
    require "connexion.php" ;
    $sql="select count(*) as nb from elior_menu where dateMenu = '$dateJour'" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['nb'];
}

function getLesCommandesJour($date)
{
    require "connexion.php" ;
    $sql="select * from elior_commande "
            . "inner join elior_utilisateur on id = idUtil and dateMenu = '$date' order by numMenu, nom, prenom ASC" ;
    $exec=$bdd->query($sql) ;
    return $exec ;
}

function getParams()
{
    require "connexion.php" ;
    $sql="select * from elior_params " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
}

function getFormule($idUtil, $dateMenu, $numMenu)
{
    require "connexion.php" ;
    $sql="
    select *
    from elior_formule 
    inner join elior_menu 
    on elior_formule.id = idFormule 
    inner join elior_commande
    on elior_menu.dateMenu = elior_commande.dateMenu 
    and elior_menu.numMenu = elior_commande.numMenu
    where elior_commande.idUtil = " . $idUtil .
    " and elior_commande.dateMenu = '" . $dateMenu . "'" .
    " and elior_menu.numMenu = " . $numMenu;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
}

/*function getMenu($numMenu, $dateMenu)
{
    require "connexion.php" ;
    $sql="select * from elior_menu where numMenu = " . $numMenu . " AND dateMenu = '" . $dateMenu ."'";
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
}*/

function getNbMenusJour($date)
{
    require "connexion.php" ;
    $sql="select * from elior_menu "
            . "where dateMenu = '$date'" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getNbCommandesJour($date)
{
    require "connexion.php" ;
    $sql="select * from elior_commande "
            . "where dateMenu = '$date'" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getNbCommandesMenuJour($date, $numMenu)
{
    require "connexion.php" ;
    $sql="select * from elior_commande "
            . "where dateMenu = '$date' and numMenu=$numMenu" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getLesCommandesUtil($idUtil)
{
    require "connexion.php" ;
    $sql="select * from elior_commande c "
            . "inner join elior_menu m on c.dateMenu = m.dateMenu and c.numMenu = m.numMenu where idUtil = $idUtil order by c.dateMenu DESC" ;
    $exec=$bdd->query($sql) ;
    return $exec ;
}

function getNbCommandesUtilMois($mm, $aa, $idUtil)
{
    require "connexion.php" ;
    $sql="select * from elior_commande where idUtil = $idUtil and year(dateMenu) = $aa and month(dateMenu) = $mm" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function getCommandeAujourdhui($date, $idUtil)
{
    require "connexion.php" ;
    $sql="select * from elior_commande where idUtil = $idUtil and dateMenu = '$date'" ;
    $exec=$bdd->query($sql) ;
    return $exec->rowCount() ;
}

function enregistrerCommande($dateMenu,$numMenu,$idUtil)
{
    require "connexion.php" ;
    $sql="INSERT INTO elior_commande values ('$dateMenu',$numMenu, $idUtil)" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute();
    
    //diminution du crédit repas
    //$menu = getMenu($numMenu, $dateMenu);
    $formule = getFormule($idUtil, $dateMenu, $numMenu);
    $prixRepas = (float)$formule['prix'];
    $sql="update elior_utilisateur SET creditRepas = creditRepas - $prixRepas where id=$idUtil" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql);
    $exec->execute();
}    

function annulerCommande($dateMenu, $idUtil) 
{
    require "connexion.php" ;
    $sql = "SELECT * FROM elior_commande WHERE dateMenu='$dateMenu' and idUtil = $idUtil";
    $exec=$bdd->prepare($sql);
    $exec->execute();
    $commande = $exec->fetch();

    //augmentation du crédit repas
    $formule = getFormule($commande['idUtil'], $commande['dateMenu'], $commande['numMenu']);
    $prixRepas = (float)$formule['prix'];
    $sql="update elior_utilisateur SET creditRepas = creditRepas + $prixRepas where id=$idUtil" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;

    $sql="DELETE FROM elior_commande where dateMenu='$dateMenu' and idUtil = $idUtil" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql);
    $exec->execute();
}
 
 function getLesEleves()
 {
    require "connexion.php" ;
    $sql="select id, nom, prenom, creditRepas, idClasse "
            . "from elior_utilisateur "
            . "where (idClasse=1 or idClasse=2) "
            . "order by nom, prenom " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function getUnEtudiant($idEleve)
{
    require "connexion.php" ;
    $sql="select * from elior_utilisateur where id = $idEleve" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
}

function getLesRepasCumul($dateDebut, $dateFin)
{
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "dateMenu between '$dateDebut' and '$dateFin' " ;
    
    $sql="select dateMenu, COUNT(*) as nbRepas "
            ." from elior_utilisateur "
            ." left join elior_commande on elior_utilisateur.id = idUtil "
            ." where ".$where." "
            . "group by dateMenu " 
            . "order by dateMenu ASC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function getLesRepasDetail($dateDebut, $dateFin)
{
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "dateMenu between '$dateDebut' and '$dateFin' " ;
    
    $sql="select dateMenu,nom, prenom "
            ." from elior_utilisateur "
            ." left join elior_commande on elior_utilisateur.id = idUtil "
            ." where ".$where." "
            . "order by dateMenu ASC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function getLesPaiements($dateDebut, $dateFin, $typeReglement, $idEleve)
 {
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "datePaiement between '$dateDebut' and '$dateFin' " ;
    
    if ($typeReglement != 3) $where .= " and typeReglement=".$typeReglement ;
    
    if ($idEleve != 0) $where .= " and idEleve=".$idEleve ;
    
    $sql="select elior_paiement.id, idEleve, nom, prenom, datePaiement, montant, typeReglement, remarques "
            ." from elior_utilisateur "
            ." left join elior_paiement on elior_utilisateur.id = idEleve "
            ." where ".$where." "
            . "order by datePaiement DESC " ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
 
 function exportPaiements($dateDebut, $dateFin, $typeReglement, $idEleve)
 {
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "datePaiement between '$dateDebut' and '$dateFin' " ;
    
    if ($typeReglement != 3) $where .= " and typeReglement=".$typeReglement ;
    
    if ($idEleve != 0) $where .= " and idEleve=".$idEleve ;
    
    $sql="select elior_paiement.id, idEleve, nom, prenom, datePaiement, montant, typeReglement, remarques "
            ." from elior_utilisateur "
            ." left join elior_paiement on elior_utilisateur.id = idEleve "
            ." where ".$where." "
            . "order by datePaiement DESC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    
    $nomFichier = "bts_paiements_export.csv" ;
			
    $fp = fopen($nomFichier, 'w');
	
    fwrite($fp, utf8_decode("Date;Nom;Prénom;Montant;Type règlement;Remarques\n"));
    foreach ($curseur as $ligne)
    {
        if ($ligne['typeReglement'] == 1) $typeReglement = "Espèces";
        if ($ligne['typeReglement'] == 2) $typeReglement = "Chèque";
        $ligne_xls=  getDateJMA($ligne['datePaiement']).";".utf8_decode($ligne['nom']).";".utf8_decode($ligne['prenom']).";".$ligne['montant'].";".utf8_decode($typeReglement).";".utf8_decode($ligne['remarques']) ;
        fwrite($fp, $ligne_xls."\n");
    }  
    fclose($fp);
 }
 
 function exportRepas($dateDebut, $dateFin, $typeRepas, $lesRepasPris)
 {
    require "connexion.php" ;
    
    $nomFichier = "bts_listerepas_export.csv" ;
            
    $fp = fopen($nomFichier, 'w');
    
    fwrite($fp, "BTS - Nombre de repas du ".getDateJMA($dateDebut)." au ".getDateJMA($dateFin)."\n\n");
    
    $cumulNbRepas = 0 ;
    if ($typeRepas == 2)
        fwrite($fp, utf8_decode("Date;Nom;Prénom\n"));
    else
    {
        if($typeRepas == 3)
        {
            fwrite($fp, utf8_decode("Libelle;Nombre de repas\n")) ; 
        }
        else
        {
            fwrite($fp, utf8_decode("Date;Nombre de repas\n"));
        }
    }
    
    foreach ($lesRepasPris as $ligne)
    {
        if ($typeRepas == 2)
        {
            $ligne_xls=  getDateJMA($ligne['dateMenu']).";".utf8_decode($ligne['nom']).";".utf8_decode($ligne['prenom']) ;
            $cumulNbRepas++ ;
        }
        else
        {
            if($typeRepas == 3)
            {
                $ligne_xls = getDateJMA($ligne['libelle']).";".($ligne['nbRepas']) ; 
                $cumulNbRepas++;
            }
            else
            {
                $ligne_xls=  getDateJMA($ligne['dateMenu']).";".$ligne['nbRepas'] ;
            $cumulNbRepas += $ligne['nbRepas'] ;
            }
        }
        fwrite($fp, $ligne_xls."\n");
    }  
    if ($typeRepas == 2)
    {
        fwrite($fp, ";Nombre total de repas;".$cumulNbRepas."\n");
    }
    else {
        fwrite($fp, "Nombre total de repas;".$cumulNbRepas."\n");
    }
    fclose($fp);
 }
 
 function getDescriptionMenu($dateMenu,$numMenu) 
 {
    require "connexion.php" ;

    $sql="select descriptionMenu "
            ." from elior_menu "
            ." where dateMenu='$dateMenu' and numMenu=$numMenu" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['descriptionMenu'];
 }
 
 function getDescriptionMenu($dateMenu,$numMenu) 
 {
    require "connexion.php" ;

    $sql="select descriptionMenu "
            ." from elior_menu "
            ." where dateMenu='$dateMenu' and numMenu=$numMenu" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['descriptionMenu'];
 }
 
 function getSolde($idEleve) 
 {
     require "connexion.php" ;

    $sql="select creditRepas "
            ." from elior_utilisateur "
            ." where id=$idEleve" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur['creditRepas'];
 }
 
 function getLePaiement($id)
 {
    require "connexion.php" ;

    $sql="select elior_paiement.id, idEleve, nom, prenom, datePaiement, montant, typeReglement, remarques "
            ." from elior_utilisateur "
            ." left join elior_paiement on elior_utilisateur.id = idEleve "
            ." where elior_paiement.id=$id" ;

    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetch();
    return $curseur;
 }
 
 function enregistrerPaiement($idEleve, $datePaiement, $montant, $typeReglement, $remarques) 
 {
    require "connexion.php" ;
    $remarques = addslashes($remarques) ;
    $sql="INSERT INTO elior_paiement (idEleve, datePaiement, montant, typeReglement, remarques) "
            . " values ($idEleve, '$datePaiement',$montant, $typeReglement, '$remarques')" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;$remarques = addslashes($remarques) ;
    
    //augmenter le crédit repas de l'élève
    $sql="update elior_utilisateur set creditRepas = creditRepas + $montant where id = $idEleve" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
 }
 function modifierPaiement($idEleve, $datePaiement, $montant, $typeReglement, $remarques, $id) 
 {
    require "connexion.php" ;
    $remarques = addslashes($remarques) ;
    //récupération ancien montant enregistrer
    $lePaiement = getLePaiement($id) ;
    $montantAvant = $lePaiement['montant'] ;
    $montantApres = $montant ;
    
    //mise à jour du paiement
    $sql="UPDATE elior_paiement 
          SET datePaiement = '$datePaiement', montant=$montant, typeReglement=$typeReglement, remarques='$remarques', idEleve=$idEleve
          WHERE id=$id";

    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
    //mise à jour du crédit repas de l'élève si le le montant a changé
    $diff = $montantApres - $montantAvant ;
    
    $sql="update elior_utilisateur set creditRepas = creditRepas + $diff where id = $idEleve" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
 }
 
  function supprimerPaiement($id) 
 {
    require "connexion.php" ;
    //récupération ancien montant enregistrer
    $lePaiement = getLePaiement($id) ;
    $idEleve = $lePaiement['idEleve'] ;
    $montantAvant = $lePaiement['montant'] ;
    $montantApres = 0;
    
    //mise à jour du paiement
    $sql="DELETE from elior_paiement 
          WHERE id=$id";

    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
    //mise à jour du crédit repas de l'élève si le le montant a changé
    $diff = $montantApres - $montantAvant ;
    
    $sql="update elior_utilisateur set creditRepas = creditRepas + $diff where id = $idEleve" ;
    //exécution de la requete
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    
 }

  // Récuperer toute les formules
 function getLesFormules()
 {
    require "connexion.php" ;
    $sql = "select * from elior_formule" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }

 // Récuperer infos d'une formule
 function getLaFormule($id) {
    require "connexion.php" ;
    $sql = "select * from elior_formule where id = $id" ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $ligne=$exec->fetch();
    return $ligne;
}

function getLesRepasFormule($dateDebut, $dateFin)
{
    require "connexion.php" ;
    
    //analyse des filtres
    $where = "e.dateMenu between '$dateDebut' and '$dateFin' " ;
    
    $sql="select libelle, COUNT(*) as nbRepas "
            ." from elior_menu e  "
            ." inner join elior_commande c  on e.numMenu = c.numMenu and e.dateMenu = c.dateMenu "
            . " left join elior_formule  on e.idFormule = id"
            ." where ".$where." "
            . "group by libelle " 
            . "order by nbRepas DESC " ;
    $exec=$bdd->prepare($sql) ;
    $exec->execute() ;
    $curseur=$exec->fetchAll();
    return $curseur;
 }
?>