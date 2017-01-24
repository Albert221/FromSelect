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
    dataTables.forEach(dataTable => {
        if (dataTable.clientWidth <= dataTable.parentNode.clientWidth) {
            return;
        }

        const rows = dataTable.querySelectorAll('table > tbody > tr');
        const columnsCount = rows[0].querySelectorAll('tr > td').length;

        let widths = [];
        rows.forEach(row => {
            row.querySelectorAll('tr > td').forEach((field, i) => {
                if (isNaN(widths[i])) {
                    widths[i] = 0;
                }

                if (i == 0) {
                    widths[0] += field.clientWidth;
                    return;
                }

                const font = window.getComputedStyle(field, null).font;
                widths[i] += getTextWidth(field.textContent, font);
            });
        });

        const columns = document.createElement('colgroup');
        widths.forEach((heightSum, i) => {
            const width = heightSum / columnsCount;
            const column = document.createElement('col');
            column.setAttribute('style', 'width: ' + width + 'px');
            columns.appendChild(column);
        });

        // For some reason this does not work
        dataTable.appendChild(columns);

        console.log(columns);

    });
})();
