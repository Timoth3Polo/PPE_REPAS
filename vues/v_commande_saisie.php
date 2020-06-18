<div class="home">
  <form name="repas_saisie" action="index.php?uc=commande&action=valider" method="POST" autocomplete="off">
    <div id="Home_title_ss">
      <?php    
      if ($solde < $prixRepas)
      {
        echo '<div id="Titles"><b>'.$_SESSION['ident'].'</b>'
        . '<br />Solde = '.$solde.' €.</div>'
        . '<div id="Home_title_struct">Veuillez recharger votre compte.'
        . '<br />Crédit autorisé : '.$nbRepasPossibles.' repas</div>';
      }
      else 
      {
        echo '<div id="Titles"><b>'.$_SESSION['ident'].'</b>'
        . '<br />Solde = '.$solde." €, soit ".$nbRepasPossibles." repas</div>";
      }
      echo 'Commande repas du '.$ladateJMA.'</br></br>' ;
      echo '<input type="hidden" name="date" value="'.$ladateAMJ.'">' ;
      ?>
    </div>
    <div style = "text-align: left; margin-left: 30vw;">
      <?php
      $tableau_formule = ['Plat + Dessert', 'Entrée + Plat', 'Entrée + Plat + Dessert', 'Plat', 'Restauration rapide'];
      if ($nbMenus == 1) $checked = " checked " ; else $checked = "" ;
      for($i = 1; $i < 6; $i++)
      {
        for($j = 1; $j < 4 ; $j++)
        {
          foreach ($lesMenus as $k => $leMenu)
          {
            /*>
            <pre>
              <?php
                var_dump($leMenu);
              ?>
            </pre>
            <?php*/
            if((int)$leMenu['idformule'] === $i && (int)$leMenu['numMenu'] === $j)
            {
              echo '<label style = "text-align:left"> ' . $leMenu['numMenu'] . '/&nbsp' . $tableau_formule[$i-1] .' &nbsp - &nbsp&nbsp </label><input type="radio" name="numMenu" value ="'.$leMenu['numMenu'].'"'.$checked.'>&nbsp;&nbsp;&nbsp;'.$leMenu['descriptionMenu'].'<br />';
            }
          }
        }
        echo '<br/><br/><br/>';
      }
      ?>
      <div style = "margin-left: 16.5vw;">
      <?php
      echo '</br>
      <input type="submit" class="btn btn-info connectbt" name="valider" value="Valider">&nbsp;&nbsp; </div>' ;
      ?>
      </div>
    </div>
  </form>
</div>