<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération et nettoyage des données
    $name    = htmlspecialchars(trim($_POST["name"] ?? ''));
    $email   = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST["subject"] ?? ''));
    $message = htmlspecialchars(trim($_POST["message"] ?? ''));

    // Vérification des champs requis
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        header("Location: contact.html?status=error");
        exit;
    }

    // Destinataire (à adapter avec ton adresse mail)
    $to = "clement.madignier@gmail.com";

    // Construction du contenu de l'email
    $email_content = "Nom: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Sujet: $subject\n\n";
    $email_content .= "Message:\n$message\n";

    // En-têtes
    $headers = "From: $name <$email>";

    // Envoi de l'email
    $success = mail($to, $subject, $email_content, $headers);

    if ($success) {
        header("Location: contact.html?status=success");
    } else {
        header("Location: contact.html?status=error");
    }
    exit;
} else {
    // Méthode non autorisée
    http_response_code(405);
    echo "Méthode non autorisée.";
}
?>

?>
