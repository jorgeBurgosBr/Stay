document.addEventListener('DOMContentLoaded', function () {
   const mobileMenu = document.getElementById('mobile-menu');
   const navMenu = document.querySelector('nav ul');
 
   mobileMenu.addEventListener('click', function () {
     navMenu.classList.toggle('show');
   });
 });