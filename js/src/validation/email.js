"use strict";
import Validator from "./base.js";
import {validateWhitespace} from "./utils/whitespace.js";
import {emailInput} from "../dom/elements.js";

const emailValidator = new Validator(emailInput);

/*
 * Kudos @ https://stackoverflow.com/a/201378
 *
 * The pattern only matches lowercase inputs, and since the HTML 'pattern'
 * attribute does not allow us to specify the 'i' flag, we need to do things manually.
 * This seems to be safer than modifying the pattern, which has a "works-if-not-touched"
 * quality to it.
 */
const emailPattern = new RegExp(
    "(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\x22(?:" +
    "[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])*" +
    "\x22)@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:" +
    "(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9]" +
    "[0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]" +
    "|\\\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\\])",
    "i"
)

emailValidator.builtInErrorsToMessages = {
    valueMissing: "you need to enter an e-mail address",
    tooLong: (email) => `e-mail must be less than ${email.maxLength} characters; you entered ${email.value.length}`,
};

emailValidator.customValidations = (email) => {
    let messages = validateWhitespace("an e-mail", email.value)
    if(!emailPattern.test(email.value)) {
        messages.push("entered value is not a valid e-mail address")
    }
    return messages
}

export default emailValidator;
