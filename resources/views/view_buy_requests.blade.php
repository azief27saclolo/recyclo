<script>
    // Function to handle description box expansion
    function handleDescriptionBox(descriptionBox) {
        const description = descriptionBox.querySelector('.description-text');
        const expandButton = descriptionBox.querySelector('.expand-button');
        
        if (description.scrollHeight > description.clientHeight) {
            expandButton.style.display = 'block';
        } else {
            expandButton.style.display = 'none';
        }
    }

    // Initialize description boxes
    document.addEventListener('DOMContentLoaded', function() {
        const descriptionBoxes = document.querySelectorAll('.description-box');
        descriptionBoxes.forEach(handleDescriptionBox);
    });

    // Handle expand/collapse
    function toggleDescription(button) {
        const descriptionBox = button.closest('.description-box');
        const description = descriptionBox.querySelector('.description-text');
        const isExpanded = descriptionBox.classList.contains('expanded');
        
        if (isExpanded) {
            descriptionBox.classList.remove('expanded');
            button.textContent = 'Read More';
        } else {
            descriptionBox.classList.add('expanded');
            button.textContent = 'Show Less';
        }
    }
</script>
</body>
</html> 