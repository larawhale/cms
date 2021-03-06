window.addEventListener('load', () => {
    /**
     * Redricts to href attribute on click.
     */
    document.querySelectorAll('.action-href').forEach((element) => {
        element.addEventListener('click', e => {
            const href = element.getAttribute('href');

            if (! href) return false;

            window.location = href;

            return false;
        });
    });

    /**
     * Confirms before action is executed.
     */
    document.querySelectorAll('.action-confirm').forEach((element) => {
        const confirmAction = e => {
            if (! confirm('Are you sure?')) {
                e.preventDefault();

                return false;
            }
        };

        element.addEventListener('click', confirmAction);
    });
});
