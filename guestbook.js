toggleHiddenOtherSection();

document.getElementById("mailingList").addEventListener("change", toggleHiddenEmailSection);
document.getElementById("howMet").addEventListener("change", toggleHiddenOtherSection);
document.getElementById("mailingList").addEventListener("change", toggleEmailRequired);

document.getElementById("guest-form").onsubmit = validate;

/**
 * Validates all form data before form is submitted. Will cancel form submit if returns false
 * @returns {boolean} True if all data is valid
 */
function validate() {
    clearAllErrMsgs();

    let isValid = true;

    // Make sure all required text has content and show any error msgs
    if (!validateAllRequired()) {
        isValid = false;
    }

    // Check for a valid email and show any error msgs
    let emailField = document.getElementById("email");
    if (!validateEmail(emailField)) {
        isValid = false;
    }

    // Check for valid URL and show any error msgs
    let liUrlField = document.getElementById("liURL");
    if (!validateURL(liUrlField)) {
        isValid = false;
    }

    return isValid;
}

/**
 * Shows error message if invalid URL (must contain http:// or https://
 * @param urlField The URL to check validity
 * @returns {boolean} true if URL is valid
 */
function validateURL(urlField) {
    let url = urlField.value.trim();

    // only display msg for valid url format if characters are typed in
    if (url != "" && (!url.includes("http://") && !url.includes("https://"))) {

        // Error message id is "err-" + the id of the input it belongs to
        let errMsg = document.getElementById("err-format-" + urlField.id);
        errMsg.style.display = "initial";

        return false;
    }
    return true;
}

/**
 * Hides all the error messages appearing next to input fields
 */
function clearAllErrMsgs() {
    let errors = document.getElementsByClassName("err");

    for (let i = 0; i < errors.length; i++) {
        errors[i].style.display = "none";
    }
}


/**
 * Checks if all required inputs that accept text contain text that is not whitespace.
 * If not field is not valid it's error message is shown
 * @returns {boolean} true if all required inputs that accept text contain text
 */
function validateAllRequired() {
    let hasAllText = true;
    let reqTxtInputs = document.getElementsByClassName("required");

    // check all required inputs that accept text
    for (let i = 0; i < reqTxtInputs.length; i++) {

        if (!validateRequired(reqTxtInputs[i])) {
            hasAllText = false;
        }
    }
    return hasAllText;
}

/**
 * Shows error message if input's value is empty
 * @param input the input to check the value of
 * @returns {boolean} true if not empty excluding whitespace
 */
function validateRequired(input) {
    let val = input.value.trim();

    if (val == "") {

        // Error message id is "err-" + the id of the input it belongs to
        let errMsg = document.getElementById("err-" + input.id);
        errMsg.style.display = "initial";

        return false;
    }
    return true;
}

/**
 * Shows error message if email is not valid.
 * @param emailField input containing email value
 * @returns {boolean} true if email is valid
 */
function validateEmail(emailField) {
    let emailTxt = emailField.value.trim();

    // only display msg for valid email format if characters are typed in
    if (emailTxt != "" && !isValidEmail(emailTxt)) {

        // error message id is "err-format-" + the id of the input it belongs to
        let emailError = document.getElementById("err-format-" + emailField.id);
        emailError.style.display = "initial";

        return false;
    }
    return true;
}

/**
 * Checks if email contains "@" and "."
 * @param emailTxt the email to check for validity
 * @returns {boolean} true if email is valid
 */
function isValidEmail(emailTxt) {
    return emailTxt.includes("@") && emailTxt.includes(".");
}

/**
 * Makes the email field required if user wants on the mailing list
 */
function toggleEmailRequired() {
    let mailingListIsChecked = document.getElementById("mailingList").checked;
    let emailField = document.getElementById("email");

    if (mailingListIsChecked) {
        emailField.classList.add("required");
    }
    else {
        emailField.classList.remove("required");
    }
}

/**
 * toggles the display of the email field to display none and initial.
 * If mailing list option is checked the email format section will show
 */
function toggleHiddenEmailSection() {
    let emailSection = document.getElementById("emailFormatSection");

    if (this.checked) {
        emailSection.style.display = "initial";
    }
    else {
        emailSection.style.display = "none";
    }
}

/**
 * Toggles the display between none and initial for the "Other" text field.
 * Will show if the "Other" option is selected from the "How we met" drop down and
 * will be required to submit the form.
 */
function toggleHiddenOtherSection() {
    let otherSection = document.getElementById("otherSection");
    let otherInput = document.getElementById("other");

    if (document.getElementById("howMet").value == "other") {
        otherSection.style.display = "initial";
        otherInput.classList.add("required");
    }
    else {
        otherSection.style.display = "none";
        otherInput.classList.remove("required");
    }
}