<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Modifier une Ligue</title>
    </head>
  
    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php 
      $erreur = "";
      if (isset($_POST['valider'])) {

              /*ON RECUPERE LES INFOS DE LA LIGUE CONCERNEE*/
              if (!empty($_POST['listligue']) && !empty($_POST['intitule']) && !empty($_POST['nomtresorier']) && !empty($_POST['adrue']) && !empty($_POST['cp']) && !empty($_POST['ville'])) {
                $choixligue = htmlentities($_POST['listligue']);
                $req = $bdd->prepare('SELECT numcompte FROM ligue WHERE intitule = :iin');
                $req->execute(array('iin' => $choixligue,));
                $num = $req->fetch();
                $num = $num['numcompte'];

                /*ON SECURISE LES VARIABLES*/
                $intitule = htmlentities($_POST['intitule']);
                $nomtresorier = htmlentities($_POST['nomtresorier']);
                $adrue = htmlentities($_POST['adrue']);
                $cp = htmlentities($_POST['cp']);
                $ville = htmlentities($_POST['ville']);

                /*ON MET A JOUR LA LIGUE*/
                  $sql = $bdd->prepare("UPDATE ligue SET intitule = :intitule, nomtresorier = :nt, adrue = :adrue, cp = :cp, ville = :ville WHERE numcompte = :num");
                  $sql->execute(array(
                    'num' => $num,
                    'intitule' => $intitule,
                    'nt' => $nomtresorier,
                    'adrue' => $adrue,
                    'cp' => $cp,
                    'ville' => $ville,
                  ));
                  $erreur = '<strong>Ligue enregistré dans la base de données</strong><br/><br/>';
              }else $erreur = '<strong>Erreur de saisie</strong><br/><br/>';
            }
      
      ?>
  		<article>
       <form action="modif_ligue.php" method="POST"><fieldset>
        <h3>Modifier une Ligue</h3><hr />
        <?php echo $erreur;?>
        
        <label>Choix de la Ligue concerné : </label>
        <?php
          include("listederoulanteL.php");
        ?>
        <label>Intitulé : </label><input type="text" name="intitule" maxlength="30" placeholder="Nom de la Ligue..." /><br/><br/>
        <label>Nom du Trésorier : </label><input type="text" name="nomtresorier" maxlength="20" placeholder="Nom du trésorier..." /><br/><br/>
       
        <label>Adresse : </label><input type="text" name="adrue" maxlength="50" placeholder="Ex: 5 rue de la Done-ma" /><br/><br/>
        <label>Code postal : </label><input type="text" name="cp" maxlength="5" placeholder="75018" /><br/><br/>
        <label>Ville : </label><input type="text" name="ville" maxlength="20" placeholder="Paris" /><br/><br/>
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="valider" value="Valider" />
        </fieldset>
       </form>
      <hr/>
     <?php include("afficherligue.php"); ?>
  		</article>

  	</section>

    </body>
</html>
