// Polyfill for DOM matches() function for IE11 and Edge
Element.prototype.matches = Element.prototype.matches
    || Element.prototype.msMatchesSelector;

const databasesList = document.querySelector('.list');

databasesList.addEventListener('click', function (e) {
    if (!e.target || !e.target.matches('button'))
        return;

    e.preventDefault();

    const targetItem = e.target.parentNode.parentNode,
          targetButton = e.target;
    if (targetItem.classList.contains('expanded')) {
        targetItem.classList.remove('expanded');
        targetButton.textContent = '+';
        targetButton.setAttribute('aria-label', 'Expand');
    } else {
        targetItem.classList.add('expanded');
        targetButton.textContent = '–';
        targetButton.setAttribute('aria-label', 'Collapse');
    }
});

// @TODO: Add script for filtering with `#search`
