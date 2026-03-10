/**
 * search-filter.js
 * Implements real-time text search and category filtering for note tables and grids.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Determine the type of container we are filtering
    const container = document.querySelector('.s-card-grid, .s-img-grid, .s-table tbody');
    if (!container) return; // Exit if no filterable content on this page

    // Select all items that can be filtered
    // For tables, items are rows (tr). For grids, items are anchors (a).
    const items = container.querySelectorAll('.s-card, .s-img-card, tr');

    // Setup references to the UI elements
    const searchInput = document.getElementById('searchNotesInput');
    const categorySelect = document.getElementById('categorySelect');

    // Create 'No Results' UI block dynamically and insert after container
    const noResultsEl = document.createElement('div');
    noResultsEl.className = 's-no-results';
    noResultsEl.innerHTML = `
        <div class="s-no-results-icon">🔍</div>
        <div class="s-no-results-title">No Resources Found</div>
        <div>We couldn't find any notes matching your search criteria.</div>
    `;

    // Append after the container's parent section (or table wrap)
    const appendTarget = container.closest('.s-table-wrap') || container;
    appendTarget.parentNode.insertBefore(noResultsEl, appendTarget.nextSibling);

    /**
     * Core filtering logic.
     * Evaluates both text input and dropdown selection to hide/show nodes.
     */
    function filterItems() {
        if (!searchInput || !categorySelect) return;

        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categorySelect.value;
        let visibleCount = 0;

        items.forEach(item => {
            // Get item text content (removes extra whitespace)
            const textContent = item.textContent.toLowerCase().trim();

            // Get category attribute from HTML (or default to 'all')
            const itemCategory = item.getAttribute('data-category') || 'all';

            // Check matching conditions
            const matchesSearch = textContent.includes(searchTerm);
            const matchesCategory = selectedCategory === 'all' || itemCategory === selectedCategory;

            if (matchesSearch && matchesCategory) {
                // Determine display type based on element tag
                if (item.tagName.toLowerCase() === 'tr') {
                    item.style.display = 'table-row';
                } else {
                    // For flex/grid items, remove inline display style so CSS class applies
                    item.style.display = '';
                }
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Toggle No Results UI
        if (visibleCount === 0) {
            noResultsEl.classList.add('show');
            // Hide table headers if filtering a table
            if (container.tagName.toLowerCase() === 'tbody') {
                container.closest('table').style.display = 'none';
            }
        } else {
            noResultsEl.classList.remove('show');
            if (container.tagName.toLowerCase() === 'tbody') {
                container.closest('table').style.display = 'table';
            }
        }
    }

    // Attach Event Listeners for real-time updates
    if (searchInput) searchInput.addEventListener('input', filterItems);
    if (categorySelect) categorySelect.addEventListener('change', filterItems);
});
