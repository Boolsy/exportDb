<?php
  require_once "toolbox.php";

 //PHP_SAPI constante php utilisé pour check le type d'interface qui exécute le script
  if (PHP_SAPI === 'cli') {
    $args = $_SERVER['argv'];
  } else {
    echo "Script uniquement utilisable en ligne de commande";
    die;
  }

  //check si il y a bien 3 arguments dans la commande si pas, retourne les messages d'aide
  if (count($args) < 3 || in_array("-?", $args) || in_array("help", $args)) {
    showMessage();
    die;
  }


                        // args [0] = execute_sql.php
  $sqlFile = $args[1];  //cible le fichier sql
  $database = $args[2]; //2eme argument qui rename la db

  // verif si le fichier SQL existe
  if (!file_exists($sqlFile)) {
    echo "Erreur : Le fichier SQL spécifié n'existe pas.\n";
    die;
  }

  // vérif l'extension de la db
  $databaseExtension = pathinfo($sqlFile, PATHINFO_EXTENSION);
  if ($databaseExtension !== "sql") {
    echo "Erreur : L'extension de la db doit être en '.sql'.\n";
    die;
  }

// paramètre de co a la db
  $host = "localhost";
  $username = "root";
  $password = "";

  try {
    $dsn = "mysql:host=$host";
    $pdo = new PDO($dsn, $username, $password);

    // check si la db existe déja
    $databaseExistsQuery = "SELECT 1 FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :database LIMIT 1";
    $stmt = $pdo->prepare($databaseExistsQuery);
    $stmt->execute([':database' => $database]);


    if ($stmt->rowCount() > 0) {
      echo "La base de données '$database' existe déjà. Le script n'a pas été exécuté.\n";
      die;
    }

    // crée la db
    $createDatabaseQuery = "CREATE DATABASE $database";
    $pdo->exec($createDatabaseQuery);

    // utilise la db
    $dsn = "mysql:host=$host;dbname=$database";
    $pdo = new PDO($dsn, $username, $password);

    // lis le contenu du fichier SQL
    $sqlContent = file_get_contents($sqlFile);

    // exécute
    $pdo->exec($sqlContent);

    echo "Script SQL exécuté avec succès dans la base de données '$database'.\n";
  } catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage() . "\n";
    die;
  } finally {
  // fermeture de la connexion
  $pdo = null;
}
