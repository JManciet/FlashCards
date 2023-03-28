const tabButtons = document.querySelectorAll('#play-deck-zone .tab-button');
const textTabButtons = document.querySelectorAll('#play-deck-zone .tab-button>span');
const tabContents = document.querySelectorAll('#play-deck-zone .tab-content');

const containerTabContents = document.querySelector('#play-deck-zone .container-tab-contents');

function displayTabPlayDeck(tabIndex) {

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
    displayTabPlayDeck(tabIndex);
    // setDimensions();
  });
});

displayTabPlayDeck(tabButtons[0].getAttribute('data-tab'));









const selectDeckTabButtons = document.querySelectorAll('#select-deck-zone .tab-button');
const selectDeckTabContents = document.querySelectorAll('#select-deck-zone .tab-content');


function displayTabSelectDeck(tabIndex) {

  selectDeckTabContents.forEach((selectDeckTabContent) => {
    selectDeckTabContent.classList.remove('active');
    if (selectDeckTabContent.getAttribute('data-tab') === tabIndex) {
      selectDeckTabContent.classList.add('active');
    }
  });

  selectDeckTabButtons.forEach((selectDeckTabButton) => {
    selectDeckTabButton.classList.remove('active');
    selectDeckTabButton.style.backgroundColor = 'grey';
    if (selectDeckTabButton.getAttribute('data-tab') === tabIndex) {
      selectDeckTabButton.classList.add('active');
      selectDeckTabButton.style.backgroundColor = 'red';
    }
  });

}

selectDeckTabButtons.forEach((selectDeckTabButton) => {
  selectDeckTabButton.addEventListener('click', (event) => {
    const tabIndex = event.target.getAttribute('data-tab');
    displayTabSelectDeck(tabIndex);
    // setDimensions();
  });
});

displayTabSelectDeck(selectDeckTabButtons[0].getAttribute('data-tab'));













$(document).ready(function(){
  $('[data-toggle="modal"]').click(function(){
      var target = $(this).data('target');
      $(target).modal('show');
  });
});



// //script pour que la div prenne toute la hauteur du conteneur
// const parentDivs = document.querySelectorAll('.carte');

// function setDimensions() {
//   parentDivs.forEach(parentDiv => {
//     const childDiv = parentDiv.querySelector('.cardContain');
//     const parentHeight = parentDiv.offsetHeight; // récupère la hauteur de la div parent


//     childDiv.style.height = `${parentHeight}px`; // défini la hauteur de la div enfant en fonction de la hauteur de la div parent
    
//   });
// }

// setDimensions(); // appelle la fonction pour définir les dimensions initiales



// const responseButton = document.querySelector('#buttonResponse');
// const question = document.querySelector('.tab-content.active .question');
// const response = document.querySelector('.tab-content.active .response');


// // Initialiser l'état de l'élément à "caché"
// let isHidden = true;

// responseButton.addEventListener('click', (event) => {
  
//   toggleResponse();
//   // setDimensions();
// });

// function  toggleResponse() {

//   // Inverser l'état de l'élément
//   isHidden = !isHidden;

//   // Mettre à jour l'affichage de l'élément en fonction de son état
//   if (isHidden) {
//     question.style.display = 'block';
//     response.style.display = 'none';
//   } else {
//     question.style.display = 'none';
//     response.style.display = 'block';
//   }
  
//     // question.classList.remove('active');
//     // response.classList.add('active');

// }




function flip() {
  var flipBox = document.querySelector('.tab-content.active .card');
  flipBox.classList.toggle('flipped');
}


var toggle = true;
// Recharge la carte de la page lorsque l'utilisateur clique sur le bouton
$(document).ready(function() {
  $("#btn-shuffle").click(function() {

    var dataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

    var tabContent = $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']");


    if(toggle){
      toggle = false;
      tabContent.addClass("translate-effect-right");
      tabContent.removeClass("translate-effect-left");
    }else{
      toggle = true;
      tabContent.addClass("translate-effect-left");
      tabContent.removeClass("translate-effect-right");
    }



    $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + "#play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *");

  });


});



// $.ajax({
//   url: "votre-url",
//   success: function(data) {
//     // Insérez ici le code pour remplacer le contenu de votre élément avec les données AJAX reçues
//     // Ajoutez ensuite la classe CSS "translate-effect" à l'élément pour déclencher l'animation
//     $("#votre-element-cible").addClass("translate-effect");
//   }
// });


const addFavoriBtn = document.querySelector('#add-favori-btn');
addFavoriBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const recetteId = addFavoriBtn.dataset.recetteId;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/ajouter_favori/${recetteId}`);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if(xhr.status === 200 && JSON.parse(xhr.responseText).success) {
            console.log('Recette ajoutée aux favoris');


            $("#select-deck-zone .tab-content[data-tab='tab2']").load(window.location.href + "#select-deck-zone .tab-content[data-tab='tab2'] > *");

        } else {
            console.error('Une erreur est survenue');
        }
    };
    xhr.send();
});


// $('#ajouter-favori-btn').click(function(e) {
//   e.preventDefault();
//   const recetteId = $(this).data('recette-id');
//   $.ajax({
//       type: 'POST',
//       url: '/ajouter_favori/' + recetteId,
//       dataType: 'json',
//       success: function(data) {
//           if (data.success) {
//               console.log('Recette ajoutée aux favoris');
//               // Recharger la partie de la page HTML
//               $('#select-deck-zone').load(window.location.href + ' #select-deck-zone >*');
//           } else {
//               console.error('Une erreur est survenue1');
//           }
//       },
//       error: function(xhr, status, error) {
//           console.error('Une erreur est survenue2');

//           $("#select-deck-zone .tab-content[data-tab='tab2']").load(window.location.href + "#select-deck-zone .tab-content[data-tab='tab2'] > *");
//       }
//   });
// });
