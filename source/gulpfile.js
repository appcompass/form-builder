var gulp = require('gulp');
var del = require('del');
var rename = require("gulp-rename");
var sass = require('gulp-sass');
var cssnano = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var imagemin = require('gulp-imagemin');
var gulpIf = require('gulp-if');
var runSequence = require('run-sequence');

gulp.task('clean:dist', function() {
  return del.sync(['../www/**', '!../www', '!../www/index.php'], {force: true});
});

gulp.task('templates', function(){
    return gulp.src('*.php')
        .pipe(gulp.dest('../www'));
});

gulp.task('sass', function(){
    return gulp.src('assets/sass/**/*.scss')
        .pipe(sass())
        .pipe(cssnano())
        .pipe(rename('main-min.css'))
        .pipe(gulp.dest('../www/assets/css'));
});

gulp.task('scripts', function() {
    return gulp.src([
        'assets/bower_components/**/*min.js',
        '!assets/bower_components/jquery{,/**}',
        '!assets/bower_components/normalize-css{,/**}',
        'assets/js/src/*.js'
    ])
        .pipe(uglify())
        .pipe(concat('main-min.js'))
        .pipe(gulp.dest('../www/assets/js/dist'));
});

gulp.task('images', function(){
    return gulp.src('assets/images/**/*')
        .pipe(imagemin())
        .pipe(gulp.dest('../www/assets/images'));
});

gulp.task('fonts', function() {
    return gulp.src('assets/fonts/**/*')
        .pipe(gulp.dest('../www/assets/fonts'));
});

gulp.task('build', function(callback) {
    runSequence('clean:dist', ['sass', 'scripts', 'images', 'fonts', 'templates'], callback);
});
