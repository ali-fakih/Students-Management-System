document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 'auto',
        spaceBetween: 10,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
});

function showPopup() {
    document.getElementById('popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

function addCard() {
    var imageInput = document.getElementById('image');
    var imageFile = imageInput.files[0]; // Get the selected file
    var ID = document.getElementById('id').value;
    var courseTitle = document.getElementById('courseTitle').value;
    var description = document.getElementById('description').value;

    // Check if an image file is selected
    if (imageFile) {
        // Create FormData object and append form fields
        var formData = new FormData();
        formData.append('action', 'add');
        formData.append('image', imageFile);
        formData.append('id', ID);
        formData.append('courseTitle', courseTitle);
        formData.append('description', description);

        // Make an AJAX request to add the new card
        fetch('course-dashboard.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            // Check the response and update the page accordingly
            if (data === 'Add card success') {
                // Create a new card element
                var newCard = document.createElement('div');
                newCard.className = 'eg';
                newCard.dataset.id = ID;

                newCard.innerHTML = `
                    <h4>${courseTitle}</h4>
                    <p>${description}</p>
                    <div class='progress'>
                        <img src='${imageFile.name}' alt='Progress Image'>
                    </div>
                   `;

                // Add click event listener to the new card for selecting
                newCard.addEventListener('click', function () {
                    selectCard(this);
                });

                // Append the new card to the subjects container
                document.getElementById('subjectContainer').appendChild(newCard);

                // Reinitialize the Swiper instance
                var swiper = new Swiper('.swiper-container', {
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                });

                // Close the popup and reset the form fields
                closePopup();
                document.getElementById('cardForm').reset();
            } else {
                console.error('Error:', data);
            }
            closePopup();
        })
        .catch(error => console.error('Error:', error));
    } else {
        alert('Please select an image file.');
    }
}






function createCardElement(ID, image, courseTitle, description) {
    var newCard = document.createElement('div');
    newCard.className = 'eg';
    newCard.dataset.id = studentID; // Set the data-id attribute

    newCard.innerHTML = `
        <h4>${courseTitle}</h4>
        <p>${description}</p>
        <div class='progress'>
        <img src='${image}' alt='Progress Image'>
    </div>
        `;

    return newCard;
}

function showUpdateForm() {
    var selectedCard = document.querySelector('.eg.selected');
    if (selectedCard) {
       document.getElementById('updateImage').value = ''; // Set to empty string
       document.getElementById('updateCourseTitle').value = selectedCard.querySelector('h4').innerText;
       document.getElementById('updateDescription').value = selectedCard.querySelector('p').innerText;
 
       // Display the update form
       document.getElementById('updateForm').style.display = 'block';
    } else {
       alert('Please select a card to update.');
    }
 }
 

function hideUpdateForm() {
    // Hide the update form
    document.getElementById('updateForm').style.display = 'none';
}

function updateCard() {
    var updateImageInput = document.getElementById('updateImage');
    var updateImage = updateImageInput.files[0]; // Get the selected file

    var updateCourseTitle = document.getElementById('updateCourseTitle').value;
    var updateDescription = document.getElementById('updateDescription').value;

    var cardToUpdate = document.querySelector('.eg.selected');

    if (cardToUpdate) {
        // Make an AJAX request to update the card in the database
        var formData = new FormData();
        formData.append('action', 'update');
        formData.append('id', cardToUpdate.dataset.id);
        formData.append('courseTitle', updateCourseTitle);
        formData.append('description', updateDescription);

        if (updateImage) {
            formData.append('image', updateImage);
        }

        fetch('course-dashboard.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);

            // Check the response and update the page accordingly
            if (data === 'Update card success') {
                // Update the content of the selected card
                updateCardElement(cardToUpdate, updateImage, updateCourseTitle, updateDescription);
            } else {
                console.error('Error:', data);
            }

            // Hide the update form
            hideUpdateForm();
        })
        .catch(error => console.error('Error:', error));
    }
}




function updateCardElement(card, updateImage, updateCourseTitle, updateDescription) {
    card.querySelector('.progress img').src = updateImage ? updateImage.name : card.querySelector('.progress img').src;
    card.querySelector('h4').innerText = updateCourseTitle;
    card.querySelector('p').innerText = updateDescription;
}


function selectCard(card) {
    // Deselect any previously selected card
    var selectedCard = document.querySelector('.eg.selected');
    if (selectedCard) {
       selectedCard.classList.remove('selected');
    }
 
    // Select the clicked card
    card.classList.add('selected');
 
    // Populate the update form fields with card data
    document.getElementById('updateImage').value = ''; // Set to empty string
    document.getElementById('updateCourseTitle').value = card.querySelector('h4').innerText;
    document.getElementById('updateDescription').value = card.querySelector('p').innerText;
 }
 

function deleteCard(deleteOverlay) {
    // Find the parent card and remove it
    var cardToDelete = deleteOverlay.parentElement;
    cardToDelete.remove();

    // Make an AJAX request to delete the card
    fetch('course-dashboard.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=delete&id=${cardToDelete.dataset.ID}`,
    })
    .then(response => response.text())
    .then(data => console.log(data))
    .catch(error => console.error('Error:', error));
}

function deleteSelectedCard() {
    // Find the selected card and remove it
    var selectedCard = document.querySelector('.eg.selected');
    if (selectedCard) {
        selectedCard.remove();

        // Make an AJAX request to delete the selected card
        fetch('course-dashboard.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=delete&id=${selectedCard.dataset.ID}`,
        })
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    }
}
