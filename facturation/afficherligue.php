<div id ="listligue">
  <h3>Liste des Ligues Lorraine</h3>
  <?php 
    $listligue = $bdd->query("SELECT * FROM ligue");
    while ($donnees = $listligue->fetch()) 
    {
      ?>
      <h3 style=" font-color: white;"><?php echo $donnees['intitule'];?></h3>
      <p>
        Finance et facture géré par <?php echo $donnees['nomtresorier'];?><br/>
        <?php echo $donnees['adrue'];?><br/>
        <?php echo $donnees['cp'];?>&nbsp;
        <?php echo $donnees['ville'];?>
      </p>
      <?php 
    } $listligue->closeCursor(); 
  ?>
</div>