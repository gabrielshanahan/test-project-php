"use strict";

const form = document.getElementById("add-user");
const submitFormButton = document.querySelector("#add-user > button");

const unknownErrors = document.getElementById("unknown-errors");
const unknownErrorDescription = document.getElementById("unknown-error-description");

const nameInput = document.getElementById("name");
const emailInput = document.getElementById("email");
const cityInput = document.getElementById("city");
const phoneInput = document.getElementById("phone");
const csrfTokenInput = document.getElementById("csrf-token");

const userTable = document.getElementById("user-table");
const cityFilter = document.getElementById("city-filter");

export {
    form, unknownErrors, unknownErrorDescription, submitFormButton,
    nameInput, emailInput, cityInput, phoneInput, csrfTokenInput,
    userTable, cityFilter
};