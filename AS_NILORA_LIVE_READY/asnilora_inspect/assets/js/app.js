document.addEventListener('DOMContentLoaded', () => {
 const toggle=document.querySelector('.menu-toggle');
 const nav=document.querySelector('.main-nav');
 if(toggle && nav) toggle.addEventListener('click',()=>nav.classList.toggle('nav-open'));
});
