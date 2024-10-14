<?php
// Informations de connexion à la base de données
$servername = "localhost";  // Serveur MySQL
$username = "root";         // Nom d'utilisateur MySQL
$password = "";             // Mot de passe MySQL
$dbname = "bisounours";     // Nom de la base de données

// Connexion à la base de données MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Préparation de la requête SQL pour vérifier si l'utilisateur existe
    $stmt = $conn->prepare("SELECT mot_de_passe FROM utilisateurs WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Exécution de la requête
    $stmt->execute();
    $stmt->bind_result($hashed_password_from_db);

    if ($stmt->fetch()) {
        // Vérification du mot de passe avec password_verify
        if (password_verify($password, $hashed_password_from_db)) {
            echo "Connexion réussie !";
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }

    // Fermer la déclaration
    $stmt->close();
}

// Fermer la connexion
$conn->close();
?>
