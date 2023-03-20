const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.tab-content');

function displayTab(tabIndex) {
  tabContents.forEach((tabContent) => {
    tabContent.classList.remove('active');
    if (tabContent.getAttribute('data-tab') === tabIndex) {
      tabContent.classList.add('active');
    }
  });

  tabButtons.forEach((tabButton) => {
    tabButton.classList.remove('active');
    if (tabButton.getAttribute('data-tab') === tabIndex) {
      tabButton.classList.add('active');
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

