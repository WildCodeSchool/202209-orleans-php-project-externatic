
const avatarInput = document.getElementById('registration_form_avatarFile_file')
const avatarThumb = document.getElementById('avatar')
avatarInput.addEventListener('change', (e) => {
    avatarThumb.src = URL.createObjectURL(e.target.files[0]);
})
