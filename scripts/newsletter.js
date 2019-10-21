document.addEventListener('DOMContentLoaded', function(event) {
    let subscription_form = document.getElementById('subscription_form');

    subscription_form.addEventListener(
        "submit", (event) => {
            event.preventDefault();

            let email_signup = document.getElementById("email_signup");

            const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            if (regex.test(email_signup.value)) {
                let formData = new FormData();
                formData.append("email_signup", email_signup.value);

                let options = {
                    method: "POST",
                    mode: "cors",
                    body: formData
                };

                let req = new Request(
                    ajaxurl + "?action=wptest_subscription",
                    options
                );

                fetch(req)
                    .then(response => {
                        if (response.ok) {
                            email_signup.value = '';
                            $("#subscription_alert")
                                .text("Welcome to our list!")
                                .show()
                                .fadeOut(3000);
                        } else {
                            $("#subscription_alert")
                                .text("An error occurred.")
                                .show()
                                .fadeOut(3000);
                        }
                    })
                    .catch(err => {
                        console.log("ERROR:", err.message);
                    });
            } else {
                $("#subscription_alert")
                    .text("This is not a valid email.")
                    .show()
                    .fadeOut(3000);
            }
        }
    );
})