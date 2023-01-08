const toggleMenuButton = document.getElementById('dashboard-mobile')
const dashboardPannel = document.getElementById('dashboard-nav-pannel')
const dashboardNavlinks = document.querySelectorAll('.dashboard-link-title')
const dashboardNavButtons = document.querySelectorAll('.dashboard-menu-link')
const dashboardContent = document.getElementById('dashboard-content')


toggleMenuButton.addEventListener('click', () => {
    toggleMenuButton.classList.toggle('dashboard-mobile-open')
    dashboardPannel.classList.toggle('dashboard-nav-open')
    dashboardNavlinks.forEach(links => links.classList.toggle('d-block'))
    dashboardNavButtons.forEach(links => links.classList.toggle('p-3'))
    dashboardContent.classList.toggle('d-none')
})