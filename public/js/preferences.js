document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll(".section");
    const toggleCircles = document.querySelectorAll(".toggle-circle");
    const doneButton = document.getElementById("doneButton");

    let currentSection = 0;

    toggleCircles.forEach((circle, index) => {
        circle.addEventListener("click", () => {
            switchSection(index);
        });
    });

    document.addEventListener("keydown", (event) => {
        if (event.key === "ArrowRight") {
            if (currentSection < sections.length - 1) {
                switchSection(currentSection + 1);
            }
        } else if (event.key === "ArrowLeft") {
            if (currentSection > 0) {
                switchSection(currentSection - 1);
            }
        }
    });

    doneButton.addEventListener("click", () => {
        const likes = Array.from(document.querySelectorAll('#likesSection .card.selected')).map(card => card.getAttribute('data-preference-id'));
        const dislikes = Array.from(document.querySelectorAll('#dislikesSection .card.selected')).map(card => card.getAttribute('data-preference-id'));
        const knows = Array.from(document.querySelectorAll('#knowsSection .card.selected')).map(card => card.getAttribute('data-preference-id'));

        // Print selections to the console
        console.log('Selected Likes:', likes);
        console.log('Selected Dislikes:', dislikes);
        console.log('Selected Knows:', knows);

        if (likes.length < 2 || dislikes.length < 2 || knows.length < 2) {
            let message = '';
            if (likes.length === 0 && dislikes.length === 0 && knows.length === 0) {
                message = 'Please select at least two preferences from each category.';
            } else {
                if (likes.length < 2) message += 'Select at least two likes. ';
                if (dislikes.length < 2) message += 'Select at least two dislikes. ';
                if (knows.length < 2) message += 'Select at least two knows. ';
            }
            // Redirect to the same page with feedback message in URL
            window.location.href = `preferences.php?msg=${encodeURIComponent(message)}`;
            return;
        }

        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '../actions/preferences.php'; // The PHP file handling the submission

        const inputLikes = document.createElement('input');
        inputLikes.type = 'hidden';
        inputLikes.name = 'likes';
        inputLikes.value = likes.join(',');
        form.appendChild(inputLikes);

        const inputDislikes = document.createElement('input');
        inputDislikes.type = 'hidden';
        inputDislikes.name = 'dislikes';
        inputDislikes.value = dislikes.join(',');
        form.appendChild(inputDislikes);

        const inputKnows = document.createElement('input');
        inputKnows.type = 'hidden';
        inputKnows.name = 'knows';
        inputKnows.value = knows.join(',');
        form.appendChild(inputKnows);

        document.body.appendChild(form);
        form.submit();
    });

    function switchSection(index) {
        sections[currentSection].classList.remove("active");
        toggleCircles[currentSection].classList.remove("active");

        currentSection = index;

        sections[currentSection].classList.add("active");
        toggleCircles[currentSection].classList.add("active");

        if (currentSection === toggleCircles.length - 1) {
            doneButton.classList.remove("hidden");
        } else {
            doneButton.classList.add("hidden");
        }
    }

    // Initialize the first section as active
    switchSection(currentSection);
});

function toggleSelection(card) {
    card.classList.toggle("selected");
}
