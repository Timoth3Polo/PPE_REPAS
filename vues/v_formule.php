<div class="home">
    <div id="Home_title">
        Gestion des marques des véhicules       
    </div>
    <table class="table">  
        <tr>
            <td colspan="3">
                Ajouter une nouvelle formule
                <a href="index.php?uc=gestion&action=formuleajouter"><img src="includes/img/plus.png" width="30">
            </td>
        </tr>
        <tr>
            <th>Libellé</th>
            <th></th>
            <th></th>  
        </tr>
        <?php
        foreach ($lesFormules as $laFormule) {
            echo '<tr>' ;
            
            if (isset($_REQUEST['action']) && ($_REQUEST['action'] == 'modifier') 
                    && isset($_REQUEST['id']) && ($_REQUEST['id'] == $laFormule['id'] )) {
                echo ''
                . '<form method="POST" action="index.php?uc=gestion&action=formulevalidmodif">'
                . '<td><input type="hidden" name="id" value="' . $_REQUEST['id'] . '">'
                . '<input type="text" name="libelle" value="' . $laFormule['libelle'] . '"></td>'
                . '<td><input type="submit" value="Valider"></td>'
                . '</form>'
                . '</td>' 
                . '<td></td>' ;
            }
            else {
                echo '<td>'
                . $laFormule['libelle']
                . '</td>' 
                . '<td>'
                . '<form method="POST" action="index.php?uc=gestion&action=formulemodifier">'
                . '<input type="hidden" name="id" value="' . $laFormule['id']. '">'
                . '<input type="submit" value="Modifier">'
                . '</form>'
                . '</td>' ;            
                echo 
                  '<td>'
                        . '<form method="POST" action="index.php?uc=gestion&action=formulesupprimer">'
                        . '<input type="hidden" name="id" value="' . $laFormule['id']. '">'
                        . '<input type="submit" value="Supprimer">'
                        . '</form>'
                 . '</td>' ;
            }
            echo '</tr>';
        }
        ?>
    </table>
</div>