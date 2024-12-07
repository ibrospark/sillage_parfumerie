document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');

    togglePasswordButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const input = this.previousElementSibling; // L'input de mot de passe correspondant
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = '<i class="fa fa-eye-slash"></i>';
            } else {
                input.type = 'password';
                this.innerHTML = '<i class="fa fa-eye"></i>';
            }
        });
    });
});