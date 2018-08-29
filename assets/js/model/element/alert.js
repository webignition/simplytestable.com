let bsn = require('bootstrap.native');
let formFieldFocuser = require('../../form-field-focuser');

class Alert {
    constructor (element) {
        this.element = element;

        let closeButton = element.querySelector('.close');
        if (closeButton) {
            closeButton.addEventListener('click', this._closeButtonClickEventHandler.bind(this));
        }
    }

    setStyle (style) {
        this._removePresentationalClasses();

        this.element.classList.add('alert-' + style);
    };

    wrapContentInContainer () {
        let container = this.element.ownerDocument.createElement('div');
        container.classList.add('container');

        container.innerHTML = this.element.innerHTML;
        this.element.innerHTML = '';

        this.element.appendChild(container);
    };

    _removePresentationalClasses () {
        let presentationalClassPrefix = 'alert-';

        this.element.classList.forEach((className, index, classList) => {
            if (className.indexOf(presentationalClassPrefix) === 0) {
                classList.remove(className);
            }
        });
    };

    _closeButtonClickEventHandler () {
        let relatedFieldId = this.element.getAttribute('data-for');
        if (relatedFieldId) {
            let relatedField = this.element.ownerDocument.getElementById(relatedFieldId);

            if (relatedField) {
                formFieldFocuser(relatedField);
            }
        }

        let bsnAlert = new bsn.Alert(this.element);
        bsnAlert.close();
    }
}

module.exports = Alert;
