// Thrive Website JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize mobile menu
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    hamburger.addEventListener('click', function() {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });

    // Close mobile menu when clicking on a link
    document.querySelectorAll('.nav-menu a').forEach(link => {
        link.addEventListener('click', function() {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        });
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Header scroll effect
    const header = document.querySelector('.header');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            header.style.background = 'rgba(255, 255, 255, 0.98)';
            header.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
        } else {
            header.style.background = 'rgba(255, 255, 255, 0.95)';
            header.style.boxShadow = 'none';
        }
    });

    // Animate statistics numbers
    function animateNumbers() {
        const statNumbers = document.querySelectorAll('.stat-number');
        
        statNumbers.forEach(stat => {
            const target = parseInt(stat.getAttribute('data-target'));
            const increment = target / 100;
            let current = 0;
            
            const updateNumber = () => {
                if (current < target) {
                    current += increment;
                    stat.textContent = Math.ceil(current);
                    setTimeout(updateNumber, 20);
                } else {
                    stat.textContent = target;
                }
            };
            
            updateNumber();
        });
    }

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('about')) {
                    animateNumbers();
                    observer.unobserve(entry.target);
                }
            }
        });
    }, observerOptions);

    // Observe about section for number animation
    const aboutSection = document.querySelector('.about');
    if (aboutSection) {
        observer.observe(aboutSection);
    }

    // Newsletter form submission
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterMessage = document.getElementById('newsletterMessage');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            
            try {
                const response = await fetch('api/newsletter.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    newsletterForm.reset();
                } else {
                    showMessage(data.message, 'error');
                }
            } catch (error) {
                console.error('Newsletter subscription error:', error);
                showMessage('An error occurred. Please try again.', 'error');
            }
        });
    }

    function showMessage(message, type) {
        if (newsletterMessage) {
            newsletterMessage.textContent = message;
            newsletterMessage.className = `newsletter-message ${type}`;
            newsletterMessage.style.display = 'block';
            
            setTimeout(() => {
                newsletterMessage.style.display = 'none';
            }, 5000);
        }
    }

    // Add parallax effect to hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });

    // Add fade-in animation to ecosystem cards
    const ecosystemCards = document.querySelectorAll('.ecosystem-card');
    const cardObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                cardObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    ecosystemCards.forEach(card => {
        card.style.opacity = '0';
        cardObserver.observe(card);
    });

    // Banner slider functionality
    let currentBanner = 0;
    const bannerItems = document.querySelectorAll('.banner-item');
    const totalBanners = bannerItems.length;

    if (totalBanners > 0) {
        // Show first banner
        showBanner(0);

        // Auto-advance banner
        setInterval(() => {
            currentBanner = (currentBanner + 1) % totalBanners;
            showBanner(currentBanner);
        }, 5000);
    }

    function showBanner(index) {
        bannerItems.forEach((item, i) => {
            item.style.display = i === index ? 'block' : 'none';
        });
    }

    // Global function for banner controls
    window.changeBanner = function(direction) {
        currentBanner = (currentBanner + direction + totalBanners) % totalBanners;
        showBanner(currentBanner);
    };
});

// Banner slider functionality (global functions)
function changeBanner(direction) {
    const bannerItems = document.querySelectorAll('.banner-item');
    const totalBanners = bannerItems.length;
    let currentBanner = 0;

    // Find current active banner
    bannerItems.forEach((item, i) => {
        if (item.style.display !== 'none') {
            currentBanner = i;
        }
    });

    currentBanner = (currentBanner + direction + totalBanners) % totalBanners;
    
    bannerItems.forEach((item, i) => {
        item.style.display = i === currentBanner ? 'block' : 'none';
    });
}
