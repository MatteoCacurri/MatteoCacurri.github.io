<?php
if (
    isset($_POST["nome"]) &&
    isset($_POST["email"]) &&
    isset($_POST["messaggio"])
) {
    $nome = htmlspecialchars($_POST["nome"]);
    $email = htmlspecialchars($_POST["email"]);
    $telefono = isset($_POST["telefono"]) ? htmlspecialchars($_POST["telefono"]) : '';
    $messaggio = htmlspecialchars($_POST["messaggio"]);

    $to = "test@localhost"; // Modifica con l'indirizzo email desiderato
    $subject = "Nuovo messaggio dal form di contatto";
    $body = "Hai ricevuto un nuovo messaggio:\n\n"
          . "Nome: $nome\n"
          . "Email: $email\n"
          . "Telefono: $telefono\n"
          . "Messaggio:\n$messaggio";

    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "dati incompleti";
}
?>