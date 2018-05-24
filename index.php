<?php
session_start();// Quand on revient sur la page d'accueuil on reset les sessions
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>

  <head>
    <title>Morpion</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="morpion.css" />
    <script type="text/javascript" src="index.js"></script>
  </head>

<body>

<h1><span>Morpion</span></h1>
<h2>Principe de Jeu:</h2>
<p>C'est un jeu qui se joue généralement sur un damier de 3 cases par 3 cases</p>
<h3>Déroulement du jeu</h3>
<p>Un premier joueur dessine son symbole sur une case(X ou O). </p>
<p>	C'est ensuite au tour de l'autre joueur de dessiner son symbole sur une case vide.</p>
<p>Le but du jeu est de réussir à aligner ses trois symboles, on remporte alors la partie. </p>

Pour corser le jeu, on peut aussi jouer sur des grilles plus grandes : 4x4 cases, il faudra donc aligner 4 symboles. 5x5, aligner 5 symboles.</p>
<img src="images/morpion.gif"/>
<form action="morpion.php" method="get">
  Entrez la taille <?php $taille ?>=<input type="text" id="taille" name="taille">
<input type="submit" onclick="return checkEntry();" value="A vous de jouer"><!-- On vérifie ce que le joueur rentre en paramètre-->
</form>


</body>
</html>