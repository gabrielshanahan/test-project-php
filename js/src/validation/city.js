"use strict";
import Validator from "./base.js";
import {validateWhitespace} from "./utils/whitespace.js";
import {cityInput} from "../dom/elements.js";

const cityValidator = new Validator(cityInput);

cityValidator.builtInErrorsToMessages = {
    valueMissing: "you need to enter a city",
    tooLong: (city) => `city must be less than ${city.maxLength} characters; you entered ${city.value.length}`,
};
cityValidator.customValidations = (city) => validateWhitespace("a city", city.value);

export default cityValidator;
