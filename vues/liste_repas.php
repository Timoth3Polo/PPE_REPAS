<?php
session_start() ;
$_SESSION['entete']='OUI';
include "../includes/fonc/fonctions_date.php";
include "../includes/modele/gestion_bdd.php";


$_SESSION['titreEtat'] = "BTS : Repas pris entre le ". getDateJMA($_SESSION['dateDebut']). " et le ".getDateJMA($_SESSION['dateFin']);

include "../includes/pdf_util/fpdf.php";
include "../includes/pdf_util/phpToPDF.php";


				 
$proprieteHeader = array(
	'T_COLOR' => array(0,0,0),
	'T_SIZE' => 9,
	'T_FONT' => 'Arial',
	'T_ALIGN_COL0' => 'L',
	'T_ALIGN' => 'C',
	'V_ALIGN' => 'T',
	'T_TYPE' => 'N',
	'LN_SIZE' => 5,
	'BG_COLOR_COL0' => array(255, 255, 255),
	'BG_COLOR' => array(255, 255, 255),
	'BRD_COLOR' => array(0,0,0),
	'BRD_SIZE' => 0.1,
	'BRD_TYPE' => 1,
	'BRD_TYPE_NEW_PAGE' => '',
	); 


$proprieteContenu = array(
	'T_COLOR' => array(0,0,0),
	'T_SIZE' => 11,
	'T_FONT' => 'Arial',
	'T_ALIGN_COL0' => 'L',
	'T_ALIGN' => 'R',
	'V_ALIGN' => 'T',
	'T_TYPE' => 'N',
	'LN_SIZE' => 6,
	'BG_COLOR_COL0' => array(255, 255, 255),
	'BG_COLOR' => array(255,255,255),
	'BRD_COLOR' => array(0,0,0),
	'BRD_SIZE' => 0.1,
	'BRD_TYPE' => '1',
	'BRD_TYPE_NEW_PAGE' => '',
	); 
// Définition des propriétés du tableau.
$proprietesTableau = array(
	'BRD_COLOR' => array(0,0,0),
	'BRD_SIZE' => '0.1',
	'TB_ALIGN' => 'C',
	'L_MARGIN' => 0,
	); 

$pdf=new phpToPDF();
$pdf->SetMargins(5,0,0);
$pdf->SetAutoPageBreak(true,10);
$pdf->startPageNums();
$pdf->AliasNbPages();

$pdf->AddPage(); 
$pdf->SetFont('Arial','',10);

// Contenu du header du tableau.	
$contenuHeader = array() ;
$contenuTableau=array();

$numCellEntete=0;
if ($_SESSION['typeRepas'] == 2) {
    $contenuHeader[$numCellEntete++]=50 ;
    $contenuHeader[$numCellEntete++]=50;
    $contenuHeader[$numCellEntete++]=50;
}
 else {
    $contenuHeader[$numCellEntete++]=50 ;
    $contenuHeader[$numCellEntete++]=30;
}

if ($_SESSION['typeRepas'] == 2) {
    $contenuHeader[$numCellEntete++]='[C] Date' ; 
    $contenuHeader[$numCellEntete++]='[C] Nom' ; 
    $contenuHeader[$numCellEntete++]='[C] '.utf8_decode('Prénom') ; 
}
 else {
    $contenuHeader[$numCellEntete++]='[C] Date' ; 
    $contenuHeader[$numCellEntete++]='[C] Nombre de repas' ;
}


$numCellDetail=0;

if ($_SESSION['typeRepas']==2)
    $lesRepasPris = getLesRepasDetail($_SESSION['dateDebut'], $_SESSION['dateFin']) ;
else 
    $lesRepasPris = getLesRepasCumul($_SESSION['dateDebut'], $_SESSION['dateFin']) ;

$cumulNbRepas = 0 ;
foreach($lesRepasPris as $ligne)
{
        $laDateAffiche = $ligne['dateMenu'] ;
        $laDateView=  getDateJMA($laDateAffiche) ;

        $contenuTableau[$numCellDetail++]= ''.$laDateView ; 
        if ($_SESSION['typeRepas'] == 2)
        {
            $contenuTableau[$numCellDetail++]=''.utf8_decode($ligne['nom']) ;
            $contenuTableau[$numCellDetail++]=utf8_decode($ligne['prenom']) ; 
            $cumulNbRepas++ ;
        }
        else 
        {
            $contenuTableau[$numCellDetail++]='[R] '.$ligne['nbRepas'] ; 
            $cumulNbRepas += $ligne['nbRepas'] ;
        }
}    
	
if ($_SESSION['typeRepas'] == 2)
{
    $contenuTableau[$numCellDetail++]='' ;
    $contenuTableau[$numCellDetail++] = '[B] Nombre total de repas : ' ; 
    $contenuTableau[$numCellDetail++] =  '[RB] '.$cumulNbRepas ;     
}
else 
{
    $contenuTableau[$numCellDetail++] = '[B] Nombre total de repas : ' ; 
    $contenuTableau[$numCellDetail++] =  '[RB] '.$cumulNbRepas ;  
}

$pdf->drawTableau($pdf, $proprietesTableau, $proprieteHeader, $contenuHeader, $proprieteContenu, $contenuTableau); 


$pdf->Output();

?>