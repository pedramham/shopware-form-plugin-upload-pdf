import HttpClient from 'src/service/http-client.service';
import Plugin from 'src/plugin-system/plugin.class';

export default class CustomForm extends Plugin {
    init() {

        // initialize the HttpClient
        this._client = new HttpClient();
        this.button = this.el.children['custom-form-ajax-button'];
        document.getElementById("custom_form").addEventListener("click", this._toggleAttribute);
        this._registerEvents();
    }

    _toggleAttribute() {
        // Get form field values
        const firstName = document.getElementById("firstName").value;
        const lastName = document.getElementById("lastName").value;
        const company = document.getElementById("company").value;
        const email = document.getElementById("email").value;
        // Check if any of the fields are empty
        document.getElementById('custom-form-ajax-button').disabled = firstName === "" || lastName === "" || company === "" || email === "";
    }

    _registerEvents() {
        this.button.addEventListener('click', this._fetch.bind(this));
    }

    _fetch(event) {

        const firstName = document.getElementById("firstName").value;
        const lastName = document.getElementById("lastName").value;
        const phoneNumber = document.getElementById("phoneNumber").value;
        const company = document.getElementById("company").value;
        const email = document.getElementById("email").value;
        const country = document.getElementById("country").value;
        const city = document.getElementById("city").value;
        const postalCode = document.getElementById("postalCode").value;
        const streetNumber = document.getElementById("streetNumber").value;
        const street = document.getElementById("street").value;
        const description = document.getElementById('description').value;
        const inputFile = document.getElementById('customFile');


        let data = new FormData();

        let payload = JSON.stringify({
            "firstName": firstName,
            "lastName": lastName,
            "phoneNumber": phoneNumber,
            "company": company,
            "email": email,
            "country": country,
            "city": city,
            "postalCode": postalCode,
            "streetNumber": streetNumber,
            "street": street,
            "description": description

        });

        data.append('data', payload);

        if (inputFile.files[0]) {
            let file = inputFile.files[0];
            data.append('files', file, file.name);
        }

        event.preventDefault();
        this._client.post(
            '/sas/custom/form',
            data,
            this._setContent.bind(this),
            false,
            true
        );

    }

    _setContent(data) {

        // Parse the data as JSON
        data = JSON.parse(data);

        // Get references to the alert message elements
        const alertMessageWarning = document.getElementById("alert-message-warning");
        const alertMessageSuccess = document.getElementById("alert-message-success");

        if (data.error) {
            // Show warning message and hide success message
            alertMessageSuccess.classList.remove("d-block");
            alertMessageSuccess.classList.add("d-none");

            alertMessageWarning.classList.remove("d-none");
            alertMessageWarning.classList.add("d-block");
            alertMessageWarning.classList.add("show");
            alertMessageWarning.appendChild(document.createTextNode(data.message));

        } else {
            // Show success message and hide warning message
            alertMessageWarning.classList.remove("d-block");
            alertMessageWarning.classList.add("d-none");

            alertMessageSuccess.classList.remove("d-none");
            alertMessageSuccess.classList.add("show");
            alertMessageSuccess.classList.add("d-block");
            alertMessageSuccess.appendChild(document.createTextNode(data.message));
            // Disable the form submit button
            document.getElementById('custom-form-ajax-button').disabled = true;
        }


    }
}
