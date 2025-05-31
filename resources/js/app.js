// Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.min.css';

// Import Bootstrap JS
import 'bootstrap';

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'

// Make it available globally
window.bootstrap = bootstrap;

// Initialize Bootstrap components
document.addEventListener('DOMContentLoaded', function() {
    // Enable dropdowns
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(dropdown => {
        new bootstrap.Dropdown(dropdown, {
            autoClose: true
        });
    });

    // Enable navbar toggler
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('#navbarNav');
    if (navbarToggler && navbarCollapse) {
        new bootstrap.Collapse(navbarCollapse, {
            toggle: false
        });
    }

    // Enable tooltips
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });

    // Enable alerts
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        new bootstrap.Alert(alert);
    });
});

// Import custom styles
import '../css/app.css';

// Import main application logic if needed
// import './main.js'; 