let Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy

    .autoProvideVariables({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    })
    //.setManifestKeyPrefix('build/')
    .copyFiles({
                 from: './assets/images',

                // optional target path, relative to the output dir
                     //to: 'images/[path][name].[ext]',

                             // if versioning is enabled, add the file hash too
                                 //to: 'images/[path][name].[hash:8].[ext]',

                                         // only copy files matching this pattern
                                             //pattern: /\.(png|jpg|jpeg)$/
                                             })

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('metisMenu', './assets/js/metisMenu.min.js')
    .addEntry('theme_js', './assets/js/theme.js')
    .addEntry('datepicker', './assets/js/bootstrap-datepicker.min.js')

    .addEntry('admin', './assets/css/admin.css')
    .addEntry('bootstrap_css', './assets/css/bootstrap.min.css')
    .addEntry('default', './assets/css/default-css.css')
    .addEntry('style', './assets/css/styles.css')

    .addEntry('colors', './assets/css/colors.css')
    .addEntry('start', './assets/css/start-page.css')
    .addEntry('owl_css', './assets/owl-carousel/owl.carousel.css')
    .addEntry('typography', './assets/css/typography.css')
    .addEntry('themify', './assets/css/themify-icons.css')

    .addEntry('refonteV1', './assets/css/refonte_ttcar.css')

    .addEntry('account', './assets/css/account.css')
    .addEntry('index', './assets/css/index.css')
    .addEntry('order', './assets/css/order.css')
    .addEntry('bootstrap', './assets/css/bootstrap.css')

    .copyFiles([
        {from: './node_modules/ckeditor/', to: '@ckeditor/[path][name].[ext]', pattern: /\.(js|css)$/, includeSubdirectories: false},
        {from: './node_modules/ckeditor/adapters', to: '@ckeditor/adapters/[path][name].[ext]'},
        {from: './node_modules/ckeditor/lang', to: 'ckeditor/lang/[path][name].[ext]'},
        {from: './node_modules/ckeditor/plugins', to: 'ckeditor/plugins/[path][name].[ext]'},
        {from: './node_modules/ckeditor/skins', to: 'ckeditor/skins/[path][name].[ext]'}
    ])
    // Uncomment the following line if you are using Webpack Encore <= 0.24
    .addLoader({test: /\.json$/i, include: [require('path').resolve(__dirname, 'node_modules/ckeditor')], loader: 'raw-loader', type: 'javascript/auto'})


    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
