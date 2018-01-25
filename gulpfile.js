var folders = {
    'public': './public/',
    'resources': './resources/assets/',
    'bower': './bower_components/',
    'node': './node_modules/',
    'vendor': './vendor/'
};

const elixir = require('laravel-elixir');

elixir(function(mix) {

    mix .sass('app.scss', 'public/css')

        .copy(folders.bower + 'multiselect/css/multi-select.css', folders.public + 'css/multi-select.css')

        .scripts([
            folders.bower + 'jquery/dist/jquery.min.js',
            folders.node + 'bootstrap-sass/assets/javascripts/bootstrap.js',
            //folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/affix.js',
            //folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/alert.js',
            //folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/button.js',
            //folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/carousel.js',
            folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
            //folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/dropdown.js',
            folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/modal.js',
            folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/popover.js',
            //folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/tab.js',
            folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
            folders.node + 'bootstrap-sass/assets/javascripts/bootstrap/transition.js',
            folders.bower + 'datatables.net/js/jquery.dataTables.min.js',
            folders.bower + 'datatables.net-bs/js/dataTables.bootstrap.min.js',
            folders.bower + 'moment/moment.js',
            folders.bower + 'moment-timezone/builds/moment-timezone-with-data.min.js',
            folders.bower + 'multiselect/js/jquery.multi-select.js',
            folders.resources + 'js/vendor/jquery.quicksearch.js',
        ], folders.public + 'js/vendor.js')

        .copy(folders.bower + 'datatables.net-bs/css/dataTables.bootstrap.min.css',
            folders.public + 'css/dataTables.bootstrap.min.css')
        .copy('node_modules/bootstrap-sass/assets/fonts', 'public/fonts')
});