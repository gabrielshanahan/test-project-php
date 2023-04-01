"use strict";

import {validateWhitespace} from "../../../src/validation/utils/whitespace";

describe("validateWhitespace", () => {
    test("correctly handles strings containing only whitespace", () => {
        expect(validateWhitespace("a test", "  \t\n"))
            .toMatchObject(["a test cannot contain only whitespace"]);
    });

    test("correctly handles strings starting with whitespace", () => {
        expect(validateWhitespace("a test", " abc"))
            .toMatchObject(["a test cannot start with whitespace"]);
    });

    test("correctly handles strings ending with whitespace", () => {
        expect(validateWhitespace("a test", "abc "))
            .toMatchObject(["a test cannot end with whitespace"]);
    });

    test("correctly handles multiple errors", () => {
        expect(validateWhitespace("a test", " abc "))
            .toMatchObject(["a test cannot start with whitespace", "a test cannot end with whitespace"]);
    });
});