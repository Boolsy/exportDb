<?php
  //message d'aide
  function showMessage() {
    echo "Utilisation : php execute_sql.php <fichier_sql> <nom_de_la_base_de_donnees>\n";
    echo "\n";
    echo "Arguments :\n";
    echo "<fichier_sql> : Le nom du fichier SQL contenant les instructions à exécuter.\n";
    echo "<nom_de_la_base_de_donnees> : Le nom que vous souhaitez donner à la base de données.\n";
    echo "\n";
    echo "Description :\n";
    echo "Ce script permet de créer une nouvelle base de données et d'exécuter les instructions SQL à partir d'un fichier SQL spécifié.\n";
    echo "\n";
    echo "Exemple d'utilisation :\n";
    echo "Pour créer une nouvelle base de données nommée 'ma_base_de_donnees' à partir du fichier 'fichier_sql.sql', exécutez la commande suivante :\n";
    echo "  php execute_sql.php fichier_sql.sql ma_base_de_donnees\n";
  }

  // todo scinder la partie de requete sql et faire plusieurs fonctions "la co, le check doublons, et l'execute"



