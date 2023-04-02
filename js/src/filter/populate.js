"use strict";

import {cityFilter, userTable} from "../dom/elements.js";

const allRows = userTable.rows;
const headerRow = allRows[0];
const cityColumnIndex = Array.from(headerRow.children)
    .findIndex((it) => it.textContent === "City");

const withoutHeader = Array.from(allRows).slice(1);
const uniqueCities = new Set(
    withoutHeader.map((it) =>
        it.children[cityColumnIndex].textContent
    )
);

cityFilter.innerHTML += Array.from(uniqueCities)
    .map((it) => `<option value="${it}">${it}</option>`)
    .join("");


export { withoutHeader, cityColumnIndex };