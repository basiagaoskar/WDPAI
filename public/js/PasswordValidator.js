class PasswordValidator {
    constructor() {
        this.password = document.getElementById('password') || null;
        this.confirmPassword = document.getElementById('confirm-password') || null;
        this.registerButton = document.getElementById('registerButton') || null;
        this.requirements = {
            length: document.getElementById('length') || null,
            uppercase: document.getElementById('uppercase') || null,
            number: document.getElementById('number') || null,
            special: document.getElementById('special') || null
        };
        this.togglePassword = document.getElementById('togglePassword') || null;

        this.initListeners();
    }

    initListeners() {
        if (this.password && this.requirements.length && this.requirements.uppercase && this.requirements.number && this.requirements.special) {
            this.password.addEventListener('input', () => this.checkPasswordStrength());
        }
        if (this.confirmPassword) {
            this.confirmPassword.addEventListener('input', () => this.checkPasswordStrength());
        }
        if (this.togglePassword) {
            this.togglePassword.addEventListener('click', () => this.togglePasswordVisibility());
        }
    }

    checkPasswordStrength() {
        if (!this.password) return;
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

    togglePasswordVisibility() {
        const type = this.password.getAttribute('type') === 'password' ? 'text' : 'password';
        this.password.setAttribute('type', type);
        this.togglePassword.querySelector('i').classList.toggle('fa-eye');
        this.togglePassword.querySelector('i').classList.toggle('fa-eye-slash');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new PasswordValidator();
});
