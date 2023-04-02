/**
 * @jest-environment jsdom
 */
"use strict";

import Validator from "../../../src/validation/base.js";

let testValidator = null;
let elemInput = null;

describe("Validator", () => {
    beforeEach(() => {
        document.body.innerHTML = `
<form>
    <input name="test" type="text" id="test" aria-describedby="test-error" required />
    <span id="test-error"></span>
</form>`;

        elemInput = document.getElementById("test");
        testValidator = new Validator(elemInput);

        testValidator.builtInErrorsToMessages = {
            valueMissing: "valueMissing",
        };
    });

    test("produces correct message on validation error", () => {
        expect(testValidator.buildErrorMessages()).toMatchObject(["valueMissing"]);
    });

    test("sets correct class on validation error", () => {
        testValidator.validateAndRender();
        expect(elemInput.classList).toContain("is-invalid");
    });

    test("produces correct message on multiple validation errors", () => {
        testValidator.customValidations = () => "abc";
        expect(testValidator.buildErrorMessages()).toMatchObject(["valueMissing", "abc"]);
    });
});
