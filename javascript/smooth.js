document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function() {
        // Get the target section based on the menu item's data attribute or ID
        const targetId = this.getAttribute('data-target'); // Add data-target attribute in HTML
        const targetSection = document.getElementById(targetId);

        // Fade out all sections first
        document.querySelectorAll('.profile-section').forEach(section => {
            section.classList.remove('fade-in');
            section.classList.add('fade-out');
        });

        // Fade in the target section after a short delay
        setTimeout(() => {
            document.querySelectorAll('.profile-section').forEach(section => {
                section.classList.remove('active'); // Hide all sections
            });
            targetSection.classList.add('active', 'fade-in');
        }, 300); // Adjust delay as needed
    });
});
