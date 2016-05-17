<?php
             /* On recup les ligues pour les mettre dans la liste 
                */                      
                                     
              echo '<select name="listligue" style=" width: 180px;">';

              $req = $bdd->query('SELECT * FROM ligue');
                        
              while ($recup = $req->fetch()) 
              {
                echo '<option>'.$recup['intitule']; 
                
              }

                echo "</select><br/><br/>";
?>