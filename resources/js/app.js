import "./bootstrap";
import "flowbite";
import "flowbite-datepicker";

// Active State Management
class ActiveStateManager {
    constructor() {
        this.routeMap = {
            "/": "home-visitor",
            "/panduan": "panduan",
            "/skema": "skema",
            "/user/home": "home",
            "/user/persetujuan/ttd": "user.persetujuan.index",
            "/asesi/home": "home-asesi",
            "/asesi": "asesi.index",
            "/asesi/apl2": "asesi.asesmen.mandiri",
            "/asesi/aksi": "asesi.pilih-aksi",
            "/asesi/persetujuan": "asesi.persetujuan",
            "/asesi/fr/ak1": "asesi.fr.ak1",
            "/asesi/fr/ak3": "asesi.fr.ak3",
            "/asesi/fr/ia2": "asesi.fr.ia2",
            "/asesi/jadwal-uji-kompetensi": "asesi.jadwal-uji-kompetensi",
            "/asesi/konsul-prauji": "asesi.konsul-prauji",
        };
    }

    updateActiveStates() {
        const currentPath = window.location.pathname;
        const currentRoute =
            this.routeMap[currentPath] || this.getRouteFromPath(currentPath);

        // Update desktop navigation
        this.updateNavLinks(".nav-link", currentRoute);

        // Update mobile navigation
        this.updateNavLinks(".mobile-nav-link", currentRoute);
    }

    updateNavLinks(selector, currentRoute) {
        const navLinks = document.querySelectorAll(selector);

        navLinks.forEach((link) => {
            const href = link.getAttribute("href");
            if (!href) return;

            // Remove existing active classes
            link.classList.remove("nav-link-active", "mobile-nav-link-active");

            // Check if this link matches the current route
            if (this.isLinkActive(href, currentRoute)) {
                link.classList.add("nav-link-active", "mobile-nav-link-active");
            }
        });
    }

    isLinkActive(href, currentRoute) {
        try {
            const url = new URL(href, window.location.origin);
            const path = url.pathname;

            // Direct path matching
            if (path === window.location.pathname) {
                return true;
            }

            // Route name matching (for Laravel routes)
            const routeName = this.getRouteNameFromHref(href);
            if (routeName && routeName === currentRoute) {
                return true;
            }

            return false;
        } catch (error) {
            console.warn("Error checking link active state:", error);
            return false;
        }
    }

    getRouteFromPath(path) {
        // Map common paths to route names
        if (path === "/") return "home-visitor";
        if (path === "/panduan") return "panduan";
        if (path === "/skema") return "skema";
        if (path === "/user/home") return "home";
        if (path === "/user/persetujuan/ttd") return "user.persetujuan.index";
        if (path === "/asesi/home") return "home-asesi";
        if (path === "/asesi") return "asesi.index";
        if (path === "/asesi/apl2") return "asesi.asesmen.mandiri";
        if (path === "/asesi/aksi") return "asesi.pilih-aksi";
        if (path === "/asesi/persetujuan") return "asesi.persetujuan";
        if (path === "/asesi/fr/ak1") return "asesi.fr.ak1";
        if (path === "/asesi/fr/ak3") return "asesi.fr.ak3";
        if (path === "/asesi/fr/ia2") return "asesi.fr.ia2";
        if (path === "/asesi/jadwal-uji-kompetensi")
            return "asesi.jadwal-uji-kompetensi";
        if (path === "/asesi/konsul-prauji") return "asesi.konsul-prauji";

        // Default fallback
        return path;
    }

    getRouteNameFromHref(href) {
        // Extract route name from Laravel route helper URLs
        // This is a simplified approach - in a real app you might want to pass route names via data attributes
        const url = new URL(href, window.location.origin);
        const path = url.pathname;

        return this.getRouteFromPath(path);
    }
}

// Page Transition Management
class PageTransitionManager {
    constructor() {
        this.isTransitioning = false;
        this.activeStateManager = new ActiveStateManager();
        this.init();
    }

    init() {
        // Add transition class to main content
        const mainContent = document.querySelector("main");
        if (mainContent) {
            mainContent.classList.add("page-transition", "page-transition-in");
        }

        // Intercept all internal links
        document.addEventListener("click", (e) => {
            const link = e.target.closest("a");
            if (link && this.shouldIntercept(link)) {
                e.preventDefault();
                this.navigateTo(link.href);
            }
        });

        // Handle browser back/forward
        window.addEventListener("popstate", (e) => {
            if (e.state && e.state.url) {
                this.loadPage(e.state.url, false);
            }
        });
    }

    shouldIntercept(link) {
        // Only intercept internal links that aren't already handled by other scripts
        const url = new URL(link.href);
        const currentUrl = new URL(window.location.href);

        return (
            url.origin === currentUrl.origin &&
            !link.hasAttribute("data-no-transition") &&
            !link.target &&
            !link.hasAttribute("download") &&
            !link.href.includes("#") &&
            !link.classList.contains("no-transition")
        );
    }

    async navigateTo(url) {
        if (this.isTransitioning) return;

        this.isTransitioning = true;

        try {
            // Start exit transition
            await this.exitTransition();

            // Load new page
            await this.loadPage(url, true);

            // Start enter transition
            await this.enterTransition();
        } catch (error) {
            console.error("Page transition error:", error);
            // Fallback to normal navigation
            window.location.href = url;
        } finally {
            this.isTransitioning = false;
        }
    }

    async exitTransition() {
        const mainContent = document.querySelector("main");
        if (!mainContent) return;

        return new Promise((resolve) => {
            mainContent.classList.add("page-transition-out");
            mainContent.classList.remove("page-transition-in");

            setTimeout(resolve, 175); // Half of 350ms
        });
    }

    async enterTransition() {
        const mainContent = document.querySelector("main");
        if (!mainContent) return;

        return new Promise((resolve) => {
            mainContent.classList.add("page-transition-enter");

            // Force reflow
            mainContent.offsetHeight;

            mainContent.classList.remove(
                "page-transition-out",
                "page-transition-enter"
            );
            mainContent.classList.add("page-transition-in");

            setTimeout(resolve, 175); // Half of 350ms
        });
    }

    async loadPage(url, updateHistory = true) {
        try {
            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            // Extract main content
            const newMain = doc.querySelector("main");
            const currentMain = document.querySelector("main");

            if (newMain && currentMain) {
                // Update title
                const newTitle = doc.querySelector("title");
                if (newTitle) {
                    document.title = newTitle.textContent;
                }

                // Update main content
                currentMain.innerHTML = newMain.innerHTML;

                // Update URL and history
                if (updateHistory) {
                    window.history.pushState({ url }, "", url);
                }

                // Reinitialize any necessary scripts
                this.reinitializeScripts();

                // Update navbar active states
                this.activeStateManager.updateActiveStates();
            } else {
                throw new Error("Could not find main content");
            }
        } catch (error) {
            console.error("Failed to load page:", error);
            throw error;
        }
    }

    reinitializeScripts() {
        // Reinitialize scroll animations
        this.initScrollAnimations();

        // Reinitialize any Alpine.js components
        if (window.Alpine) {
            window.Alpine.initTree(document.body);
        }

        // Dispatch custom event for other scripts
        window.dispatchEvent(new CustomEvent("page-transition-complete"));
    }

    initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px",
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("animate");
                }
            });
        }, observerOptions);

        // Observe all elements with animate-on-scroll class
        const animatedElements =
            document.querySelectorAll(".animate-on-scroll");
        animatedElements.forEach((el) => observer.observe(el));
    }
}

// Footer Newsletter Handler
class FooterNewsletterHandler {
    constructor() {
        this.init();
    }

    init() {
        // Handle newsletter form submission
        document.addEventListener("submit", (e) => {
            if (e.target.id === "newsletter-form") {
                e.preventDefault();
                this.handleNewsletterSubmit(e.target);
            }
        });

        // Add keyboard navigation for social media links
        this.initSocialMediaAccessibility();
    }

    async handleNewsletterSubmit(form) {
        const emailInput = form.querySelector("#newsletter-email");
        const submitButton = form.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;

        if (!emailInput.value) {
            this.showMessage("Mohon masukkan alamat email Anda.", "error");
            return;
        }

        if (!this.isValidEmail(emailInput.value)) {
            this.showMessage(
                "Mohon masukkan alamat email yang valid.",
                "error"
            );
            return;
        }

        // Disable form during submission
        submitButton.disabled = true;
        submitButton.textContent = "Mengirim...";

        try {
            // Simulate API call - replace with actual endpoint
            await this.submitNewsletter(emailInput.value);

            this.showMessage(
                "Terima kasih! Anda telah berhasil berlangganan newsletter kami.",
                "success"
            );
            emailInput.value = "";
        } catch (error) {
            this.showMessage(
                "Maaf, terjadi kesalahan. Silakan coba lagi.",
                "error"
            );
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = originalText;
        }
    }

    async submitNewsletter(email) {
        // Simulate API call - replace with actual implementation
        return new Promise((resolve) => {
            setTimeout(() => {
                console.log("Newsletter subscription:", email);
                resolve();
            }, 1000);
        });
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    showMessage(message, type) {
        // Create or update message element
        let messageEl = document.getElementById("newsletter-message");
        if (!messageEl) {
            messageEl = document.createElement("div");
            messageEl.id = "newsletter-message";
            messageEl.className = "mt-3 p-3 rounded-lg text-sm font-inter";
            const form = document.getElementById("newsletter-form");
            if (form) {
                form.appendChild(messageEl);
            }
        }

        messageEl.textContent = message;
        messageEl.className = `mt-3 p-3 rounded-lg text-sm font-inter ${
            type === "success"
                ? "bg-green-100 text-green-700"
                : "bg-red-100 text-red-700"
        }`;

        // Auto-hide after 5 seconds
        setTimeout(() => {
            if (messageEl) {
                messageEl.remove();
            }
        }, 5000);
    }

    initSocialMediaAccessibility() {
        // Add aria-labels to social media links
        const socialLinks = document.querySelectorAll(".footer-social-link");
        socialLinks.forEach((link) => {
            const icon = link.querySelector("svg");
            if (icon) {
                const platform = this.getSocialPlatform(link.href);
                link.setAttribute("aria-label", `Ikuti kami di ${platform}`);
            }
        });
    }

    getSocialPlatform(url) {
        if (url.includes("instagram")) return "Instagram";
        if (url.includes("youtube")) return "YouTube";
        if (url.includes("facebook")) return "Facebook";
        if (url.includes("twitter")) return "Twitter";
        if (url.includes("linkedin")) return "LinkedIn";
        if (url.includes("tiktok")) return "TikTok";
        return "Social Media";
    }
}

// Intersection Observer for scroll animations
document.addEventListener("DOMContentLoaded", function () {
    // Initialize page transitions
    const pageTransitionManager = new PageTransitionManager();

    // Initialize scroll animations
    pageTransitionManager.initScrollAnimations();

    // Initialize active states on page load
    pageTransitionManager.activeStateManager.updateActiveStates();

    // Initialize footer newsletter handler
    const footerNewsletterHandler = new FooterNewsletterHandler();

    // Make it globally available for debugging
    window.pageTransitionManager = pageTransitionManager;
    window.footerNewsletterHandler = footerNewsletterHandler;
});
