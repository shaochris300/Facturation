<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Index</title>
    </head>
  
    <body>
    <?php require 'header.php'; ?>
  	<section>
      <br />
      <div id ="presentation">
        <h2>Bienvenue sur l'application facturation</h2>
        <p>L'application permet :<br/>
          <ul>
            <li>ajouter ou modifier des enregistrements dans la table LIGUE;</li>
            <li>ajouter ou modifier des enregistrements dans la table PRESTATION;</li>
            <li>saisir de façon la plus guidée possible les différents éléments de facturation</li>
            <li>trouver une facture pour pouvoir l'imprimer.</li>
          </ul>
       </p>
     </div>
  		<article>
        <h2>Consulter les factures</h2>
        <?php 
          $sql = $bdd->query("SELECT * FROM facture");

        ?>
        <br/><br/>
  			<table border="4" align="center">
  				<tr>
  					<th>Numéro de la Facture</th>
            <th>Date de la Facture</th>
            <th>Échéance de la Facture</th>
            <th>Ligue concernée</th>
  				</tr>
          <?php 
            while ($infos = $sql->fetch()) 
            {
              /*AFFICHE LES FACTURES*/
             $req = $bdd->query('SELECT * FROM ligue WHERE numcompte = '.$infos['compte_ligue']);

          ?>
  				<tr>
            <td><a href="facture.php?num=<?php echo $infos['numfacture']; ?>">FC <?php echo $infos['numfacture']; ?></a></td>
  				  <td><?php
                $date = $infos['datefacture'];
                $dates = explode('-', $infos['datefacture']); /*EXPLODE PERMET DE COUPER UNE CHAINE DE CARACTERE EN PLUSIEURS PARTIES*/
                echo $dates[2].'/'.$dates[1].'/'.$dates[0]; 
                ?>
            </td>
            <td><?php $echeance = $infos['echeance']; $echeances = explode('-', $infos['echeance']);
                echo $echeances[2].'/'.$echeances[1].'/'.$echeances[0] ?></td>
            <td>
              <?php 
                while ($donnees = $req->fetch()) {
                  if ($donnees['numcompte'] == $infos['compte_ligue']) {
                    echo $donnees['intitule'];                    
                  }
                }
              ?>
            </td>
          </tr>

          <?php } ?>
  			</table>
  		</article>

  	</section>

    </body>
</html>
