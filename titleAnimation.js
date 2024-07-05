// Effet du nom du site
document.addEventListener('DOMContentLoaded', () => {
  const spans = document.querySelectorAll('.backgroundText span');

  spans.forEach((span, index) => {
    setTimeout(() => {
      span.classList.add('active');
    }, (index + 1) * 250); // L'ajustement du délai d'animation pour chaque span
  });
});
