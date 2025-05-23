$(document).ready(function () {
    $("#feedback-form").validate({
        rules: {
            nome: {
                required: true,
                minlength: 2,
                maxlength: 50
            },
            email: {
                required: true,
                email: true
            },
            messaggio: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            nome: {
                required: "Inserisci il tuo nome",
                minlength: "Il nome deve contenere almeno 2 caratteri",
                maxlength: "Il nome non può superare i 50 caratteri"
            },
            email: {
                required: "Inserisci la tua email",
                email: "Inserisci un indirizzo email valido"
            },
            messaggio: {
                required: "Inserisci un messaggio",
                minlength: "Il messaggio deve contenere almeno 5 caratteri"
            }
        },
        submitHandler: function (form) {
            $.ajax({
                type: "POST",
                url: "php/feedback.php",
                data: $(form).serialize(),
                success: function (response) {
                    if (response.trim() === "success") {
                        $("#feedback-message")
                            .removeClass()
                            .addClass("alert alert-success text-center animate__animated animate__fadeInDown")
                            .text("Email inviata con successo!")
                            .fadeIn();
                        form.reset();
                    } else {
                        $("#feedback-message")
                            .removeClass()
                            .addClass("alert alert-danger text-center animate__animated animate__fadeInDown")
                            .text("Errore nell'invio dell'email.")
                            .fadeIn();
                    }
                },
                error: function () {
                    $("#feedback-message")
                        .removeClass()
                        .addClass("alert alert-danger text-center animate__animated animate__fadeInDown")
                        .text("Errore nella richiesta al server.")
                        .fadeIn();
                }
            });
        }
    });
});
