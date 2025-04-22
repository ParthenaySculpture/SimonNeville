<?php
// Configuration
$recipient_email = "clement.madignier@gmail.com"; // Remplacez par votre adresse email
$email_subject = "Nouveau message depuis le site web";

// Nettoyage et validation des données soumises
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Récupération et nettoyage des données du formulaire
$name = clean_input($_POST['name']);
$email = clean_input($_POST['email']);
$subject = clean_input($_POST['subject']);
$message = clean_input($_POST['message']);

// Validation de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact.html?status=error");
    exit;
}

// Construction du corps de l'email
$email_body = "Vous avez reçu un nouveau message depuis le formulaire de contact de votre site web.\n\n";
$email_body .= "Détails:\n";
$email_body .= "Nom: " . $name . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Sujet: " . $subject . "\n";
$email_body .= "Message:\n" . $message . "\n";

// En-têtes de l'email
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Envoi de l'email
if (mail($recipient_email, $email_subject, $email_body, $headers)) {
    // Succès: redirection vers la page de contact avec message de succès
    header("Location: contact.html?status=success");
} else {
    // Échec: redirection vers la page de contact avec message d'erreur
    header("Location: contact.html?status=error");
}
?>
