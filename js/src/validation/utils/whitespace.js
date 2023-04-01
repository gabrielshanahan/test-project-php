"use strict";

export function validateWhitespace(subject, str) {
    let messages = [];
    if (/^(\s)+$/.test(str)) {
        messages.push(`${subject} cannot contain only whitespace`);
    } else {
        if (/^(\s).*$/.test(str)) {
            messages.push(`${subject} cannot start with whitespace`);
        }
        if (/^.*(\s)+$/.test(str)) {
            messages.push(`${subject} cannot end with whitespace`);
        }
    }
    return messages;
}