"use strict";

import emailValidator from "./email.js";
import nameValidator from "./name.js";
import cityValidator from "./city.js";
import {submitFormButton} from "../dom/elements.js";

submitFormButton.addEventListener("click", (event) => {
    const validators = [emailValidator, nameValidator, cityValidator];
    const isValid = validators.reduce(
        (isValid, validator) => validator.validateAndMutateDOM() && isValid,
        true,
    );
    if (!isValid) {
        event.preventDefault();
    }
});
