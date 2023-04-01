"use strict";
import Validator from "./base.js";
import {validateWhitespace} from "./utils/whitespace.js";
import {emailInput} from "../dom/elements.js";

const emailValidator = new Validator(emailInput);

emailValidator.builtInErrorsToMessages = {
    valueMissing: "you need to enter an e-mail address",
    patternMismatch: "entered value is not a valid e-mail address",
    tooLong: (email) => `e-mail must be less than ${email.maxLength} characters; you entered ${email.value.length}`,
};

emailValidator.customValidations = (email) => validateWhitespace("an e-mail", email.value);

export default emailValidator;
