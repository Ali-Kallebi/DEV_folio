<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validation et sanitization
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Vérification des champs
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Tous les champs sont obligatoires."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "L'adresse e-mail n'est pas valide."]);
        exit;
    }

    // Configuration des emails
    $to = "alikallebi.dev@gmail.com";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $email_content = "Nom: $name\n"
        . "Email: $email\n"
        . "Sujet: $subject\n\n"
        . "Message:\n$message";

    // Envoi de l'email
    if (mail($to, $subject, $email_content, $headers)) {
        echo json_encode(["status" => "success", "message" => "Email envoyé avec succès."]);
    } else {
        echo json_encode(["status" => "error", "message" => "L'envoi de l'email a échoué."]);
    }
}
?>
