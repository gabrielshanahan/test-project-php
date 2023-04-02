"use strict";

import {withoutHeader, cityColumnIndex } from "./populate.js";
import {cityFilter, userTable } from "../dom/elements.js";


cityFilter.addEventListener("change", (event) => {
    resetTable();
    const selectedCity = event.target.value;
    if(selectedCity !== "") {
        let numDeleted = 0;
        for(const row of withoutHeader) {
            if(row.children[cityColumnIndex].textContent !== selectedCity) {
                userTable.deleteRow(withoutHeader.indexOf(row) - numDeleted++ + 1);
            }
        }

    }
});

function resetTable() {
    const oldBody = userTable.getElementsByTagName("tbody");
    const newBody = document.createElement("tbody");
    withoutHeader.forEach((it) => newBody.appendChild(it));
    userTable.replaceChild(newBody, oldBody[0]);
}