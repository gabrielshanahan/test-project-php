"use strict";

import emailValidator from "./email.js";
import nameValidator from "./name.js";
import cityValidator from "./city.js";
import phoneValidator from "./phone.js";
import {submitFormButton} from "../dom/elements.js";

submitFormButton.addEventListener("click", (event) => {
    const validators = [emailValidator, nameValidator, cityValidator, phoneValidator];
    const isValid = validators.reduce(
        (isValid, validator) => validator.validateAndRender() && isValid,
        true,
    );
    if (!isValid) {
        event.preventDefault();
    }
});
