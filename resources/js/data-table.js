(function() {
    /**
     * Uses canvas.measureText to compute and return the width of the given text of given font in pixels.
     *
     * @param {String} text The text to be rendered.
     * @param {String} font The css font descriptor that text is to be rendered with (e.g. "bold 14px verdana").
     *
     * @see http://stackoverflow.com/questions/118241/calculate-text-width-with-javascript/21015393#21015393
     */
    function getTextWidth(text, font) {
        // re-use canvas object for better performance
        let canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
        let context = canvas.getContext("2d");
        context.font = font;
        let metrics = context.measureText(text);

        return metrics.width;
    }

    const dataTables = document.querySelectorAll('.data-table');

    // Add class to checked rows.
    dataTables.forEach(dataTable => {
        dataTable.querySelectorAll('tr td:first-child [type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                checkbox.parentNode.parentNode.classList.toggle('checked', checkbox.checked);
            });
        });
    });

    dataTables.forEach(dataTable => {
        if (!dataTable.classList.contains('optimal-width')) {
            return;
        }

        const rows = dataTable.querySelectorAll('table > tbody > tr');
        const columnsCount = rows[0].querySelectorAll('tr > td').length;

        let widths = [];
        let fontWidths = [];
        rows.forEach(row => {
            row.querySelectorAll('tr > td').forEach((field, i) => {
                if (isNaN(widths[i])) {
                    widths[i] = 0;
                }

                if (i == 0) {
                    widths[0] = field.clientWidth;
                    return;
                }

                // FIXME: This is ignoring checkbox because of no text.
                // Add two times 15 px because padding
                const cellWidth = getTextWidth(field.textContent, window.getComputedStyle(field, null).font) + 30;
                widths[i] += cellWidth;

                fontWidths[i] = fontWidths[i] === undefined ?
                    cellWidth : Math.max(fontWidths[i], cellWidth);
            });
        });

        const columns = document.createElement('colgroup');
        widths.forEach((widthSum, i) => {
            let width = widthSum / columnsCount;
            width = Math.min(width, dataTable.clientWidth * 0.5);

            if (width < 60) {
                width = fontWidths[i];
            }

            const column = document.createElement('col');
            column.setAttribute('style', 'width: ' + width + 'px');
            columns.appendChild(column);
        });

        dataTable.appendChild(columns);
    });
})();
