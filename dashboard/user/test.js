document.addEventListener("DOMContentLoaded", function() {
    function showPage(pageNumber) {
        var pages = document.querySelectorAll('.questions');
        pages.forEach(function(page, index) {
            page.style.display = (index + 1 === pageNumber) ? 'block' : 'none';
        });
    }

    window.showPage = showPage;

    var nextButtons = document.querySelectorAll('button[onclick^="showPage"]');
    nextButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var pageNumber = parseInt(this.getAttribute('onclick').match(/\d+/)[0], 10);
            showPage(pageNumber);
        });
    });
});