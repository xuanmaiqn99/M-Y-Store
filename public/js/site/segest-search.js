function seggest(input, engine, base) {
    input.typeahead({
        hint: false,
        highlight: true,
        minLength: 1
    }, {
        source: engine.ttAdapter(),
        name: 'search',
        displayKey: 'name',
        templates: {
            empty: [
                // '<div class="list-group search-results-dropdown">
                // <div class="list-group-item">Không có kết quả phù hợp.</div></div>'
            ],
            header: [
                '<div class="list-group search-results-dropdown">'
            ],
            suggestion: function (data) {
                // return '<a style="cursor: pointer" class="list-group-item">' + data + '</a>'
                html = '<div class="list-group-item">';
                html += '<div class="media"><a class="pull-left" href="'+base
                    +'product/'+data.id+'/view.html"><img src="'+base+
                    'upload/image/'+data.avatar+'" height="60px" width="50px"/></a>'
                html += '<div class="media-body">';
                html += '<h5 class="media-heading"><a href="'+base
                    +'product/'+data.id+'/view.html">'+data.name+'</a></h5>';
                html += '<p>'+data.price+'<span style="color: red"> đ</span></p></div>';
                html += '</div>';

                return html;
            }
        }
    });
}
$(window).on('load', function() {
    var base = $('base').attr('href');
    var id = $('.cate-s').val();
    var engine = new Bloodhound({
        remote: {
            url: base + 'seggest?id=' + id + '&key=%QUERY%',
            wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('key'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });
    engine.initialize();
    seggest($(".search"), engine, base);
    $('.cate-s').on('change', function() {
        id = $('.cate-s').val();
        engine.remote.url = base + 'seggest?id=' + id + '&key=%QUERY%';
        engine.initialize();
        $('.search').typeahead('destroy');
        seggest($(".search"), engine, base);
    });
});
