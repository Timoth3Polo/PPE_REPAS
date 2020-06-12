
      <div class="home">
          
          <div id="Home_title_ss">
              <br /><br />
              <?php
              echo '<div id="Titles">Utilisateur connecté : '.$_SESSION['ident']."<br /></div>";
        
              echo 'Afficher les soldes des comptes élèves<br />' ;
            $cpt=0 ;
             foreach ($lesComptes as $leCompte) {
                 //entête tableau 
                 if ($cpt==0)
                 {
                     echo '<div id="list_paiements" class="table-responsive"><table><tr>'
                        . '<th>Nom</th>'
                        . '<th>Prénom</th>'
                        . '<th>Classe</th>'
                        . '<th>Solde</th>'                                              
                        . '</tr>' ;
                 }
                 
                 echo '<tr>'

              . '<td>'.$leCompte['nom'].'</td>'
              . '<td>'.$leCompte['prenom'].'</td>'
              . '<td>BTS'.$leCompte['idClasse'].'</td>'
              . '<td>'.$leCompte['creditRepas'].'</td>'
              . '</tr>' ;
                
              $cpt++;
    
              }
              echo '</table></div></div>' ;

              ?>
            
          </div>

      </div>