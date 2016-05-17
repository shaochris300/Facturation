<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Facture</title>
    </head>
  
    <body>

    <?php 
    /*ON RECUPERE LE NUMERO DE LA FACTURE A MODIFIE*/
        if (isset($_GET['num']) && is_numeric($_GET['num'])) {/*VERIFIE SI UNE VARIBLE EST DE TYPE NUMERIQUE*/

          $num = $_GET['num'];/*INTVAL RETOURNE LA VALEUR NUMERIQUE D'UNE VARIABLE*/

      ?>
  	<section>
  	<style type="text/css">

    </style>
  		<article>
        <?php 
        /*ON RECUPERE LA FACTURE GRACE A SON NUMERO*/
          $facture = $bdd->query('SELECT * FROM facture WHERE numfacture = '.$num.'');

            $elementfacs = $facture->fetch();
        /*ON RECUPERE LES INFOS SUR LA LIGUE CONCERNEE*/
            $ligue = $bdd->query('SELECT * FROM ligue WHERE numcompte = '.$elementfacs['compte_ligue'].'');
            $elementligues = $ligue->fetch();
        /*ON RECUPERE LES PRESTATIONS*/
            $presta = $bdd->query('SELECT * FROM prestation');
            $elementpres = $presta->fetch();

        ?>
        <h3>Facture n° <?php echo $num;?></h3>
        <p><strong><?php echo $elementligues['intitule']; ?></strong><br/>
        A l'attention de <?php echo $elementligues['nomtresorier']; ?><br/>
        <?php echo $elementligues['adrue'];?><br/>
        <?php echo $elementligues['cp']; ?>&nbsp;
        <?php echo $elementligues['ville']; ?><br/><br/><br/>
        </p>
        <p>Code client : <?php echo $elementfacs['compte_ligue'];?><br/>
          Date : <?php echo $elementfacs['datefacture'];?>&nbsp;&nbsp;&nbsp; Echéance : <?php echo $elementfacs['echeance'];?><br/>
        
        <br/>  
        </p>
        <hr/><br/>
        <table border="4" align="center">
        <tr>
          <th>Référence</th>
          <th>Libellé</th>
          <th>Quantité</th>
          <th>Prix Unitaire HT</th>
          <th>Montant HT</th>
        </tr>
        
        <?php 
          
          $presta = $bdd->query('SELECT * FROM prestation');
          $total = array();
          $totalfinal = 0;
          $i = 0;
          while ($elementpres = $presta->fetch()) 
          {
        ?>
        <tr>
          
          <?php
            /*ON AFFICHE NOTRE FACTURE SOUS FORME DE TABLEAU*/
                $ligne_facture = $bdd->prepare('SELECT * FROM ligne_facture WHERE numfacture = :numfacture ORDER BY code_prestation ASC');
                $ligne_facture->execute(array(
                  'numfacture'=>$elementfacs['numfacture'], 
                  )) or die(print_r($ligne_facture->errorInfo()));
                while ($lignes = $ligne_facture->fetch()) 
                {
                  if ($lignes['code_prestation'] == $elementpres['codepres']) 
                  {
                    echo '<td>';
                    echo '<strong>'.$elementpres['codepres'].'</strong>';
                    echo '</td>';
                    echo '<td>';
                    echo '<strong>'.$elementpres['libelle'].'</strong>';
                    echo '</td>';
                    echo '<td>';
                    echo $lignes['quantite'];
                    echo '</td>';
                    echo '<td>';
                    echo $elementpres['prix_unitaire'];
                    echo '</td>';
                    $quantite = $lignes['quantite'];
                    $pu = $elementpres['prix_unitaire'];
                    $resul = $quantite*$pu;
                    $total[$i] = $resul;
                    echo '<td>';
                    echo $total[$i];
                    echo '</td>';
                    
                  }
                  
                  $i++;
                }
              ?>
        </tr>
        
        <?php } ?>
        <tr><td></td><td></td><td></td><td></td><td><strong style="text-align:center;">Total TTC</strong></td><td><?php echo array_sum($total).'€'; ?></td></tr>
      </table>
      <br/><hr>
      <p>Déclaré à la préfecture de Meurthe et Moselle<br/>
      Domiciliation bancaire 10278 04065 000 166911045 05<br/>
      Merci de bien vouloir préciser les références de la facture acquittée<br/>
      TVA non applicable<br/>
      <a href="javascript:window.print()">Imprimer cette page</a> <!-- FONCTION JAVASCRIPT POUR IMPRIMER UNE PAGE -->
      </p>
  		</article>

  	</section>
    <?php 

      }else header('Location:index.php');
    ?>

    </body>
</html>
