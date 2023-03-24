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
  });
});

displayTab(tabButtons[0].getAttribute('data-tab'));

