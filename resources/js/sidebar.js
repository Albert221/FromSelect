// @TODO: Polyfill this because guys in Microshit are fucking lazy and they cannot implement basic shit in Edge.

const databasesList = document.querySelector('.list');

databasesList.addEventListener('click', function (e) {
    if (!e.target || !e.target.matches('button'))
        return;

    e.preventDefault();

    const targetItem = e.target.parentNode.parentNode,
          targetButton = e.target;
    if (targetItem.classList.contains('active')) {
        targetItem.classList.remove('active');
        targetButton.textContent = '+';
        targetButton.setAttribute('aria-label', 'Expand');
    } else {
        targetItem.classList.add('active');
        targetButton.textContent = '–';
        targetButton.setAttribute('aria-label', 'Collapse');
    }
});

// @TODO: Add script for filtering with `#search`
