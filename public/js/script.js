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

//ajoute un évenement au clique sur chaque boutons des onglets

tabButtons.forEach((tabButton) => {
  tabButton.addEventListener('click', (event) => {
    const tabIndex = event.target.getAttribute('data-tab');
    displayTabPlayDeck(tabIndex);
    displayBtnsPlay();
    // setDimensions();
  });
});

displayTabPlayDeck(tabButtons[0].getAttribute('data-tab'));


function displayBtnsPlay(){

  var activeCard = document.querySelector('.tab-content.active .card');

  var zonePlayButtons = document.getElementById('zone-play-btns');

  if(activeCard){
    zonePlayButtons.style.display = 'block';
  }else{
    zonePlayButtons.style.display = 'none';
  }

}

displayBtnsPlay()




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

  switchBtnSeeResponseWhithBtnsSelectResponse();

  // $.ajax({
  //   url: window.location.href,
  //   type: "GET",
  //   success: function(response) {
  //     var nouveauContenu = $(response).find("#add-position-btn");
  //     $("#add-position-btn").replaceWith(nouveauContenu);
  //   }
  // });

}


function switchBtnSeeResponseWhithBtnsSelectResponse(){
  var responseButtons = document.querySelector('#btns-response');
  var seeResponseButton = document.querySelector('#btn-see-response');
  
  responseButtons.classList.toggle('active');
  seeResponseButton.classList.toggle('active');
}



function range(tabIndex) {


  var dataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

  var card = document.querySelector("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] .card-container");

  var tab = document.querySelector("#play-deck-zone .tab-button[data-tab='"+tabIndex+"']");
  

  var positionCard = card.getBoundingClientRect();
  var positionTab = tab.getBoundingClientRect();


  let currentPos = {
    x: positionCard.left + positionCard.width/2,
    y: positionCard.top + positionCard.height/2
  };


  let finalPos = {
    x: positionTab.left + positionTab.width/2, // position horizontale souhaitée
    y: positionTab.top + positionTab.height/2 // position verticale souhaitée
  };

  card.style.transform = "translate("+(finalPos.x-currentPos.x)+"px,"+(finalPos.y-currentPos.y)+"px)"+ " scale(0)";



  switchBtnSeeResponseWhithBtnsSelectResponse();

  // $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *");

}



function addPositionCarte(tabIndex, position) {

  var actualIdCarte = $("#play-deck-zone .tab-content.active .card-container").attr('id-carte');
  var actualDataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

// alert(actualCard)

    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/ajouter_position_carte/${actualIdCarte}/${position}`);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if(xhr.status === 200 && JSON.parse(xhr.responseText).success) {
            console.log('PositionCarte ajoutée');



            var dataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

            $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *", function() {
              // action à lancer après le rechargement du bouton
              displayBtnsPlay();
            });

            $("#play-deck-zone .tab-content[data-tab='"+tabIndex+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+tabIndex+"'] > *");


          if(dataTabValue != tabIndex){
            var spanNbrCarteCurrentTab = document.querySelector("#play-deck-zone .tab-button[data-tab='"+dataTabValue+"'] .nbr-carte");
            var spanNbrCarteDestinationTab = document.querySelector("#play-deck-zone .tab-button[data-tab='"+tabIndex+"'] .nbr-carte");

            var newTextNbrCarteCurrentTab = parseInt(spanNbrCarteCurrentTab.textContent) - 1;
            var newTextNbrCarteDestinationTab = parseInt(spanNbrCarteDestinationTab.textContent) + 1;

            spanNbrCarteCurrentTab.innerHTML = newTextNbrCarteCurrentTab;
            spanNbrCarteDestinationTab.innerHTML = newTextNbrCarteDestinationTab;
          }




            // alert("Nombre de carte dans l'onglet actif : "+dataTab.innerHTML);



            // $.ajax({
            //   url: window.location.href,
            //   type: "GET",
            //   success: function(response) {
            //     var nouveauContenu = $(response).find("#play-deck-zone .tab-button[data-tab='"+tabIndex+"']");
            //     $("#play-deck-zone .tab-button[data-tab='"+tabIndex+"']").replaceWith(nouveauContenu);
            //   }
            // });

            // $("#play-deck-zone .tab-button[data-tab='"+tabIndex+"']").load(window.location.href + "#play-deck-zone .tab-button[data-tab='"+tabIndex+"'] > *");

        } else {
            console.error('Une erreur est survenue');
        }
    };
    xhr.send();


}




var toggle = true;

// Recharge une carte au hasard lorsque l'utilisateur clique sur le bouton
$(document).ready(function() {
  $("#btn-shuffle").click(function() {

    var dataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

    var card = $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] .card-container");


    if(toggle){
      toggle = false;
      card.addClass("translate-effect-right");
      card.removeClass("translate-effect-left");
    }else{
      toggle = true;
      card.addClass("translate-effect-left");
      card.removeClass("translate-effect-right");
    }

    switchBtnSeeResponseWhithBtnsSelectResponse();


    $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *");

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
    const deckId = addFavoriBtn.dataset.deckId;
    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/ajouter_favori/${deckId}`);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if(xhr.status === 200 && JSON.parse(xhr.responseText).success) {
            console.log('Deck ajoutée aux favoris');

            $("#select-deck-zone .tab-content[data-tab='tab2']").load(window.location.href + " #select-deck-zone .tab-content[data-tab='tab2']");

        } else {
            console.error('Une erreur est survenue');
        }
    };
    xhr.send();
});


// $('#ajouter-favori-btn').click(function(e) {
//   e.preventDefault();
//   const deckId = $(this).data('deck-id');
//   $.ajax({
//       type: 'POST',
//       url: '/ajouter_favori/' + deckId,
//       dataType: 'json',
//       success: function(data) {
//           if (data.success) {
//               console.log('Deck ajoutée aux favoris');
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


// const addPositionBtn = document.querySelector('#add-position-btn');
// addPositionBtn.addEventListener('click', (e) => {
//     e.preventDefault();
//     const carteId = addPositionBtn.dataset.carteId;
//     const position = addPositionBtn.dataset.positionId;
//     const xhr = new XMLHttpRequest();
//     xhr.open('POST', `/ajouter_position_carte/${carteId}/${position}`);
//     xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
//     xhr.onload = function() {
//         if(xhr.status === 200 && JSON.parse(xhr.responseText).success) {
//             console.log('PositionCarte ajoutée');


//             $("#select-deck-zone .tab-content[data-tab='tab2']").load(window.location.href + " #select-deck-zone .tab-content[data-tab='tab2'] > *");

//         } else {
//             console.error('Une erreur est survenue');
//         }
//     };
//     xhr.send();
// });
