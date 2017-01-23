// Polyfill for DOM matches() function for IE11 and Edge
Element.prototype.matches = Element.prototype.matches
    || Element.prototype.msMatchesSelector;

(function () {
    const databasesList = document.querySelector('.list');

    databasesList.addEventListener('click', function (e) {
        if (!e.target || !e.target.matches('button')) {
            return;
        }

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


    // For explanation of the search syntax, take a look here:
    // https://github.com/Albert221/FromSelect/issues/9#issuecomment-274047742
    const searchField = document.getElementById('search');
    searchField.addEventListener('input', function (e) {
        const phrase = searchField.value;
        // Split phrase using delimeter `.`.
        const phrases = phrase.split('.');
        let database, databaseStrict, table, tableStrict;

        database = phrases[0];
        // Set strict search if phrase is surrounded by quotation marks.
        databaseStrict = database.indexOf('"') == 0 && database.indexOf('"', 1) == database.length - 1;
        database = database.replace(/"/g, '');

        // Set table to database if not specified, so that user can use `foobar` syntax (see issue comment).
        table = phrases.length > 1 ? phrases[1] : phrases[0];
        tableStrict = table.indexOf('"') == 0 && table.indexOf('"', 1) == table.length - 1;
        table = table.replace(/"/g, '');

        databasesList.querySelectorAll('li').forEach(el => el.classList.remove('hidden', 'searchExpanded'));

        // Databases search.
        databasesList.querySelectorAll('.list > li').forEach(databaseEl => {
            if (databaseEl.classList.contains('new')) {
                return;
            }

            // TODO: Somehow do what should be done, e.g. aria-label and plus or minus symbol.
            databaseEl.classList.add('searchExpanded');

            if (database != '') {
                const value = databaseEl.querySelector('a').textContent.replace(/[\–\+]/, '').trim();

                if (databaseStrict) {
                    const pattern = '^' + database + '$';
                    if (value.search(new RegExp(pattern, 'i')) == -1) {
                        databaseEl.classList.add('hidden');
                    }
                } else if (value.search(new RegExp(database, 'i')) == -1) {
                    databaseEl.classList.add('hidden');
                }
            }

            let empty = true;
            // Tables search.
            databaseEl.querySelectorAll('li').forEach(tableEl => {
                if (table == '') {
                    empty = false;
                    return;
                }

                const value = tableEl.querySelector('a').textContent;
                if (tableStrict) {
                    const pattern = '^' + table + '$';
                    if (value.search(new RegExp(pattern, 'i')) == -1) {
                        tableEl.classList.add('hidden');
                    } else {
                        empty = false;
                    }
                } else if (value.search(new RegExp(table, 'i')) == -1) {
                    tableEl.classList.add('hidden');
                } else {
                    empty = false;
                }
            });

            // If database has tables that were not hidden, then show database
            if (empty && database == '') {
                databaseEl.classList.add('hidden');
            }

            // If the database is not due to strictly-database search and has
            // not hidden tables, then show database
            if (!empty && database == table) {
                databaseEl.classList.remove('hidden');
            }
        });
    });
})();
