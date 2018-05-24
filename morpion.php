<?php
session_start();
  if ( isset( $_GET[ "taille" ]) ){// si la taille est indiqué un tableau de cette taille
     $_SESSION['taille']=$_GET[ "taille" ];
     $taille=$_SESSION['taille'];
     for($i=0;$i<$taille;$i++){
      for($j=0;$j<$taille;$j++){
        $_SESSION["_$i$j"]="white.png";//on donne les couleurs des cases à partir des sessions
      }
    }
  }
  $taille=$_SESSION['taille'];//On récupère la taille de la session



 
  if ( isset($_GET["ligne"]) ) {// Si la ligne(et donc la colonne ) été informé 
    $a=$_GET["ligne"];// on récupère la ligne choisi
    $b=$_GET["colonne"];//on récupère la colonne choisi
    $_SESSION["_$a$b"]="X.png";// On remplace notre session de notre case par la croix
    $joueur=array();// on stocke les endroits choisi par le joueur
    $joueur[]="$a$b";
    echo "Le joueur a joué en ({$_GET["ligne"]},{$_GET["colonne"]})<br>";
    if(!verifJeu($taille)) {//On regarde si on peut jouer
      action($taille);// oui on fait jouer le bot
      if(verifJeu($taille)) {
        header("Location: index.php");// si le jeu est fini retourne sur l'index
        exit();
      }
    }
    else {
      header("Location: index.php");
      exit();
    }
  }else{

  }
?>
<?php

function verifJeu($taille) {// Compte le nombre de X et de O ...
  $xLineCount = array_fill(0, $taille, 0); // pour les lignes
  $xColumnCount = array_fill(0, $taille, 0);// pour les colonnes
  $xDiagonalCount = 0;// pour les diagonales
  $xAntiDiagonalCount = 0;// poour les antidiagonales
// de même pour le bot
  $oLineCount = array_fill(0, $taille, 0);
  $oColumnCount = array_fill(0, $taille, 0);
  $oDiagonalCount = 0;
  $oAntiDiagonalCount = 0;

  $complete = true;

  for($i=0;$i<$taille;$i++) {
    for($j=0;$j<$taille;$j++) {
      if($i==$j && $_SESSION["_$i$j"]=="X.png") {// les diagonales sont les indices ou i=j
        $xDiagonalCount++;
      }
      if($j==($taille-$i-1) && $_SESSION["_$i$j"]=="X.png") { //les antidiagonales sont les indices ou j=taille-i-1
        $xAntiDiagonalCount++;
      }
      if($_SESSION["_$i$j"]=="X.png") {// pour toutes les cases les compteurs lignes et colonnes augmentent
        $xLineCount[$i]++;
        $xColumnCount[$j]++;
      }
      // de même
      if($i==$j && $_SESSION["_$i$j"]=="O.png") {
        $oDiagonalCount++;
      }
      if($j==($taille-$i-1) && $_SESSION["_$i$j"]=="O.png") {
        $oAntiDiagonalCount++;
      }
      if($_SESSION["_$i$j"]=="O.png") {
        $oLineCount[$i]++;
        $oColumnCount[$j]++;
      }
      if($_SESSION["_$i$j"]=="white.png") {// si une case est blanche alors la partie n'est pas fini
        $complete = false;
      }
    }
  }
  //On arrête le jeu quand il n'y a plus de case blanche($complete=true) ou quand une longueur du morpion(ligne,colonne,diagonale,antidiagonale) est rempli pour un des joueurs
  if($complete || in_array($taille, $xLineCount) || in_array($taille, $oLineCount) || in_array($taille, $xColumnCount) || in_array($taille, $oColumnCount) || $xDiagonalCount==$taille || $oDiagonalCount==$taille || $xAntiDiagonalCount==$taille || $oAntiDiagonalCount==$taille) {
    return true;
  }
  return false;
}

function taille($n){// on crée le tableau à partir des cases des sessions
  
$r="<div id='grid'>\n";
$r.="<table cellspacing='1' border='2' cellpadding='0'>\n";
  $r.="<tbody>\n";
  for($i=0;$i<$n;$i++){
  $r.="<tr>\n";
  for($j=0;$j<$n;$j++){
        $f=$_SESSION["_$i$j"];
        $r.="<td><img align='center' src='images/$f' onclick='click_at($i,$j,this)'/></td>\n";
  }

  $r.="</tr>\n";
}
$r .= "</tbody>\n";
$r .= "</table>\n";
$r .= "</div>\n";
return $r;
 }

 function action($taille){// fait jouer le bot
// On regarde combien de fois a jouer le joueur sur chaque longueur
$lineCount = array_fill(0, $taille, 0);
$columnCount = array_fill(0, $taille, 0);
$diagonalCount = 0;
$antiDiagonalCount = 0;

$totalLineCount = array_fill(0, $taille, 0);
$totalColumnCount = array_fill(0, $taille, 0);
$totalDiagonalCount = 0;
$totalAntiDiagonalCount = 0;

for($i=0;$i<$taille;$i++) {
  for($j=0;$j<$taille;$j++) {
    if($i==$j && $_SESSION["_$i$j"]=="X.png") {
      $diagonalCount++;
    }
    if($j==($taille-$i-1) && $_SESSION["_$i$j"]=="X.png") {
      $antiDiagonalCount++;
    }
    if($_SESSION["_$i$j"]=="X.png") {
      $lineCount[$i]++;
      $columnCount[$j]++;
    }

    if($i==$j && $_SESSION["_$i$j"]!="white.png") {
      $totalDiagonalCount++;
    }
    if($j==($taille-$i-1) && $_SESSION["_$i$j"]!="white.png") {
      $totalAntiDiagonalCount++;
    }
    if($_SESSION["_$i$j"]!="white.png") {
      $totalLineCount[$i]++;
      $totalColumnCount[$j]++;
    }
  }
}

 $played = false;
// Si il n'a pas joué et que le joueur est à une case de l'emporter le bot le contre
if(!$played && (in_array(($taille-1), $lineCount))) {// analyse horizontale
  for($i=0;$i<$taille;$i++) {
    if(!$played && $lineCount[$i]==($taille-1) && $totalLineCount[$i]<$taille) {
      for($j=0;$j<$taille;$j++) {
        if($_SESSION["_$i$j"]=="white.png"){
          $_SESSION["_$i$j"] = "O.png";
          $played = true;// Le bot ne peut jouer qu'un fois donc quand il a joué on a casse la boucle
          break;
        }
      }
    }
  }
}
if(!$played && (in_array(($taille-1), $columnCount))) {// analyse verticale
  for($i=0;$i<$taille;$i++) {
      for($j=0;$j<$taille;$j++) {
        if(!$played && $columnCount[$j]==($taille-1) && $totalColumnCount[$j]<$taille) {
        if($_SESSION["_$i$j"]=="white.png"){
          $_SESSION["_$i$j"] = "O.png";
          $played = true;
          break;
        }
      }
    }
  }
}

if(!$played && $diagonalCount==($taille-1) ){// analyse diagonale
  for($i=0;$i<$taille;$i++) {
      for($j=0;$j<$taille;$j++) {
        if(!$played && $diagonalCount==($taille-1) && $totalDiagonalCount<$taille) {
          if($j==$i) {
            if(!$played && $_SESSION["_$i$j"]=="white.png"){
              $_SESSION["_$i$j"] = "O.png";
              $played = true;
              break;
            } 
          }
        }
      }
    }
}

if(!$played &&  $antiDiagonalCount==($taille-1)) {// analyse antidiagonale
  for($i=0;$i<$taille;$i++) {
    for($j=0;$j<$taille;$j++) {
      if(!$played && $antiDiagonalCount==($taille-1) && $totalAntiDiagonalCount <$taille) {
        if($j==$taille-$i-1){ 
          if( !$played && $_SESSION["_$i$j"]=="white.png" ){
            $_SESSION["_$i$j"] = "O.png";
            $played = true;
            break;
          }
        }
      }
    }
  }
}
if(!$played) {// si le joueur n'est pas a une case de gagner et que le bot n'a pas encore jouer il joue aléatoirement
  do {
    $i = rand(0,$taille-1);
    $j = rand(0,$taille-1);
  } while($_SESSION["_$i$j"]!="white.png");
  $_SESSION["_$i$j"]="O.png";
  $played = true;
}

}
 ?>

<!DOCTYPE html>
<html>

  <head>
    <title>Morpion</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="morpion.css" />
    <script type="text/javascript" src="morpion.js"></script>
  </head>

<body>

<h1><span>Morpion</span></h1>







<h2>Morpion de taille <?php  echo $taille ."X". $taille ?></h2>
<?php echo taille($taille);  ?>


<form id="page" action="" method="get"> 
  <input id="ligne" type="hidden" name="ligne" value="-9" />
  <input id="colonne" type="hidden" name="colonne" value="-9" />
  <input type="submit" value="jouer" onclick="return verifPlay();" /><!-- On verifie si le joueur a cliqué sur une case->

</form>



</body>
</html>
