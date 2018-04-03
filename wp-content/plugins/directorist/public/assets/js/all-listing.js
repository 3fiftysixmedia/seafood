
(function ($) {

    //sorting toggle
    $('.sorting span').on('click',function () {
        $(this).toggleClass('fa-sort-amount-asc fa-sort-amount-desc');
    });

    /*External Library init
     ------------------------*/
    // Star rating
    $(".stars").barrating({
        theme: 'fontawesome-stars'
    });


})(jQuery);

