<?php
    //se nella variabile $_POST è settato il campo "tav_num", allora è stata richiesta una prenotazione 
    //arrivata da ajax, che viene effettuata tramite due INSERT nel database, una per la tabella prenotazione
    //per i dati del prenotante, e una nella tabella tavolo per sapere data, ora e tavolo prenotato.
    if(isset($_POST["tav_num"])){
        $db_conn = pg_connect("host=localhost port=5432 dbname=geppo_pub user=postgres password=password1")
                    or die('Could non connect: '.pg_last_error());
        $data = $_POST["data"];
        $ora = $_POST["ora"];
        $tav_num = $_POST["tav_num"];
        $query1 = "INSERT into tavolo(id_t,data,ora,tavolo) values(default,'$data','$ora','$tav_num')";
        $result = pg_query($db_conn, $query1)
                or die("Errore nell'esecuzione della query ". pg_last_error(). "<br/>");
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $telefono = $_POST["telefono"];
        $email = $_POST["email"];
        $query2 = "INSERT into prenotazione(id_p,nome,cognome,telefono,email,id) values(default,'$nome','$cognome','$telefono','$email',default)";
        $result = pg_query($db_conn, $query2)
                or die("Errore nell'esecuzione della query ". pg_last_error(). "<br/>");
    }
    //se nella variabile $_POST è settato il campo "del", allora è stata richiesta tramite ajax la cancellazione
    //di una prenotazione, che viene effettuata tramite una DELETE.
    else if(isset($_POST["del"])){
        $db_conn = pg_connect("host=localhost port=5432 dbname=CocktailBar user=postgres password=postpass!")
                    or die('Could non connect: '.pg_last_error());
        $nome = $_POST["nome"];
        $cognome = $_POST["cognome"];
        $telefono = $_POST["telefono"];
        $data = $_POST["data"];
        $ora = $_POST["ora"];
        $tavolo = $_POST["tavolo"];
        $id = $_POST["id"];
        $query3 = "DELETE from prenotazione where id='$id'; DELETE from tavolo where id_t='$id';";
        $result = pg_query($db_conn, $query3)
                or die("Errore nell'esecuzione della query ". pg_last_error(). "<br/>");

    }
    //se nessuno dei precedenti if ritorna true, allora è stata richiesta tramite ajax la lista dei tavolo occupati
    //per una certa data e ora
    else{
        $db_conn = pg_connect("host=localhost port=5432 dbname=geppo_pub user=postgres password=password1")
                    or die('Could non connect: '.pg_last_error());
        $data = $_POST["data"];
        $ora = $_POST["ora"];
        $query = "SELECT tavolo FROM tavolo WHERE data='$data' and ora='$ora'";
        $result = pg_query($db_conn, $query)
                    or die("Errore nell'esecuzione della query ". pg_last_error(). "<br/>");
        $dati = array();
        while ($row = pg_fetch_row($result)){
            array_push($dati,$row[0]);
        }
        echo implode(" ",$dati);     
    }
?>

