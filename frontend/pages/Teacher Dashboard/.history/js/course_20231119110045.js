dChild(contentBx);

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
</script>
