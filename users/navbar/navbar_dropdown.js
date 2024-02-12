document.querySelectorAll('.navbar_heading').forEach(item => {
    item.addEventListener('mouseover', event => {
        item.querySelector('.category_header').style.display = 'flex';
    });

    item.addEventListener('mouseout', event => {
        item.querySelector('.category_header').style.display = 'none';
    });
});