"use strict";
import Validator from "./base.js";
import {validateWhitespace} from "./utils/whitespace.js";
import {phoneInput} from "../dom/elements.js";

const phoneValidator = new Validator(phoneInput);

phoneValidator.builtInErrorsToMessages = {
    valueMissing: "you need to enter a phone number",
    patternMismatch: "entered value is not a valid phone number",
    tooShort: (phone) =>
        `phone number must be more than than ${phone.minLength} characters; you entered ${phone.value.length}`,
    tooLong: (phone) =>
        `phone number must be less than ${phone.maxLength} characters; you entered ${phone.value.length}`,
};

phoneValidator.customValidations = (phone) => validateWhitespace("an e-mail", phone.value);

export default phoneValidator;
