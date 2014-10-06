$(function() {
    $("div.star-rating > s, div.star-rating-rtl > s").on("click", function(e) {
        var numStars = $(e.target).parentsUntil("div").length+1;
        alert(numStars + (numStars == 1 ? " star" : " stars!"));
    });
});
