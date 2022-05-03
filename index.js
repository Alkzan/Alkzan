
const element = document.querySelector(".fa-user");
const srchbar = document.querySelector(".actions-submenu_connect");

window.onload = () => {
    element.addEventListener('click', () => {
        srchbar.classList.toggle("active");
    });
};