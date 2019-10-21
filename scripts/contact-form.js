document.addEventListener('DOMContentLoaded', function(event) {
    let contact_form = document.getElementById('contact_form');

    contact_form.addEventListener('submit', (event) => {
        event.preventDefault();

        const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        let cf_error = false;
        let formData = new FormData();

        for (field of contact_form.elements) {
            if (field.type != 'submit' && field.type != 'hidden') {
                field.style = "border-color: #ced4da";
                formData.append(field.id, field.value);
                if (
                    field.value == "" ||
                    (field.type == "email" && !regex.test(field.value))
                ) {
                    cf_error = true;
                    field.style = "border-color: red";
                } 
            }   
        }

        if (!cf_error) {
            let options = {
                method: "POST",
                mode: "cors",
                body: formData
            };

            let req = new Request(
                ajaxurl + "?action=wptest_contact_form",
                options
            );

            fetch(req)
                .then(response => {
                    if (response.ok) {
                        contact_form.reset();
                        $("#cf_alert")
                            .text("Your message was successful sent!")
                            .show()
                            .fadeOut(3000);
                    } else {
                        $("#cf_alert")
                            .text("An error occurred.")
                            .show()
                            .fadeOut(3000);
                    }
                })
                .catch(err => {
                    console.log("ERROR:", err.message);
                });
        } else {
            $("#cf_alert")
                .text("Some fields are invalid or empty")
                .show()
                .fadeOut(5000);
        }        
    });
});