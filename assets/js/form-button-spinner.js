let FormButton = require('./model/element/form-button');

module.exports = function (form) {
    const submitButton = new FormButton(form.querySelector('button[type=submit]'));

    form.addEventListener('submit', function () {
        submitButton.markAsBusy();
    });
};
