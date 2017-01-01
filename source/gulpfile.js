var gulp = require('gulp');
var fs = require("fs");
var path = require('path');
var url = require("url");
var del = require('del');
var rename = require("gulp-rename");
var sass = require('gulp-sass');
var cssnano = require('gulp-cssnano');
var htmlbuild = require('gulp-htmlbuild');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var imagemin = require('gulp-imagemin');
var svgmin = require('gulp-svgmin');
var gulpIf = require('gulp-if');
var runSequence = require('run-sequence');
var connect = require('gulp-connect-php');
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;
var timestamp = new Date().getTime(); //we'll use this later to timestamp the js and css file names on build.

gulp.task('clean:dist', function() {
  return del.sync(['../public/**', '!../public', '!../public/index.php'], {force: true});
});

gulp.task('templates', function(){
    return gulp.src(['**/*.php', '!index.php'])
        .pipe(htmlbuild({
            // css: htmlbuild.preprocess.css(function (block) {
            //  block.end('/assets/css/styles_' + timestamp + '.css');
            // }),
            // libs: htmlbuild.preprocess.js(function (block) {
            //     block.end('/path/to/libs/libsName_' + timestamp + '.js');
            // }),
            remove: function (block) {
                block.end();
            }
        }))
        .pipe(gulp.dest('../public'));
});

gulp.task('sass', function(){
    return gulp.src('assets/sass/**/*.scss')
        .pipe(sass())
        .pipe(rename('main-min.css'))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('css', function(){
    return gulp.src('assets/sass/**/*.css')
        .pipe(cssnano())
        .pipe(rename('main-min.css'))
        .pipe(gulp.dest('../public/assets/css'));
});

gulp.task('modernizr', function() {
    return gulp.src([
        'assets/js/dist/modernizr-custom.js'
    ])
        .pipe(uglify())
        .pipe(gulp.dest('../public/assets/js/dist'));

});

gulp.task('scripts', function() {
    return gulp.src([
        'assets/bower_components/**/*min.js',
        '!assets/bower_components/jquery{,/**}',
        '!assets/bower_components/normalize-css{,/**}',
        'assets/js/src/*.js',
    ])
        .pipe(uglify())
        .pipe(concat('main-min.js'))
        .pipe(gulp.dest('../public/assets/js/dist'));
});

gulp.task('svgs', function () {
    return gulp
        .src('assets/images/**/*.svg')
        .pipe(svgmin(function (file) {
            var prefix = path.basename(file.relative, path.extname(file.relative));
            return {
                plugins: [{
                    cleanupIDs: {
                        prefix: prefix + '-',
                        minify: true
                    }
                }]
            }
        }))
        .pipe(gulp.dest('../public/assets/images/'));
});

gulp.task('images', function(){
    return gulp.src(['assets/images/**/*.jpg','assets/images/**/*.png'])
        .pipe(imagemin())
        .pipe(gulp.dest('../public/assets/images'));
});

gulp.task('fonts', function() {
    return gulp.src('assets/fonts/**/*')
        .pipe(gulp.dest('../public/assets/fonts'));
});

gulp.task('watch', ['serve'] , function() {
    gulp.watch('./*.php', reload);
    gulp.watch('./assets/js/src/*.js', reload);
    gulp.watch("./assets/images/**/*", reload);
    gulp.watch('./assets/sass/**/*.scss',['sass', reload]);
});

gulp.task('serve', function () {
    connect.server({}, function (){
        browserSync.init({
            browser: ['FirefoxDeveloperEdition'],
            proxy: '127.0.0.1:8000'
        });

    });
});

gulp.task('build', function(callback) {
    runSequence('clean:dist', 'sass', ['css', 'modernizr', 'scripts', 'images', 'fonts', 'templates'], callback);
});
