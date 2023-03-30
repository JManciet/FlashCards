const selectPositionTabButtons = document.querySelectorAll('#play-deck-zone .tab-button');
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

  selectPositionTabButtons.forEach((selectPositionTabButton) => {
    selectPositionTabButton.classList.remove('active');
    if (selectPositionTabButton.getAttribute('data-tab') === tabIndex) {
      selectPositionTabButton.classList.add('active');
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

selectPositionTabButtons.forEach((selectPositionTabButton) => {
  selectPositionTabButton.addEventListener('click', (event) => {
    const tabIndex = event.target.getAttribute('data-tab');
    displayTabPlayDeck(tabIndex);
    displayBtnsPlay();
    switchSeeResponseWithBtnsSelectResponse();
    // setDimensions();
  });
});

displayTabPlayDeck(selectPositionTabButtons[0].getAttribute('data-tab'));


function switchSeeResponseWithBtnsSelectResponse(){

  var activeResponse = document.querySelector('.tab-content.active .card.flipped');

  if(activeResponse){
    BtnSeeResponseInFrontBtnsSelectResponse(false);
  }else{
    BtnSeeResponseInFrontBtnsSelectResponse(true);
  }
}

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


function displaySeeResponseButton(displayStyle){

  var seeResponseButton = document.getElementById('btn-see-response');

  seeResponseButton.style.display = displayStyle;
  
}

function displayResponseButtons(displayStyle){

  var responseButtons = document.querySelector('#btns-response');

  responseButtons.style.display = displayStyle;
  
}

function displaySpinner(displayStyle){

  var spinner = document.querySelector(".spinner-border");

  spinner.style.display = displayStyle;
}

displaySpinner('none');


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

  BtnSeeResponseInFrontBtnsSelectResponse(false);

  // $.ajax({
  //   url: window.location.href,
  //   type: "GET",
  //   success: function(response) {
  //     var nouveauContenu = $(response).find("#add-position-btn");
  //     $("#add-position-btn").replaceWith(nouveauContenu);
  //   }
  // });

}

function BtnSeeResponseInFrontBtnsSelectResponse(inFront){

  if(inFront){
    displaySeeResponseButton('inline-block');
    displayResponseButtons('none');
  }else{
    displaySeeResponseButton('none');
    displayResponseButtons('block');
  }
}



function animationCardInTab(tabIndex) {


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



  // BtnSeeResponseInFrontBtnsSelectResponse(false);

  // $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *");

}



function addPositionCarte(tabIndex, position) {


  BtnSeeResponseInFrontBtnsSelectResponse(false);

  displayResponseButtons('none');

  displaySpinner('inline-block');

  var actualIdCarte = $("#play-deck-zone .tab-content.active .card-container").attr('id-carte');
  var actualDataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

// alert(actualCard)

  // displaySeeResponseButton('none');
  

    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/ajouter_position_carte/${actualIdCarte}/${position}`);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if(xhr.status === 200 && JSON.parse(xhr.responseText).success) {
            console.log('PositionCarte ajoutée');

            animationCardInTab(tabIndex);

            var dataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

            //mise à jour de la carte dans l'onglet d'origine
            $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *", function() {
              // action à lancer après le rechargement du bouton
              displayBtnsPlay();
              BtnSeeResponseInFrontBtnsSelectResponse(true);
              displaySpinner('none');
            });

            //mise à jour de la carte dans l'onglet de destination
            $("#play-deck-zone .tab-content[data-tab='"+tabIndex+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+tabIndex+"'] > *");

          //mise à jour du nombre de cartes dans les onglets
          if(dataTabValue != tabIndex){
            var spanNbrCarteCurrentTab = document.querySelector("#play-deck-zone .tab-button[data-tab='"+dataTabValue+"'] .nbr-carte");
            var spanNbrCarteDestinationTab = document.querySelector("#play-deck-zone .tab-button[data-tab='"+tabIndex+"'] .nbr-carte");

            var newTextNbrCarteCurrentTab = parseInt(spanNbrCarteCurrentTab.textContent) - 1;
            var newTextNbrCarteDestinationTab = parseInt(spanNbrCarteDestinationTab.textContent) + 1;

            spanNbrCarteCurrentTab.innerHTML = newTextNbrCarteCurrentTab;
            spanNbrCarteDestinationTab.innerHTML = newTextNbrCarteDestinationTab;
          }


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

    displayResponseButtons('none');
    displaySeeResponseButton('none');

    displaySpinner('inline-block');

    var dataTabValue = $("#play-deck-zone .tab-content.active").attr('data-tab');

    var card = $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] .card-container");

    var flipBox = document.querySelector('.tab-content.active .card');
    

    //Ici on lance une animation de la carte couplé avec du css
    if(toggle){
      toggle = false;
      card.addClass("translate-effect-right");
      card.removeClass("translate-effect-left");
      flipBox.classList.toggle('flipped');
    }else{
      toggle = true;
      card.addClass("translate-effect-left");
      card.removeClass("translate-effect-right");
      flipBox.classList.toggle('flipped');
    }

    // BtnSeeResponseInFrontBtnsSelectResponse(true);


    $("#play-deck-zone .tab-content[data-tab='"+dataTabValue+"']").load(location.href + " #play-deck-zone .tab-content[data-tab='"+dataTabValue+"'] > *", function() {
      // actions à lancer après le rechargement de la carte
      // displayBtnsPlay();
      BtnSeeResponseInFrontBtnsSelectResponse(true);
      displaySpinner('none');
    });

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


const addFavoriIcons = document.querySelectorAll('.add-favori');





selectPositionTabButtons.forEach((selectPositionTabButton) => {
  selectPositionTabButton.addEventListener('click', (event) => {
    const tabIndex = event.target.getAttribute('data-tab');
    displayTabPlayDeck(tabIndex);
    displayBtnsPlay();
    switchSeeResponseWithBtnsSelectResponse();
    // setDimensions();
  });
});




addFavoriIcons.forEach((addFavoriIcon) => {
  addFavoriIcon.addEventListener('click', (e) => {

    e.preventDefault();

    $(e.target).addClass('fa-beat-fade');

    // const deckId = $(this).data('deck-id');
    // const isFavori = $(this).data('is-favori');

    const deckId = e.target.dataset.deckId;
    const isFavori = e.target.dataset.isFavori;


    const xhr = new XMLHttpRequest();
    xhr.open('POST', `/ajouter_favori/${deckId}`);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if(xhr.status === 200 && JSON.parse(xhr.responseText).success) {

            if (isFavori == 0) {

              console.log('Deck ajouté aux favoris');

              // $(e.target).data('is-favori', true);
              $(e.target).attr('data-is-favori', 1);

              $(e.target).removeClass('fa-beat-fade').removeClass('fa-heart-circle-plus');
              $(e.target).addClass('fa-heart').addClass('red');

            } else {

              console.log('Deck supprimé des favoris');

              // $(e.target).data('is-favori', false);
              $(e.target).attr('data-is-favori', 0);

              $(e.target).removeClass('fa-beat-fade').removeClass('fa-heart').removeClass('red');
              $(e.target).addClass('fa-heart-circle-plus')
            }

            $("#select-deck-zone .tab-content[data-tab='tab2']").load(window.location.href + " #select-deck-zone .tab-content[data-tab='tab2']");

        } else {

          $(e.target).removeClass('fa-beat-fade');

            console.error('Une erreur est survenue');
        }
    };
    xhr.send();
  });
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
