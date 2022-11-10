$('.artbox').click(goArticle);

function goArticle() {
    location.href = $(this).attr('data-link');
}