const gulp = require('gulp');
const exec = require('child_process').execSync;
const fs = require('fs-extra');
const zip = require('zip-dir');
const autoprefixer = require('gulp-autoprefixer');
const cssnano = require('gulp-cssnano');
const jshint = require('gulp-jshint');
const uglify = require('gulp-uglify');
const rename = require('gulp-rename');
const plumber = require('gulp-plumber');

const gulpSrc = gulp.src;

gulp.src = function () {
    return gulpSrc.apply(gulp, arguments)
        .pipe(plumber());
};


/**
 * Generate Code Documentation (ApiGen)
 */
gulp.task('doc', function (done) {
    fs.removeSync('doc/apigen');
    const command = 'php doc/apigen.phar generate -s "src" -d "doc/apigen" --exclude "*vendor*" '
        + '--todo --template-theme "bootstrap"';
    exec(command, function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
    });
    done();
});

/**
 * Execute the PHPUnit tests.
 */
gulp.task('test', function (done) {
    exec('phpunit test', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
    });
    done();
});

/**
 * Compile the JavaScript Files
 */
gulp.task('scripts', function (done) {
    gulp.src([
        'src/assets/js/*.js',
        '!src/assets/js/*.min.js'
    ])
        .pipe(jshint({laxbreak: true}))
        .pipe(jshint.reporter('default'))
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('src/assets/js'));

    done();
});

/**
 * Compile the CSS Files
 */
gulp.task('styles', function (done) {
    gulp.src([
        'src/assets/css/*.css',
        '!src/assets/css/*.min.css'
    ])
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('src/assets/css'));

    done();
});

gulp.task('sync', function (done) {
    gulp.src('src/**/*')
        .pipe(gulp.dest('./wordpress/wp-content/plugins/easyappointments'));

    done();
});

/**
 * Development Task
 *
 * While developing the plugin this task will synchronize the changes made in the
 * "wp-content/plugins/easyappointments" directory with the original plugin source
 * files that are finally committed to the repository.
 */
gulp.task('dev', gulp.series('styles', 'scripts', 'sync', function (done) {
    gulp.watch(['src/assets/js/*.js', '!src/assets/js/*.min.js'], gulp.series('scripts'));
    gulp.watch(['src/assets/css/*.css', '!src/assets/css/*.min.css'], gulp.series('styles'));

    const path = './wordpress/wp-content/plugins/easyappointments';

    if (!fs.pathExistsSync(path)) {
        fs.mkdirSync(path);
    }

    gulp.watch('src/**/*', gulp.series('sync'));

    done();
}));

/**
 * Create a ZIP package for the plugin.
 */
gulp.task('build', gulp.series('styles', 'scripts', function (done) {
    fs.removeSync('build');
    fs.removeSync('easyappointments-wordpress-plugin.zip');
    fs.mkdirSync('build');
    fs.copySync('src', 'build/easyappointments');
    fs.copySync('LICENSE', 'build/easyappointments/LICENSE');
    fs.copySync('doc/wp-readme.txt', 'build/easyappointments/readme.txt');
    fs.copySync('screenshot-1.png', 'build/easyappointments/screenshot-1.png');
    fs.copySync('screenshot-2.png', 'build/easyappointments/screenshot-2.png');
    fs.copySync('screenshot-3.png', 'build/easyappointments/screenshot-3.png');
    fs.copySync('screenshot-4.png', 'build/easyappointments/screenshot-4.png');
    zip('build', {saveTo: 'easyappointments-wordpress-plugin.zip'}, function (err, buffer) {
        if (err) {
            console.log('Zip Error', err);
        }
        done();
    });
}));
