
document.addEventListener('DOMContentLoaded', function () {
    // Select all cards and toggle buttons
    let cards = document.querySelectorAll('.card');

    // Loop through each card and add click event listener
    cards.forEach((card) => {
        let toggle = card.querySelector('.toggle');

        toggle.onclick = function () {
            // Toggle the 'open' class for the clicked card
            card.classList.toggle('open');
        };
    });
});



 // <!-- function for add,delete,and update buttons  -->

function addCard() {
    // Create a new card element
    var card = document.createElement("div");
    card.className = "card";

    // Create card content
    var contentBx = document.createElement("div");
    contentBx.className = "contentBx";

    var contentCard = document.createElement("div");
    contentCard.className = "content-card";

    var h3 = document.createElement("h3");
    h3.textContent = "Computer Science";
    
    var span = document.createElement("span");
    span.textContent = "Computer Engineering";

    var imgBx = document.createElement("div");
    imgBx.className = "imgBx";

    var img = document.createElement("img");
    img.src = "./images/teacher.jpg";
    img.alt = "card";

    var buttonContainer = document.createElement("div");
    buttonContainer.className = "button-container";

    var updateButton = document.createElement("button");
    updateButton.textContent = "Update";
    updateButton.onclick = function() {
        updateCard(card);
    };

    var deleteButton = document.createElement("button");
    deleteButton.textContent = "Delete";
    deleteButton.onclick = function() {
        deleteCard(card);
    };

    // Append elements to the card
    imgBx.appendChild(img);
    buttonContainer.appendChild(updateButton);
    buttonContainer.appendChild(deleteButton);

    contentCard.appendChild(h3);
    contentCard.appendChild(span);
    contentCard.appendChild(imgBx);
    contentCard.appendChild(buttonContainer);

    contentBx.appendChild(contentCard);

    card.appendChild(contentBx);

    // Toggle button
    var toggle = document.createElement("div");
    toggle.className = "toggle";

    var spanToggle = document.createElement("span");

    toggle.appendChild(spanToggle);
    card.appendChild(toggle);

    // Append the card to the card container
    var cardContainer = document.getElementById("cardContainer");
    cardContainer.appendChild(card);
}

function deleteCard(card) {
    // Remove the card from the document
    var cardContainer = document.getElementById("cardContainer");
    cardContainer.removeChild(card);
}

function updateCard(card) {
    // Example: Update the content of the card
    var h3 = card.querySelector('.content-card h3');
    var span = card.querySelector('.content-card span');

    h3.textContent = "New Course";
    span.textContent = "Updated Course Details";
}
