
import Taskerify from 'taskerify';

Taskerify.config.sourcemaps    = false;
Taskerify.config.srcPath       = './assets/src/';  // Src Path
Taskerify.config.distPath      = './assets/dist/'; // Dist Path
Taskerify.config.srcViewsPath = './assets/src'; // Views Src Path

const SRC          = Taskerify.config.srcPath;
const DIST         = Taskerify.config.distPath;

const storeName    = 'theme-wp';
const commomFiles  = ['globals'];
const specificFiles  = ['home', 'category', 'search'];

Taskerify((mix) => {

    // Image Minifier
    mix.imagemin(`${SRC}/images`, `${DIST}/images`);

    // Desktop Files
    commomFiles.map((file) => {
        mix.browserify(`${SRC}/js/${storeName}-${file}.js`, `${DIST}/js`)
            .sass(`${SRC}/scss/${storeName}-${file}.scss`,  `${DIST}/css`);
    });

    specificFiles.map((file) => {
        mix.browserify(`${SRC}/js/${storeName}-${file}.js`, `${DIST}/js`)
            .sass(`${SRC}/scss/${storeName}-${file}.scss`,  `${DIST}/css`);
    });

    mix.browserSync({
        open: 'external',
        https: false,
        ui: false,
        port: 8000,
        files: [
            `${DIST}/css/*.css`,
            `${DIST}/js/*.js`,
        ],
        proxy: `localhost/`,
        serveStatic: [
            {
                route: [
                    `/wp-content/themes/theme-wp/assets/dist/js`, 
                    `/wp-content/themes/theme-wp/assets/dist/css`
                ],
                dir: [
                    './assets/dist/js',
                    './assets/dist/css',
                ],
            },
        ],
    })
});
