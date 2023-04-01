"use strict";

/**
 * A simple class which encapsulates functionality relating to validation. It makes two things easier:
 * - defining custom messages for built-in validation errors via the Constraint Validation API
 * - defining custom validation logic
 *
 * For the former, extend this class and define {@link Validator.builtInErrorsToMessages} as an association between the
 * Constraint Validation API property and a string message. Alternatively, the value can also be a function, which will
 * receive the input element as a parameter.
 *
 * For the latter, define {@link Validator.customValidations}, which should return an array of messages to display.
 *
 * All applicable error messages will then be joined with ", " and added to the textContent of the appropriate element.
 */
export default class Validator {
    #inputElem;
    #inputErrorFeedbackElem;
    builtInErrorsToMessages;

    /**
     *
     * @param inputElement The element on which the validation is performed
     * @param errorFeedbackElement The element which should display the errors. If not specified, taken from
     *                             'aria-describedby' attribute of inputElement
     */
    constructor(inputElement, errorFeedbackElement) {
        this.#inputElem = inputElement;

        if(!(this.#inputElem instanceof Element)) {
            throw new Error(`The input element must be an instance of Element (${this.#inputElem})`);
        }

        this.#inputErrorFeedbackElem = errorFeedbackElement
            ?? document.getElementById(inputElement.getAttribute("aria-describedby"));

        if(!(this.#inputErrorFeedbackElem instanceof Element)) {
            throw new Error(
                `The error feedback element must be an instance of Element (${this.#inputErrorFeedbackElem})`
            );
        }

        this.#inputElem.addEventListener("focusout", this.validateAndMutateDOM.bind(this));
    }

    validateAndMutateDOM() {
        const inputErrorClass = "is-invalid";
        const errorMessage = this.buildErrorMessage();

        if (errorMessage !== "") {
            this.#inputErrorFeedbackElem.textContent = errorMessage;
            this.#inputElem.classList.add(inputErrorClass);
            return false;
        } else {
            this.#inputErrorFeedbackElem.textContent = "";
            this.#inputElem.classList.remove(inputErrorClass);
            return true;
        }
    }

    buildErrorMessage() {
        const customMessage = this.customValidations(this.#inputElem);
        const builtInMessages = Object.entries(this.builtInErrorsToMessages)
            .filter(([error]) => this.#inputElem.validity[error])
            .map(([, errorText]) =>
                typeof errorText === "function" ?
                    errorText(this.#inputElem) :
                    errorText);
        const errorMessage = builtInMessages.concat(customMessage).join(", ");

        return Validator.#capitalize(errorMessage);
    }

    static #capitalize(it) {
        return it.charAt(0).toUpperCase() + it.slice(1);
    }

    customValidations(inputElem) { // eslint-disable-line no-unused-vars
        return [];
    }
}
