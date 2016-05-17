<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Ajouter une prestation</title>
    </head>

    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php
      $erreur = "";
      if (isset($_POST['valider'])) {
        /*CALCUL AUTOMATIQUE DU NUMERO DE LA PRESTATION*/
        if (isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['prix_unitaire']) &&!empty($_POST['prix_unitaire'])) {

            $req = $bdd->query('SELECT COUNT(*) AS prestations FROM prestation');
            $donnees = $req->fetch();
            $prestations = $donnees['prestations'];
            $prestations++;
            $libelle = htmlentities($_POST['libelle']);
            $prix_unitaire = htmlentities($_POST['prix_unitaire']);
            $prix_unitaire = str_replace(',', '.', $prix_unitaire);
            
            /*ON AJOUTE LA PRESTATION*/
            $sql = $bdd->prepare("INSERT INTO prestation(codepres, libelle, prix_unitaire) VALUES (:codepres, :libelle, :prix_unitaire)");
            $sql->execute(array(
                'codepres' => $prestations,
                'libelle' => $libelle,
                'prix_unitaire' => $prix_unitaire,
              ))or die(print_r($sql->errorInfo()));
            $erreur = '<strong>Prestation enregistrée !</strong>';
        }else $erreur = '<strong>Veuillez remplir tous les champs !</strong><br/><br/>' ;
      }
      ?>
  		<article>
       <form action="prestation.php" method="POST"><fieldset>
        <h3>Ajouter une prestation</h3><hr />
        <?php echo $erreur;?><br>
        <label>Libellé de la nouvelle prestation : </label><input type="text" name="libelle" maxlength="20" placeholder="Libellé de la prestation" /><br/><br/>
        <label>Prix unitaire de la prestation : </label><input type="text" name ="prix_unitaire" placeholder="1.50" maxlength="5" /><br/><br/>
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="valider" value="Valider" />
        </fieldset>
       </form>
       <hr/>
       <div id ="listprestation">
        <h3>Prestations disponibles : </h3>
        <table border="3" align="center">
        <?php 
          $listpres = $bdd->query("SELECT * FROM prestation");
          while ($donnees = $listpres->fetch()) 
          {
        ?>
        <tr>
          <td><strong><?php echo $donnees['codepres']; ?></strong></td>
          <td><?php echo $donnees['libelle']; ?></td>
          <td><?php echo $donnees['prix_unitaire']; ?> € </td>
        </tr>
        <?php } $listpres->closeCursor(); ?>
        </table>
      </div>
  		</article>

  	</section>

    </body>
</html>
