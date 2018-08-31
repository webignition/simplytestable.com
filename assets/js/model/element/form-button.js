let Icon = require('./icon');

class FormButton {
    constructor (element) {
        let iconElement = element.querySelector(Icon.getSelector());

        this.element = element;
        this.icon = iconElement ? new Icon(iconElement) : null;
    }

    markAsBusy () {
        if (this.icon) {
            this.icon.setBusy();
            this.deEmphasize();
        }
    }

    markAsAvailable () {
        if (this.icon) {
            this.icon.setAvailable('fa-caret-right');
            this.unDeEmphasize();
        }
    }

    markSucceeded () {
        if (this.icon) {
            this.icon.setSuccessful();
        }
    }

    disable () {
        this.element.setAttribute('disabled', 'disabled');
    }

    enable () {
        this.element.removeAttribute('disabled');
    }

    deEmphasize () {
        this.element.classList.add('de-emphasize');
    };

    unDeEmphasize () {
        this.element.classList.remove('de-emphasize');
    };
}

module.exports = FormButton;
