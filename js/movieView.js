$(function(){
    $('.rating-container').rating(function(vote, event){
        var id = $('.rating-container').data('id');
        $.post('/movie/rate', {rate: vote, movieId: id});
    });
});