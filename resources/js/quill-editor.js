// Quill Editor specific functionality
// This file is separated from app.js to avoid conflicts with global authentication

// Import Quill.js
import Quill from "quill";
import "quill/dist/quill.snow.css";

// Make Quill globally available
window.Quill = Quill;

// Quill Editor Manager
class QuillEditorManager {
    constructor() {
        this.initializeQuillEditors();
    }

    initializeQuillEditors() {
        // Find all elements with class 'quill-editor'
        const quillContainers = document.querySelectorAll(".quill-editor");

        quillContainers.forEach((container, index) => {
            const editorId = container.id || `quill-editor-${index}`;

            // Configure Quill with custom fonts and sizes
            const quill = new Quill(`#${editorId}`, {
                theme: "snow",
                modules: {
                    toolbar: [
                        [
                            {
                                font: [
                                    "arial",
                                    "georgia",
                                    "times",
                                    "helvetica",
                                    "verdana",
                                    "comic",
                                    "impact",
                                    "monospace",
                                ],
                            },
                        ],
                        [{ header: [1, 2, 3, 4, 5, 6, false] }],
                        [{ size: ["small", false, "large", "huge"] }],
                        ["bold", "italic", "underline", "strike"],
                        [{ color: [] }, { background: [] }],
                        [{ script: "sub" }, { script: "super" }],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ indent: "-1" }, { indent: "+1" }],
                        [{ direction: "rtl" }],
                        [{ align: [] }],
                        ["link", "image", "video"],
                        ["clean"],
                    ],
                },
            });

            // Store quill instance for later access
            container.quillInstance = quill;
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
    // Initialize quill editor manager
    const quillManager = new QuillEditorManager();

    // Make it globally available for debugging
    window.quillManager = quillManager;
});
