const toggleMenuButton = document.getElementById('dashboard-mobile')
const dashboardPannel = document.getElementById('dashboard-nav-pannel')
const dashboardNavlinks = document.querySelectorAll('.dashboard-link-title')
const dashboardNavButtons = document.querySelectorAll('.menu-link')
const groupLinksTitle = document.querySelectorAll('.links-title')
const dashboardContent = document.getElementById('dashboard-content')

toggleMenuButton.addEventListener('click', () => {

    toggleMenuButton.classList.toggle('dashboard-mobile-open')
    dashboardPannel.classList.toggle('dashboard-nav-open')
    groupLinksTitle.forEach(links => links.classList.toggle('text-center'))
    dashboardNavlinks.forEach(links => links.classList.toggle('d-block'))
    dashboardNavButtons.forEach(links => links.classList.toggle('menu-link-close'))
    dashboardNavButtons.forEach(links => links.classList.toggle('menu-link-open'))
    dashboardNavButtons.forEach(links => links.classList.toggle('py-3'))
    dashboardContent.classList.toggle('d-none')
    
})