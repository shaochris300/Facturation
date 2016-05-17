        <?php
          /*ON RECUPERE LE NOM DES PRESTATIONS POUR LES METTRES DANS LA LISTE DEROULANTE*/                      
            echo '<select name="listprestation" style=" width: 180px;">';
            $req = $bdd->query('SELECT * FROM prestation');          
            while ($recup = $req->fetch()) 
            {
              echo '<option>'.$recup['libelle'].': '.$recup['prix_unitaire']. '€/u'; 
            }
            echo "</select><br/><br/>";
    
        ?>