<?php
// Informations de connexion à la base de données
$servername = "localhost";  // Serveur MySQL
$username = "root";         // Nom d'utilisateurgit push -u origin main
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
    $pseudo = $_POST["pseudo"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm-password"];

    // Vérifier si les mots de passe correspondent
    if ($password === $confirm_password) {
        // Hachage du mot de passe avant l'insertion dans la base de données
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Préparation de la requête SQL pour insérer les données dans la table utilisateurs
        $stmt = $conn->prepare("INSERT INTO utilisateurs (pseudo, email, mot_de_passe, date_inscription) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $pseudo, $email, $hashed_password);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Inscription réussie !";
        } else {
            echo "Erreur lors de l'inscription : " . $stmt->error;
        }

        // Fermer la déclaration
        $stmt->close();
    } else {
        echo "Les mots de passe ne correspondent pas.";
    }
}

// Fermer la connexion
$conn->close();
?>
