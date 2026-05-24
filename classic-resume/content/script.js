document.addEventListener("DOMContentLoaded", function() {

    // --- Interactive Collapsible Sections ---
    const collapsibles = document.querySelectorAll(".collapsible");

    collapsibles.forEach(header => {
        header.addEventListener("click", function() {
            this.classList.toggle("active");
            const content = this.nextElementSibling;
            content.classList.toggle('hidden');
        });
    });

    // --- Scroll Fade-In Animations ---
    const fadeInElements = document.querySelectorAll('.fade-in');

    const observerOptions = {
        root: null, // observes intersections relative to the viewport
        rootMargin: '0px',
        threshold: 0.1 // trigger when 10% of the element is visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                // Optional: stop observing the element once it's visible
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    fadeInElements.forEach(el => {
        observer.observe(el);
    });

});

        
        // Animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, { threshold: 0.1 });
        
        document.querySelectorAll('.section-title, .card').forEach((el) => {
            observer.observe(el);
        });
        
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const searchBtn = document.querySelector('.search-btn');
        
searchBtn.addEventListener('click', () => {
    const searchTerm = searchInput.value.toLowerCase().trim();

    // Clear all previous highlights
    document.querySelectorAll('.skill-tag, .section-content1, .section-content2').forEach(el => {
        el.style.backgroundColor = '';
        el.style.color = '';
    });

    let matches = [];

    document.querySelectorAll('.skill-tag, .section-content1, .section-content2').forEach(el => {
        if (el.textContent.toLowerCase().includes(searchTerm)) {
            el.style.backgroundColor = 'rgba(6, 182, 212, 0.2)';
            el.style.color = 'var(--accent)';
            matches.push(el);

            // Reveal hidden parent `.section-content` if any
            const sectionContent = el.closest('.section-content');
            if (sectionContent && sectionContent.classList.contains('hidden')) {
                sectionContent.classList.remove('hidden');

                // Optional: toggle the header icon
                const collapsible = sectionContent.previousElementSibling;
                if (collapsible && collapsible.classList.contains('collapsible')) {
                    collapsible.classList.add('active');
                    const icon = collapsible.querySelector('.toggle-icon');
                    if (icon) icon.textContent = '+'; // minus symbol
                }
            }

            // croll to the match
            el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});
        
        // Clear highlights when searching again
        searchInput.addEventListener('input', () => {
            document.querySelectorAll('.skill-tag, .section-content1, .section-content2').forEach(el => {
                el.style.backgroundColor = '';
                el.style.color = '';
            });
        });


    function getDurationSince(startDateStr) {
      const startDate = new Date(startDateStr);
      const today = new Date();

      let years = today.getFullYear() - startDate.getFullYear();
      let months = today.getMonth() - startDate.getMonth();

      if (months < 0) {
        years--;
        months += 12;
      }

      return { years, months };
    }

    const duration = getDurationSince('2023-01-01'); 
    const displayText = `${duration.years} years ${duration.months} months`;


    document.getElementById('srv-duration').textContent = displayText;
    
    const startDate = new Date('2018-10-01');
    const today = new Date();
    let years = today.getFullYear() - startDate.getFullYear();
    const monthDiff = today.getMonth() - startDate.getMonth();
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < startDate.getDate())) {
        years--;
    }
    document.getElementById("experience-years").textContent = `${years}+ years`;
