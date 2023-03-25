const tabButtons = document.querySelectorAll('.tab-button');
const textTabButtons = document.querySelectorAll('.tab-button>span');
const tabContents = document.querySelectorAll('.tab-content');

const containerTabContents = document.querySelector('#container-tab-contents');

function displayTab(tabIndex) {

  tabContents.forEach((tabContent) => {
    tabContent.classList.remove('active');
    if (tabContent.getAttribute('data-tab') === tabIndex) {
      tabContent.classList.add('active');

      // Changer la couleur du contenu avec celle de l'onglet actif
      var buttonSelected= document.querySelector('button[data-tab="'+tabIndex+'"]');
      var stylebuttonSelected = window.getComputedStyle(buttonSelected);
      containerTabContents.style.backgroundColor = stylebuttonSelected.backgroundColor;
    }
  });

  tabButtons.forEach((tabButton) => {
    tabButton.classList.remove('active');
    if (tabButton.getAttribute('data-tab') === tabIndex) {
       tabButton.classList.add('active');
    }
  });

  textTabButtons.forEach((textTabButton) => {
    textTabButton.classList.remove('active');
    if (textTabButton.getAttribute('data-tab') === tabIndex) {
      textTabButton.classList.add('active');
    }
  });

}

tabButtons.forEach((tabButton) => {
  tabButton.addEventListener('click', (event) => {
    const tabIndex = event.target.getAttribute('data-tab');
    displayTab(tabIndex);
    setDimensions();
  });
});

displayTab(tabButtons[0].getAttribute('data-tab'));

$(document).ready(function(){
  $('[data-toggle="modal"]').click(function(){
      var target = $(this).data('target');
      $(target).modal('show');
  });
});



//script pour que la div prenne toute la hauteur du conteneur
const parentDivs = document.querySelectorAll('.carte');

function setDimensions() {
  parentDivs.forEach(parentDiv => {
    const childDiv = parentDiv.querySelector('.cardContain');
    const parentHeight = parentDiv.offsetHeight; // récupère la hauteur de la div parent
    childDiv.style.height = `${parentHeight}px`; // défini la hauteur de la div enfant en fonction de la hauteur de la div parent
  });
}

setDimensions(); // appelle la fonction pour définir les dimensions initiales

// écoute les événements de redimensionnement de la fenêtre pour ajuster les dimensions de la div enfant


