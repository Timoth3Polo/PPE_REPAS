<?php

$PARAM_hote='stadjutoogg3.mysql.db'; // le chemin vers le serveur
$PARAM_port='';
$PARAM_nom_bd='stadjutoogg3'; // le nom de votre base de donn�es
$PARAM_utilisateur='stadjutoogg3'; // nom d'utilisateur pour se connecter
$PARAM_mot_passe='feuDartifis03'; // mot de passe de l'utilisateur pour se connecter

//$PARAM_hote='localhost'; // le chemin vers le serveur
//$PARAM_port='';
//$PARAM_nom_bd='dbrepas'; // le nom de votre base de donn�es
//$PARAM_utilisateur='root'; // nom d'utilisateur pour se connecter
//$PARAM_mot_passe=''; // mot de passe de l'utilisateur pour se connecter

try
{
    $bdd = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_bd, $PARAM_utilisateur, $PARAM_mot_passe);
    $bdd->exec("SET CHARACTER SET utf8");
}
 
catch(Exception $e)
{
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
}
?>