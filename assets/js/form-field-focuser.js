module.exports = function (input) {
    let inputValue = input.value;

    window.setTimeout(function () {
        input.focus();
        input.value = '';
        input.value = inputValue;
    }, 1);
};
