const passwordInput = document.getElementById('new-password');
const passwordConfirmInput = document.getElementById('password-confirmation');

passwordConfirmInput.addEventListener('input', () => {
    if (passwordConfirmInput.value != passwordInput.value) {
        passwordConfirmInput.setCustomValidity("Konfirmasi kata sandi tidak sesuai")
        passwordConfirmInput.reportValidity()
    } else {
        passwordConfirmInput.setCustomValidity("")
    }
})