(function () {
    var tabSettings = typeof TAB_Settings !== 'undefined' ? TAB_Settings : {};
    var dismissKey = tabSettings.dismissKey || 'top-announcement-banner-hidden';
    var banner = document.getElementById('tab-banner');

    if (! banner) {
        return;
    }

    if (tabSettings.dismissible) {
        try {
            if (localStorage.getItem(dismissKey) === '1') {
                banner.style.display = 'none';
                return;
            }
        } catch (error) {
            // silent fallback when localStorage is unavailable
        }
    }

    if (! tabSettings.dismissible) {
        return;
    }

    var closeButton = banner.querySelector('.tab-banner-close');

    if (! closeButton) {
        return;
    }

    closeButton.addEventListener('click', function () {
        banner.style.display = 'none';

        try {
            localStorage.setItem(dismissKey, '1');
        } catch (error) {
            // silent fallback when localStorage is unavailable
        }
    });
})();
