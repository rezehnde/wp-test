$(document).ready(function($) {
    $("#contact_form").submit(function(event) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        var cf_fname = $("#cf_fname").val();
        var cf_lname = $("#cf_lname").val();
        var cf_email = $("#cf_email").val();
        var cf_subject = $("#cf_subject").val();
        var cf_message = $("#cf_message").val();
        var cf_email_to = $("#cf_email_to").val();

        $("#cf_fname").css("border-color", "#ced4da");
        $("#cf_lname").css("border-color", "#ced4da");
        $("#cf_email").css("border-color", "#ced4da");
        $("#cf_subject").css("border-color", "#ced4da");
        $("#cf_message").css("border-color", "#ced4da");
        $("#cf_alert").hide();

        var cf_error = false;
        if (cf_fname == "") {
            cf_error = true;
            $("#cf_fname").css("border-color", "red");
        }
        if (cf_lname == "") {
            cf_error = true;
            $("#cf_lname").css("border-color", "red");
        }
        if (!regex.test(cf_email)) {
            cf_error = true;
            $("#cf_email").css("border-color", "red");
        }
        if (cf_subject == "") {
            cf_error = true;
            $("#cf_subject").css("border-color", "red");
        }
        if (cf_message == "") {
            cf_error = true;
            $("#cf_message").css("border-color", "red");
        }

        if (!cf_error) {
            $.ajax({
                url: ajaxurl + "?action=wptest_contact_form",
                type: "POST",
                data: {
                    cf_fname: cf_fname,
                    cf_lname: cf_lname,
                    cf_email: cf_email,
                    cf_subject: cf_subject,
                    cf_message: cf_message,
                    cf_email_to: cf_email_to
                },
                success: function(data) {
                    $("#cf_fname").val("");
                    $("#cf_lname").val("");
                    $("#cf_email").val("");
                    $("#cf_subject").val("");
                    $("#cf_message").val("");
                    $("#cf_alert")
                        .text("Your message was successful sent")
                        .show()
                        .fadeOut(5000);
                }
            });
        } else {
            $("#cf_alert")
                .text("Some fields are invalid or empty")
                .show()
                .fadeOut(5000);
        }
        event.preventDefault();
    });
});
