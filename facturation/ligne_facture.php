<?php require ("config.php");?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
    <link rel="stylesheet" href="style.css" />
    
        <title>Ajouter des prestations à facturer</title>
    </head>
  
    <body>
    <?php require 'header.php'; ?>
  	<section>
  		<?php 
      /*ON RECUPERE LE NUMERO DE LA FACTURE A MODIFIE*/
       if (isset($_GET['numero']) && is_numeric($_GET['numero']))  {/*VERIFIE SI UNE VARIBLE EST DE TYPE NUMERIQUE*/

          $num = intval($_GET['numero']); /*INTVAL RETOURNE LA VALEUR NUMERIQUE D'UNE VARIABLE*/
      ?>
      <?php
        $erreur = "";
        if (isset($_POST['ajouter'])) 
        {
          /*ON AJOUTE UNE PRESTATION A LA FACTURE*/
          if (isset($_POST['listprestation']) && !empty($_POST['listprestation']) && isset($_POST['quantite']) && !empty($_POST['quantite']) && is_numeric($_POST['quantite'])){
            
            $listprestation = explode(':', $_POST['listprestation']);
            $verif = $bdd->prepare('SELECT codepres FROM prestation WHERE libelle = :lib');
            $verif->execute(array( 'lib'=>$listprestation[0], ));
            $results = $verif->fetch();
            $sql = $bdd->prepare("INSERT INTO ligne_facture(numfacture, code_prestation, quantite) VALUES(:num, :code, :qte) ");
            $sql->execute(array(
              'num' => $num,
              'code'=>$results['codepres'],
              'qte'=>$_POST['quantite'],
              ));
            $erreur = '<strong>Prestation facturé !</strong><br/>';
            $sql->closeCursor();
          }else $erreur = '<strong>Veuillez remplir les champs</strong>';
        }
        
      ?>
  		<article>
       <form action="#" method="POST"><fieldset>
        <h3>Ajouter des prestations à facturer</h3><hr />
        <?php echo $erreur;?><br/>
        <label>Prestations : </label>
        <?php
          include("listederoulanteP.php");
        ?>
        <label>Quantité : </label><input type="number" name="quantite" min="1" max="999" /><br/><br/>
       
        <input type="reset" value="Effacer" />&nbsp;&nbsp;<input type="submit" name="ajouter" value="Ajouter" />
        </fieldset>
       </form>
       
      <div id ="listligue">
        </div>
  		</article>
      <?php }else header('Location:panelfacture.php'); /*REDIRECTION DE PAGE*/?>
  	</section>

    </body>
</html>
