// Asesor specific JavaScript functionality
// This file contains JavaScript code specific to asesor (assessor) functionality
// Separated from app.js to avoid conflicts with global authentication and navigation

import flowbite from "flowbite";

// Initialize Flowbite components for asesor pages
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Flowbite
    flowbite.initFlowbite();

    // Asesor specific functionality can be added here
    console.log("Asesor JS loaded");
});

// Export for global access if needed
window.AsesorJS = {
    initialized: true,
    version: "1.0.0",
};
