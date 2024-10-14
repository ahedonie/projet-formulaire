<<<<<<< HEAD
<?php
// Informations de connexion à la base de données
$serveur = "localhost";      // Serveur MySQL
$utilisateur = "root";       // Nom d'utilisateur MySQL
$mdpBDD = "";         // Mot de passe MySQL (ici, il est vide)
$nomBDD = "bisounours";      // Nom de la base de données

try {
    // connexion a la bdd bisounours via un pdo et non mysqli 
    $connexion = new PDO("mysql:host=$serveur;dbname=$nomBDD;charset=utf8", $utilisateur, $mdpBDD);
    // on config le pdo en cas d'erreur
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // si probleme de connexion alors le message d'erreur suivant s'affiche
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // on lit les requetes du formulaire pour les recuperer
    $emailUtilisateur = $_POST["email"];      // ici l'email de l'uilisateur
    $motDePasse = $_POST["password"];         // ici son mot de passe

    //  ici on "prepare" une requete qui sera celle entre parenthese pour verifier l'email et le mdp
    $requeteSQL = $connexion->prepare("SELECT mot_de_passe FROM utilisateurs WHERE email = :email");
    
    // une fois la variable :email créer, on lui le lie a la requete
    $requeteSQL->bindParam(':email', $emailUtilisateur);

    // execution de la requête
    $requeteSQL->execute();

    // recuperation du mot de passe haché de la base de données ( generer par chatgpt )
    $utilisateur = $requeteSQL->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        // ici on verifie que le mot de passe haché corresponds au mot de passe haché de la bdd "bisounours"
        if (password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
            echo "Connexion réussie !";
        } else {
            echo "Mot de passe incorrect.";
        }
    } else {
        echo "Aucun utilisateur trouvé avec cet email.";
    }
}
    // source : 
            //www.php.net/manual/fr/pdostatement.bindparam.php
            //www.php.net/manual/fr/pdo.prepare.php
            //www.pierre-giraud.com/php-mysql-apprendre-coder-cours/requete-preparee/
            //www.php.net/manual/fr/book.pdo.php
            //openclassrooms.com/forum/sujet/php-formulaire-dinscription
            //ancien code 

?>
=======
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
>>>>>>> 83c2cdc0d4bd54e8cb43e8a588e8fc0f607e5135
