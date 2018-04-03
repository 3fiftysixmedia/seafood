(function($) {
    $(function() {
        $('.jcarousel').jcarousel({
          wrap: 'circular'
        })
    .jcarouselAutoscroll({
        target: '+=1',
        interval: 3000
      });

$('.jcarousel2').jcarousel();

        $('.jcarousel-pagination')
            .on('jcarouselpagination:active', 'a', function() {
                $(this).addClass('active');
            })
            .on('jcarouselpagination:inactive', 'a', function() {
                $(this).removeClass('active');
            })
            .jcarouselPagination();
    });
})(jQuery);
