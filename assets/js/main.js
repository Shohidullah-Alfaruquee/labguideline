document.addEventListener('DOMContentLoaded', () => {
    // --- Navbar Toggle ---
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('nav-links');
    const mainContent = document.getElementById('main');

    // Function to toggle the navigation
    const toggleNav = () => {
        const isExpanded = hamburger.getAttribute('aria-expanded') === 'true';
        hamburger.setAttribute('aria-expanded', !isExpanded);
        navLinks.classList.toggle('active');

        // Apply the smooth transition to the main content
        if (mainContent) {
            if (!isExpanded) {
                const navHeight = navLinks.offsetHeight;
                mainContent.style.transform = `translateY(${navHeight}px)`;
            } else {
                mainContent.style.transform = 'translateY(0)';
            }
        }
    };
    // Click event for hamburger btn 
    hamburger?.addEventListener('click', toggleNav);

    // Add touch event for mobile devices
    hamburger.addEventListener('touchstart', (e) => {
        e.preventDefault(); // Prevent default to avoid double-tap zoom
        toggleNav();
    });

    // Close menu when clicking outside of it
    document.addEventListener('click', (e) => {
        const isHamburger = e.target === hamburger || hamburger.contains(e.target);
        const isNavLinks = e.target === navLinks || navLinks.contains(e.target);

        if (!isHamburger && !isNavLinks && navLinks.classList.contains('active')) {
            toggleNav();
        }
    });

    // Close menu when clicking outside of it
    document.addEventListener('click', (e) => {
        const isHamburger = e.target === hamburger || hamburger.contains(e.target);
        const isNavLinks = e.target === navLinks || navLinks.contains(e.target);

        if (!isHamburger && !isNavLinks && navLinks.classList.contains('active')) {
            toggleNav();
        }
    });
    // Hero section

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                navLinks.classList.remove('active');
            }
        });
    });
    // Hero section ended here

    // --- Service Cards Animation ---
    const serviceCards = document.querySelectorAll('.service-card');
    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = 1;
                entry.target.style.transform = 'translateY(0)';
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    serviceCards.forEach(card => {
        Object.assign(card.style, {
            opacity: 0,
            transform: 'translateY(20px)',
            transition: 'opacity 0.6s ease, transform 0.6s ease'
        });
        observer.observe(card);
    });

    // --- Service Flow Tabs ---
    const tabs = document.querySelectorAll('.service-process-tab');
    const dots = document.querySelectorAll('.service-process-indicator-dot');
    const contents = document.querySelectorAll('.service-process-tab-content');

    function activateTab(id) {
        tabs.forEach(tab => tab.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));
        contents.forEach(content => content.classList.remove('active'));

        document.querySelector(`.service-process-tab[data-tab="${id}"]`)?.classList.add('active');
        document.querySelector(`.service-process-indicator-dot[data-tab="${id}"]`)?.classList.add('active');
        document.getElementById(id)?.classList.add('active');
    }

    [...tabs, ...dots].forEach(el => {
        el.addEventListener('click', () => activateTab(el.getAttribute('data-tab')));
    });

    activateTab('gap-analysis');

    // Team Section 
    // Contact with Team Member

    const contactButtons = document.querySelectorAll('.team-card .contact-btn');
    
    contactButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            
            event.stopPropagation();
            console.log("contact with button clicked");
            

        });
    });

    // --- Footer Year ---
    const yearSpan = document.getElementById('current-year');
    yearSpan && (yearSpan.textContent = new Date().getFullYear());

    // --- Why Us Section ---
    const whySlides = document.querySelectorAll('.whyus-slide');
    const whyDots = document.querySelectorAll('.whyus-indicator');
    const counter = document.querySelector('.whyus-counter');

    // ONLY RUN THIS CODE IF SLIDES EXIST
    if (whySlides.length > 0) {
        let whyIndex = 0;

        const parallax = document.querySelector('.whyus-parallax-image');
        window.addEventListener('scroll', () => {
            if (parallax) {
                const scale = Math.min(1.2, 1.05 + window.pageYOffset * 0.0002);
                parallax.style.transform = `scale(${scale})`;
            }
        });

        function showWhySlide(i) {
            whySlides.forEach(s => s.classList.remove('active'));
            whyDots.forEach(d => d.classList.remove('active'));
            whySlides[i]?.classList.add('active');
            whyDots[i]?.classList.add('active');

            // Safe check for counter
            if (counter) {
                counter.textContent = `${i + 1}/${whySlides.length}`;
            }
            whyIndex = i;
        }

        let whyInterval = setInterval(() => showWhySlide((whyIndex + 1) % whySlides.length), 4000);

        whyDots.forEach(dot => {
            dot.addEventListener('click', () => {
                const i = parseInt(dot.getAttribute('data-index'));
                showWhySlide(i);
                clearInterval(whyInterval);
                whyInterval = setInterval(() => showWhySlide((whyIndex + 1) % whySlides.length), 4000);
            });
        });
    }

    // --- Contact Form ---
    const form = document.getElementById('contactForm');
    const messageEl = document.getElementById('contactMessageElement');

    form?.addEventListener('submit', (event) => {
        event.preventDefault();
        const name = document.getElementById('contactName').value.trim();
        const email = document.getElementById('contactEmail').value.trim();
        const subject = document.getElementById('contactSubject').value;
        const message = document.getElementById('contactMessage').value.trim();

        if (!name || !email || !message) {
            messageEl.textContent = 'Please fill in all required fields.';
            messageEl.className = 'contact-form-message error';
            return;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            messageEl.textContent = 'Please enter a valid email address.';
            messageEl.className = 'contact-form-message error';
            return;
        }

        messageEl.textContent = 'Thank you! Your message has been sent successfully.';
        messageEl.className = 'contact-form-message success';

        setTimeout(() => {
            form.reset();
            messageEl.classList.add('hidden');
        }, 3000);
    });

    // --- FAQ Section ---
    document.querySelectorAll('.faq-item').forEach(item => {
        item.querySelector('.faq-question')?.addEventListener('click', () => {
            item.classList.toggle('faq-active');
        });
    });
});
