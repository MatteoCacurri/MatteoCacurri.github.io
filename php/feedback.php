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

    // Simulazione: email "inviata"
    echo "success";
} else {
    echo "dati incompleti";
}
?>
