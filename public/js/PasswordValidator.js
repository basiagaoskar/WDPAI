class PasswordValidator {
    constructor() {
        this.password = document.getElementById('password');
        this.confirmPassword = document.getElementById('confirm-password');
        this.registerButton = document.getElementById('registerButton');
        this.requirements = {
            length: document.getElementById('length'),
            uppercase: document.getElementById('uppercase'),
            number: document.getElementById('number'),
            special: document.getElementById('special')
        };

        this.initListeners();
    }

    initListeners() {
        this.password.addEventListener('input', () => this.checkPasswordStrength());
        this.confirmPassword.addEventListener('input', () => this.checkPasswordStrength());
    }

    checkPasswordStrength() {
        const passwordValue = this.password.value;
        const confirmPasswordValue = this.confirmPassword.value;
        let isValid = true;

        if (passwordValue.length >= 8) {
            this.setValid(this.requirements.length, true);
        } else {
            this.setValid(this.requirements.length, false);
            isValid = false;
        }

        if (/[A-Z]/.test(passwordValue)) {
            this.setValid(this.requirements.uppercase, true);
        } else {
            this.setValid(this.requirements.uppercase, false);
            isValid = false;
        }

        if (/\d/.test(passwordValue)) {
            this.setValid(this.requirements.number, true);
        } else {
            this.setValid(this.requirements.number, false);
            isValid = false;
        }

        if (/[\W_]/.test(passwordValue)) {
            this.setValid(this.requirements.special, true);
        } else {
            this.setValid(this.requirements.special, false);
            isValid = false;
        }

        if (passwordValue !== confirmPasswordValue) {
            isValid = false;
        }

        this.registerButton.disabled = !isValid;
    }

    setValid(element, isValid) {
        if (isValid) {
            element.classList.add('valid');
        } else {
            element.classList.remove('valid');
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new PasswordValidator();
});
