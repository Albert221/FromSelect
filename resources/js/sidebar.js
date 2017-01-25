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

        targetButton.blur();
    });


    // For explanation of the filter syntax, take a look here:
    // https://github.com/Albert221/FromSelect/issues/9#issuecomment-274047742
    const filterField = document.getElementById('filter');
    filterField.addEventListener('input', function (e) {
        const phrase = filterField.value;
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

        databasesList.querySelectorAll('li').forEach(el => el.classList.remove('hidden', 'search-expanded'));

        // Databases filter.
        databasesList.querySelectorAll('.list > li').forEach(databaseEl => {
            if (databaseEl.classList.contains('new')) {
                return;
            }

            // TODO: Somehow do what should be done, e.g. aria-label and plus or minus symbol.
            if (database != '' && table != '') {
                databaseEl.classList.add('search-expanded');
            }

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
            // Tables filter.
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

            // If database has tables that were not hidden, then show database.
            if (empty && database == '') {
                databaseEl.classList.add('hidden');
            }

            // If the database is not due to strictly-database search and has
            // not hidden tables, then show database.
            if (!empty && database == table) {
                databaseEl.classList.remove('hidden');
            }

            // Show databases which tables are filtered.
            if (!empty && database == '' && table != '') {
                databaseEl.classList.add('search-expanded');
            }

            // If database is already hidden remove its expansion.
            if (databaseEl.classList.contains('hidden')) {
                databaseEl.classList.remove('search-expanded');
            }
        });
    });
})();
