<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Modifier une Prestation</title>
    </head>

    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php
      $erreur = "";
      if (isset($_POST['valider'])) {
        /*ON RECUPERE LES INFOS DE LA PRESTATION CONCERNEE*/
        if (isset($_POST['libelle']) && !empty($_POST['libelle']) && isset($_POST['prix_unitaire']) &&!empty($_POST['prix_unitaire'])) {

            $choixligue = htmlentities($_POST['listpres']);
            $reukette = $bdd->prepare('SELECT codepres FROM prestation WHERE libelle = :iin');
            $reukette->execute(array('iin' => $choixligue,));
            $num = $reukette->fetch();
            $num = $num['codepres'];

            /*ON SECURISE LES VARIABLES*/
            $libelle = htmlentities($_POST['libelle']);
            $prix_unitaire = htmlentities($_POST['prix_unitaire']);
            $prix_unitaire = str_replace(',', '.', $prix_unitaire);

            /*ON MET A JOUR LA PRESTATION*/
            $sql = $bdd->prepare("UPDATE prestation SET libelle = :libelle, prix_unitaire = :prix_unitaire WHERE codepres = :num ");
            $sql->execute(array(
                'num' => $num,
                'libelle' => $libelle,
                'prix_unitaire' => $prix_unitaire,
              ))or die(print_r($sql->errorInfo()));
            $erreur = '<strong>Prestation modifiée !</strong>';
        }else $erreur = '<strong>Veuillez remplir tous les champs !</strong><br/><br/>' ;
        $reukette->closeCursor();
        $sql->closeCursor();
      }
      ?>
  		<article>
       <form action="modif_prestation.php" method="POST"><fieldset>
        <h3>Modifier une prestation</h3><hr />
        <?php echo $erreur;?><br>
        <label>Choix de la Ligue concerné : </label>
        <?php
          include("listederoulanteP.php");
        ?>
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
        /*ON AFFICHE LES PRESTATIONS DISPONIBLES*/
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
