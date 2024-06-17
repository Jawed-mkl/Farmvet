const body = document.querySelector('body');
const sidebar = document.querySelector('nav');
const toggle = document.querySelector(".toggle");
const searchBtn = document.querySelector(".search-box");
const modeSwitch = document.querySelector(".toggle-switch");
const modeText = document.querySelector(".mode-text");
const head = document.querySelector(".head");
const boxInfoItems = document.querySelectorAll('.box-info li'); // Select box-info list items

// Toggle sidebar open/close on click
toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

// Ensure sidebar is open when search button is clicked
searchBtn.addEventListener("click", () => {
    sidebar.classList.remove("close");
});

// Toggle between light and dark mode CSS
modeSwitch.addEventListener("click", () => {
    // Toggle between light-mode.css and dark-mode.css
    const lightModeCSS = document.getElementById('light-mode-stylesheet');
    const darkModeCSS = document.getElementById('dark-mode-stylesheet');

    if (lightModeCSS.disabled) {
        lightModeCSS.disabled = false;
        darkModeCSS.disabled = true;
        modeText.innerText = "Dark mode";
        body.classList.remove("dark");
        head.classList.remove("dark-head");
        // Remove dark class from each .box-info li
        boxInfoItems.forEach(item => item.classList.remove('dark-item'));
    } else {
        lightModeCSS.disabled = true;
        darkModeCSS.disabled = false;
        modeText.innerText = "Light mode";
        body.classList.add("dark");
        head.classList.add("dark-head");
        // Add dark class to each .box-info li
        boxInfoItems.forEach(item => item.classList.add('dark-item'));
    }
});
