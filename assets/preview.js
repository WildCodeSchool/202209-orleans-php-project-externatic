
const avatarInput = document.getElementById('candidate_user_avatarFile_file') ?? document.getElementById('recruiter_avatarFile_file')
const avatarThumb = document.getElementById('avatar')
avatarInput.addEventListener('change', (e) => {
    avatarThumb.src = URL.createObjectURL(e.target.files[0]);
})
