document.getElementById('favorite').addEventListener('click', addToFavorite);

let favoriteIsPending = false;

function addToFavorite(event) {
    event.preventDefault();

    
    favoriteIsPending = true;
    
    let favoriteLink = event.currentTarget;
    let link = favoriteLink.href;
    
    if (!favoriteIsPending) {
        window.URL.href(link);
    }
    try {

        fetch(link, { method: "POST" })
            .then(res => res.json())
            .then(function (res) {
                let favoriteIcon = favoriteLink.firstElementChild;
                if (res.isInFavorite) {
                    favoriteIcon.classList.remove('bi-star');
                    favoriteIcon.classList.add('bi-star-fill');
                    favoriteIsPending = false;

                } else {
                    favoriteIcon.classList.remove('bi-star-fill');
                    favoriteIcon.classList.add('bi-star');
                    favoriteIsPending = false;
                }

            });
    } catch (error) {
        favoriteIsPending = false;
    }
}