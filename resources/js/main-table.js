(function() {
    const mainTables = document.querySelectorAll('.main-table');
    mainTables.forEach(mainTable => {
        mainTable.querySelectorAll('tr td:first-child [type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                checkbox.parentNode.parentNode.classList.toggle('checked', checkbox.checked);
            });
        });
    });
})();
