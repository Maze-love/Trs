// const Sidebar= document.getElementById("side");
// console.log(Sidebar)
const btn = document.querySelector(".sidebar-toggle-btn");

const Sidebar = document.querySelector(".wrapper");

btn.addEventListener("click", () => {
    Sidebar.classList.toggle("wrapper-show");
    // console.log(Sidebar);
});

// const sidebar = document.getElementById('sidebar');
// const sidebarToggle = document.getElementById('sidebarToggle');
// const sidebarOverlay = document.getElementById('sidebarOverlay');
// console.log(sidebar);

// sidebarToggle && sidebarToggle.addEventListener('click', function() {
//     sidebar.classList.toggle('active');
// console.log(sidebar);

//     sidebarOverlay.classList.toggle('active');
// });
