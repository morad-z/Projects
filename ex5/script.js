function filterBooks(category) {
    var bookList = document.getElementsByClassName('book-item');
    for (var i = 0; i < bookList.length; i++) {
        var book = bookList[i];
        var bookCategory = book.getAttribute('data-category');
        if (bookCategory === category || category === 'All') {
            book.style.display = '';
        } else {
            book.style.display = 'none';
        }
    }
}
