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

    /**
     * Displays file name on file change.
     */
    document.querySelectorAll('.custom-file-input').forEach((element) => {
        element.addEventListener('change', e => {
            const target = e.target;

            let name = target.getAttribute('placeholder');

            if (target.files && target.files.length > 0) {
                name = target.files[0].name;
            }

            // The next element sibling should always be the
            // `label.custom-file-label`.
            target.nextElementSibling.innerHTML = name;
        });
    });
});
