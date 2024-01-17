// SLIDER MANUAL
let currentSlide = 1;

function changeSlide(n) {
    showSlide(currentSlide += n);
}

function showSlide(n) {
    const slides = document.querySelector('.slides2');
    if (n > 5) { currentSlide = 1; }
    if (n < 1) { currentSlide = 5; }
    slides.style.transform = `translateX(${-(currentSlide - 1) * 100}%)`;
}