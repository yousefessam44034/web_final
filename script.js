document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Handle registration logic
    console.log('Registration form submitted');
});

const addFlightBtn = document.getElementById('addFlightBtn');
const registerBtn = document.querySelector('.register'); // Using a class selector for the register button

addFlightBtn.addEventListener('click', () => {
    // Your logic here, if any, when the button is clicked
    // This code toggles a 'clicked' class on the button when clicked
    addFlightBtn.classList.toggle('clicked');
});

// Adding animation to the register button when clicked
registerBtn.addEventListener('click', () => {
    // Apply your animation logic here
    // For example, adding a CSS class to trigger the animation
    registerBtn.classList.add('register-animation'); // Create a CSS class for your animation
});
