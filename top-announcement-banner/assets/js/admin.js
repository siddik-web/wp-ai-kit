(function () {
    var preview = document.querySelector('.tab-banner-preview');
    var bgInput = document.getElementById('tab_background_color');
    var textInput = document.getElementById('tab_text_color');

    if (! preview || ! bgInput || ! textInput) {
        return;
    }

    function isValidHexColor(value) {
        return /^#([0-9a-fA-F]{3}|[0-9a-fA-F]{6})$/.test(value);
    }

    function updatePreview() {
        if (isValidHexColor(bgInput.value)) {
            preview.style.backgroundColor = bgInput.value;
        }
        if (isValidHexColor(textInput.value)) {
            preview.style.color = textInput.value;
        }
    }

    bgInput.addEventListener('input', updatePreview);
    textInput.addEventListener('input', updatePreview);
    updatePreview();

    if (typeof module !== 'undefined' && module.exports) {
        module.exports = { isValidHexColor };
    }
})();
