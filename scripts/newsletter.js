$(document).ready(function($) {
    $("#subscription_form").submit(function(event) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var email_signup = $("#email_signup").val();
        if (regex.test(email_signup)) {
            $.ajax({
                url: ajaxurl + "?action=wptest_subscription",
                type: "POST",
                data: {
                    email_signup: email_signup
                },
                success: function(data) {
                    $("#email_signup").val("");
                    $("#subscription_alert")
                        .text("Welcome to our list!")
                        .show()
                        .fadeOut(3000);
                }
            });
        } else {
            $("#subscription_alert")
                .text("This is not a valid email.")
                .show()
                .fadeOut(3000);
        }
        event.preventDefault();
    });
});
