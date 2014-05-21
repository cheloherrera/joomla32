((function(global, $, Headroom){

    var FixedHeader = {
        init: function(){
            FixedHeader.headroom = new Headroom($('rt-header'), {
                "tolerance": 5,
                "offset":    120,
                "classes": {
                    "initial":  "animated",
                    "pinned":   "slideDown",
                    "unpinned": "slideUp"
                }
            });

            if ('matchMedia' in window){
                var MQL = window.matchMedia('(max-width: 767px)');
                MQL.addListener(FixedHeader.mediaQuery);
                FixedHeader.mediaQuery(MQL);
            } else {
                FixedHeader.start();
            }
        },

        start: function(){
            FixedHeader.headroom.init();
        },

        stop: function(){
            FixedHeader.headroom.destroy();
        },

        mediaQuery: function(mql){
            FixedHeader[mql.matches ? 'stop' : 'start']();
        }
    };

    global.FixedHeader = FixedHeader;

    global.addEvent('domready', function(){
        FixedHeader.init();
    });

})(window, document.id, Headroom));
