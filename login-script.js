// Function to open the modal
function openModal() {
    document.getElementById("loginModal").style.display = "flex";
}

// Function to close the modal
function closeModal() {
    document.getElementById("loginModal").style.display = "none";
}

// Close modal when clicking outside of the modal content
window.onclick = function(event) {
    const modal = document.getElementById("loginModal");
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Optional: Submit form with basic validation (prevent page reload)
document.getElementById("loginForm").onsubmit = function(event) {
    event.preventDefault(); // Prevent page reload
    const username = document.getElementById("username").value;

    // Store username in local storage to pass data to the next page
    localStorage.setItem("username", username);

    // Redirect to the onboarding page
    window.location.href = "onboard.html";
};
