let body = document.body;

let profile = document.querySelector(".header .flex .profile");

// document.querySelector("#user-btn").onclick = () => {
//   profile.classList.toggle("active");
//   searchform.classList.remove("active");
// };

let searchform = document.querySelector(".header .flex .search-form");
document.querySelector("#search-btn").onclick = () => {
  searchform.classList.toggle("active");
  profile.classList.remove("active");
};

let sideBar = document.querySelector(".side-bar");
document.querySelector("#menu-btn").onclick = () => {
  // console.log('hello world')
  sideBar.classList.toggle("active");
  body.classList.toggle("active");
};

document.querySelector(".side-bar .close-side-bar").onclick = () => {
  // console.log('hello world')
  sideBar.classList.remove("active");
  body.classList.remove("active");
};
window.onscroll = () => {
  searchform.classList.remove("active");
  profile.classList.remove("active");
  if (window.innerWidth < 1200) {
    sideBar.classList.remove("active");
    body.classList.remove("active");
  }
};
let togglebtn = document.querySelector("#toggle-btn");
let darkMode = localStorage.getItem("dark-mode");

const enableDarkMode = () => {
  togglebtn.classList.replace("fa-sun", "fa-moon");
  body.classList.add("dark");
  localStorage.setItem("dark-mode", "enabled");
};
const disableDarkMode = () => {
  togglebtn.classList.replace("fa-moon", "fa-sun");
  body.classList.remove("dark");
  localStorage.setItem("dark-mode", "disabled"); //noice :)
};
if (darkMode === "enabled") {
  enableDarkMode();
}
togglebtn.onclick = (e) => {
  let darkMode = localStorage.getItem("dark-mode");
  if (darkMode === "disabled") {
    enableDarkMode();
  } else {
    disableDarkMode();
  }
};
