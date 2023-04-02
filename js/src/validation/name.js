"use strict";
import Validator from "./base.js";
import {validateWhitespace} from "./utils/whitespace.js";
import {nameInput} from "../dom/elements.js";

const nameValidator = new Validator(nameInput);

nameValidator.builtInErrorsToMessages = {
    valueMissing: "you need to enter a name",
    patternMismatch: "a name cannot begin with a number",
    tooLong: (name) => `name must be less than ${name.maxLength} characters; you entered ${name.value.length}`,
};

nameValidator.customValidations = (name) => validateWhitespace("a name", name.value);

export default nameValidator;
