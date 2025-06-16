// // Wait for DOM to be fully loaded
// document.addEventListener("DOMContentLoaded", function () {
//     // Navigation functionality
//     initializeNavigation();

//     // Course selection functionality
//     initializeCourseSelection();

//     // Register button functionality
//     initializeRegistration();

//     // Login functionality
//     initializeLogin();

//     // Score functionality
//     initializeScore();

//     // Smooth scrolling for internal links
//     initializeSmoothScrolling();

//     // Mobile menu toggle (if needed in future)
//     initializeMobileMenu();
// });

// // Navigation functionality
// function initializeNavigation() {
//     const currentPage =
//         window.location.pathname.split("/").pop() || "index.html";
//     const navLinks = document.querySelectorAll(".nav a");

//     navLinks.forEach((link) => {
//         const href = link.getAttribute("href");
//         if (href === currentPage) {
//             link.classList.add("active");
//         }

//         link.addEventListener("click", function (e) {
//             // Remove active class from all links
//             navLinks.forEach((l) => l.classList.remove("active"));
//             // Add active class to clicked link
//             this.classList.add("active");
//         });
//     });
// }

// // Course selection functionality
// function initializeCourseSelection() {
//     const courseItems = document.querySelectorAll(".course-item");
//     const courseCards = document.querySelectorAll(".course-card");

//     // Handle course item clicks on home page
//     courseItems.forEach((item) => {
//         item.addEventListener("click", function () {
//             const courseName =
//                 this.querySelector("h3").textContent.toLowerCase();
//             navigateToCourse(courseName);
//         });
//     });

//     // Handle course card clicks on course page
//     courseCards.forEach((card) => {
//         card.addEventListener("click", function () {
//             const courseName =
//                 this.querySelector("h3").textContent.toLowerCase();
//             navigateToCourseDetail(courseName);
//         });
//     });
// }

// // Navigate to course page
// function navigateToCourse(courseName) {
//     switch (courseName) {
//         case "piano":
//             window.location.href = "detail_course.html";
//             break;
//         case "gitar":
//             window.location.href = "course.html#gitar";
//             break;
//         case "vokal":
//             window.location.href = "course.html#vokal";
//             break;
//         case "biola":
//             window.location.href = "course.html#biola";
//             break;
//         case "drum":
//             window.location.href = "course.html#drum";
//             break;
//         default:
//             window.location.href = "course.html";
//     }
// }

// // Registration functionality
// function initializeRegistration() {
//     const ctaBtn = document.querySelector(".cta-btn");
//     const registerBtns = document.querySelectorAll(".register-btn");

//     // Main CTA button
//     if (ctaBtn) {
//         ctaBtn.addEventListener("click", function () {
//             window.location.href = "register.html";
//         });
//     }

//     // Register buttons in course details
//     registerBtns.forEach((btn) => {
//         btn.addEventListener("click", function () {
//             // Show confirmation dialog
//             if (confirm("Apakah Anda yakin ingin mendaftar untuk kelas ini?")) {
//                 // Redirect to score page (simulating test)
//                 window.location.href = "test.html";
//             }
//         });
//     });
// }

// // Login functionality
// function initializeLogin() {
//     const loginForm = document.querySelector(".login-form");
//     const loginSubmit = document.querySelector(".login-submit");

//     if (loginForm) {
//         loginForm.addEventListener("submit", function (e) {
//             e.preventDefault();
//             handleLogin();
//         });
//     }

//     if (loginSubmit) {
//         loginSubmit.addEventListener("click", function (e) {
//             e.preventDefault();
//             handleLogin();
//         });
//     }
// }

// // Handle login process
// function handleLogin() {
//     const username = document.querySelector(
//         'input[type="text"], input[type="email"]'
//     );
//     const password = document.querySelector('input[type="password"]');

//     if (username && password) {
//         const usernameValue = username.value.trim();
//         const passwordValue = password.value.trim();

//         if (usernameValue === "" || passwordValue === "") {
//             alert("Mohon isi semua field yang diperlukan!");
//             return;
//         }

//         // Simple validation (in real app, this would be server-side)
//         if (usernameValue === "admin" && passwordValue === "admin") {
//             alert("Login berhasil!");
//             window.location.href = "index.html";
//         } else {
//             // For demo purposes, any other credentials will also "work"
//             alert("Login berhasil! Selamat datang di David Music Course.");
//             window.location.href = "index.html";
//         }
//     }
// }

// // Score functionality
// function initializeScore() {
//     const scoreNumber = document.querySelector(".score-number");
//     const resultBtn = document.querySelector(".result-btn");

//     if (scoreNumber) {
//         // Animate score counting up
//         animateScore(scoreNumber, parseInt(scoreNumber.textContent));
//     }

//     if (resultBtn) {
//         resultBtn.addEventListener("click", function () {
//             showResult();
//         });
//     }
// }

// // Animate score counting
// function animateScore(element, targetScore) {
//     let currentScore = 0;
//     const increment = targetScore / 50; // Adjust speed by changing divisor

//     const timer = setInterval(() => {
//         currentScore += increment;
//         if (currentScore >= targetScore) {
//             currentScore = targetScore;
//             clearInterval(timer);
//         }
//         element.textContent = Math.floor(currentScore);
//     }, 50);
// }

// // Show test result
// function showResult() {
//     const score = document.querySelector(".score-number").textContent;
//     let message = "";

//     if (score >= 80) {
//         message = `Selamat! Dengan skor ${score}, Anda telah lulus tes masuk. Anda dapat melanjutkan ke kelas yang dipilih.`;
//     } else if (score >= 60) {
//         message = `Skor Anda ${score}. Anda perlu sedikit latihan tambahan sebelum memulai kelas.`;
//     } else {
//         message = `Skor Anda ${score}. Kami merekomendasikan untuk mengambil kelas dasar terlebih dahulu.`;
//     }

//     alert(message);

//     // Redirect back to courses after showing result
//     setTimeout(() => {
//         window.location.href = "profile.html";
//     }, 2000);
// }

// // Smooth scrolling functionality
// function initializeSmoothScrolling() {
//     const links = document.querySelectorAll('a[href^="#"]');

//     links.forEach((link) => {
//         link.addEventListener("click", function (e) {
//             const href = this.getAttribute("href");
//             if (href.startsWith("#") && href.length > 1) {
//                 e.preventDefault();
//                 const targetId = href.substring(1);
//                 const targetElement = document.getElementById(targetId);

//                 if (targetElement) {
//                     targetElement.scrollIntoView({
//                         behavior: "smooth",
//                         block: "start",
//                     });
//                 }
//             }
//         });
//     });
// }

// // Mobile menu functionality (for future enhancement)
// function initializeMobileMenu() {
//     // Add mobile menu toggle functionality if needed
//     const nav = document.querySelector(".nav");

//     // Add responsive behavior
//     window.addEventListener("resize", function () {
//         if (window.innerWidth <= 768) {
//             // Mobile specific adjustments
//             adjustForMobile();
//         } else {
//             // Desktop specific adjustments
//             adjustForDesktop();
//         }
//     });

//     // Initial check
//     if (window.innerWidth <= 768) {
//         adjustForMobile();
//     }
// }

// function adjustForMobile() {
//     // Mobile-specific adjustments
//     const heroContent = document.querySelector(".hero-content");
//     if (heroContent) {
//         heroContent.style.padding = "0 1rem";
//     }
// }

// function adjustForDesktop() {
//     // Desktop-specific adjustments
//     const heroContent = document.querySelector(".hero-content");
//     if (heroContent) {
//         heroContent.style.padding = "0 2rem";
//     }
// }

// // Utility functions
// function showNotification(message, type = "info") {
//     // Create notification element
//     const notification = document.createElement("div");
//     notification.className = `notification notification-${type}`;
//     notification.textContent = message;

//     // Style the notification
//     notification.style.cssText = `
//         position: fixed;
//         top: 100px;
//         right: 20px;
//         background-color: ${
//             type === "success"
//                 ? "#4CAF50"
//                 : type === "error"
//                 ? "#f44336"
//                 : "#2196F3"
//         };
//         color: white;
//         padding: 1rem 2rem;
//         border-radius: 5px;
//         box-shadow: 0 2px 10px rgba(0,0,0,0.1);
//         z-index: 10000;
//         opacity: 0;
//         transform: translateX(100px);
//         transition: all 0.3s ease;
//     `;

//     document.body.appendChild(notification);

//     // Animate in
//     setTimeout(() => {
//         notification.style.opacity = "1";
//         notification.style.transform = "translateX(0)";
//     }, 100);

//     // Remove after 3 seconds
//     setTimeout(() => {
//         notification.style.opacity = "0";
//         notification.style.transform = "translateX(100px)";
//         setTimeout(() => {
//             document.body.removeChild(notification);
//         }, 300);
//     }, 3000);
// }

// // Contact functionality
// function initializeContact() {
//     const contactNumbers = document.querySelectorAll(".footer p");

//     contactNumbers.forEach((contact) => {
//         contact.addEventListener("click", function () {
//             // Extract phone numbers and show options
//             const text = this.textContent;
//             const phoneNumbers = text.match(/\d{12,}/g);

//             if (phoneNumbers) {
//                 const message = `Pilih nomor untuk menghubungi:\n${phoneNumbers
//                     .map((num, index) => `${index + 1}. ${num}`)
//                     .join("\n")}`;
//                 alert(message);
//             }
//         });
//     });
// }

// // Initialize contact functionality
// initializeContact();

// // Add loading animation
// function showLoading() {
//     const loader = document.createElement("div");
//     loader.className = "loader";
//     loader.innerHTML = '<div class="spinner"></div>';

//     loader.style.cssText = `
//         position: fixed;
//         top: 0;
//         left: 0;
//         width: 100%;
//         height: 100%;
//         background-color: rgba(255,255,255,0.9);
//         display: flex;
//         justify-content: center;
//         align-items: center;
//         z-index: 10000;
//     `;

//     const spinner = loader.querySelector(".spinner");
//     spinner.style.cssText = `
//         width: 40px;
//         height: 40px;
//         border: 4px solid #f3f3f3;
//         border-top: 4px solid #8B0000;
//         border-radius: 50%;
//         animation: spin 1s linear infinite;
//     `;

//     // Add CSS animation
//     if (!document.querySelector("#loader-styles")) {
//         const style = document.createElement("style");
//         style.id = "loader-styles";
//         style.textContent = `
//             @keyframes spin {
//                 0% { transform: rotate(0deg); }
//                 100% { transform: rotate(360deg); }
//             }
//         `;
//         document.head.appendChild(style);
//     }

//     document.body.appendChild(loader);
//     return loader;
// }

// function hideLoading(loader) {
//     if (loader && loader.parentNode) {
//         loader.parentNode.removeChild(loader);
//     }
// }

// // Export functions for global use
// window.showResult = showResult;
// window.navigateToCourse = navigateToCourse;
// window.showNotification = showNotification;
