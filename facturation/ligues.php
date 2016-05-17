<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Ajouter une ligue</title>
    </head>
  
    <body>
    <?php require 'header.php'; /*ON INCLUT LE MENU EN HAUT DE LA PAGE*/?>
  	<section>
  		<?php 
      if (isset($_POST['valider'])) {
          
          if (!empty($_POST['intitule']) && !empty($_POST['nomtresorier'])) {

            /*ON CALCULE AUTOMATIQUEMENT LE NUMERO DE LA LIGUE*/
            $req = $bdd->query('SELECT COUNT(*) AS nbligues FROM ligue');
              $donnees = $req->fetch();
              $nbligues = $donnees['nbligues'];
              $nbligues = $nbligues + '411007';

            /*ON SECURISE LES VARIABLES*/
              $intitule = htmlentities($_POST['intitule']);
              $nomtresorier = htmlentities($_POST['nomtresorier']);
              
              $adrue = htmlentities($_POST['adrue']);
              $cp = htmlentities($_POST['cp']);
              $ville = htmlentities($_POST['ville']);
              
              /*ON AJOUTE LA NOUVELLE LIGUE DANS LA TABLE*/
                $sql = $bdd->prepare("INSERT INTO ligue(numcompte, intitule, nomtresorier, adrue, cp, ville )VALUES (:num, :intitule, :nt, :adrue, :cp, :ville)");
                $sql->execute(array(
                  'num' => $nbligues,
                  'intitule' => $intitule,
                  'nt' => $nomtresorier,
                  'adrue' => $adrue,
                  'cp' => $cp,
                  'ville' => $ville,
                ));

            
      }}
      ?>
  		<article>
       <form action="ligues.php" method="POST"><fieldset>
        <h3>Ajouter une Ligue</h3><hr />
                <?php
        if (isset($_POST['valider'])) 
        {
          if (empty($_POST['intitule']) OR empty($_POST['nomtresorier']) OR empty($_POST['adrue']) OR empty($_POST['cp']) OR empty($_POST['ville']))
          {
            echo " <strong>Erreur de saisie</strong><br/><br/>";
          }
        }

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
      <?php include("afficherligue.php"); /*ON INCLUT LE FICHIER PHP QUI PERMET D'AFFICHER LES LIGUES*/ ?>
  		</article>

  	</section>

    </body>
</html>
