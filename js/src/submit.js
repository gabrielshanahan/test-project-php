"use strict";

import "../../node_modules/jquery/dist/jquery.min.js";
import {
    cityInput,
    emailInput,
    form,
    nameInput,
    phoneInput,
    unknownErrorDescription,
    unknownErrors
} from "./dom/elements.js";
import nameValidator from "./validation/name.js";
import emailValidator from "./validation/email.js";
import cityValidator from "./validation/city.js";
import phoneValidator from "./validation/phone.js";

const jqueryForm = $(form);

jqueryForm.submit(async (event) => {
    event.preventDefault();
    unknownErrorDescription.textContent = "";
    unknownErrors.classList.add("hidden");

    const data = {
        name: nameInput.value,
        email: emailInput.value,
        city: cityInput.value,
        phone: phoneInput.value,
    };

    const response = await fetch(
        "create.php", {
            method: "post",
            body: JSON.stringify(data)
        }
    );

    try {
        if(response.status === 200) {
            window.location.reload();
        } else if(response.status === 400) {
            const json = await response.json();
            if("name" in json) {
                nameValidator.renderErrors(json.name);
            }

            if("email" in json) {
                emailValidator.renderErrors(json.email);
            }

            if("city" in json) {
                cityValidator.renderErrors(json.city);
            }

            if("phone" in json) {
                phoneValidator.renderErrors(json.phone);
            }
        } else if(response.status === 500) {
            unknownErrorDescription.textContent = await response.text();
            unknownErrors.classList.remove("hidden");
        } else {
            unknownErrorDescription.textContent = `Unexpected status ${response.status}`;
            unknownErrors.classList.remove("hidden");
        }
    } catch (e) {
        unknownErrorDescription.textContent = e.toString();
        unknownErrors.classList.remove("hidden");
    }
});
