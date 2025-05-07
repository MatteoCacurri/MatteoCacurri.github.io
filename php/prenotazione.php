<?php
    if (isset($_POST["tav_num"])) {
        $db_conn = pg_connect("host=localhost port=5432 dbname=geppo_pub user=postgres password=password1")
                    or die('Could not connect: ' . pg_last_error());

        // Conversione della data da "10/06" a "2025-06-10"
        $data_raw = $_POST["data"];
        $anno_corrente = date("Y");
        $data_obj = DateTime::createFromFormat('d/m', $data_raw);
        $data_obj->setDate($anno_corrente, $data_obj->format('m'), $data_obj->format('d'));
        $data = $data_obj->format('Y-m-d');

        $ora = $_POST["ora"];
        $tav_num = $_POST["tav_num"];

        echo "Data: $data, Ora: $ora, Tavolo: $tav_num<br/>";

        // Inserimento nella tabella tavolo e recupero id generato
        $query1 = "INSERT INTO tavolo(id_t, data, ora, tavolo) VALUES (default, '$data', '$ora', '$tav_num') RETURNING id_t";
        $result = pg_query($db_conn, $query1)
                or die("Errore nell'esecuzione della query tavolo: " . pg_last_error() . "<br/>");

        $row = pg_fetch_assoc($result);
        $id_tavolo = $row['id_t'];

        if (!$id_tavolo) {
            die("Errore: ID tavolo non recuperato correttamente.<br/>");
        }

        echo "ID tavolo inserito: $id_tavolo<br/>";

        // Inserimento nella tabella prenotazione con riferimento al tavolo
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];

        echo "Dati prenotazione - Nome: $nome, Cognome: $cognome, Tel: $telefono, Email: $email<br/>";

        $query2 = "INSERT INTO prenotazione(id_p, nome, cognome, telefono, email, id_tavolo) VALUES (default, '$nome', '$cognome', '$telefono', '$email', $id_tavolo)";
        $result2 = pg_query($db_conn, $query2);

        if (!$result2) {
            die("Errore nella INSERT prenotazione: " . pg_last_error($db_conn) . "<br/>");
        }

        echo "Prenotazione inserita con successo.<br/>";
    }
    else if (isset($_POST["del"])) {
        $db_conn = pg_connect("host=localhost port=5432 dbname=geppo_pub user=postgres password=password1")
                    or die('Could not connect: ' . pg_last_error());

        $id = $_POST["del"];
        $query = "DELETE FROM prenotazione WHERE id_p=$id";
        $result = pg_query($db_conn, $query)
                or die("Errore nell'esecuzione della query DELETE: " . pg_last_error() . "<br/>");

        echo "Prenotazione con ID $id cancellata con successo.<br/>";
    }
?>