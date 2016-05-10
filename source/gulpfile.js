var gulp = require('gulp');
var del = require('del');
var sass = require('gulp-sass');
var useref = require('gulp-useref');
var uglify = require('gulp-uglify');
var cssnano = require('gulp-cssnano');
var imagemin = require('gulp-imagemin');
var gulpIf = require('gulp-if');
var runSequence = require('run-sequence');

gulp.task('clean:dist', function() {
  return del.sync(['../www/**', '!../www', '!../www/index.php'], {force: true});
});

gulp.task('sass', function(){
    return gulp.src('src/scss/**/*.scss')
        .pipe(sass())
        .pipe(gulp.dest('../www/css'));
});

gulp.task('useref', function(){
    return gulp.src('src/templates/**/*.html')
        .pipe(useref())
        .pipe(gulpIf('*.js', uglify()))
        .pipe(gulpIf('*.css', cssnano()))
        .pipe(gulp.dest('../www'));
});

gulp.task('images', function(){
    return gulp.src('src/images/**/*.+(png|jpg|jpeg|gif|svg)')
        .pipe(imagemin())
        .pipe(gulp.dest('../www/images'));
});

gulp.task('fonts', function() {
    return gulp.src('src/fonts/**/*')
        .pipe(gulp.dest('../www/fonts'));
});

gulp.task('build', function(callback) {
    runSequence('clean:dist', ['sass', 'useref', 'images', 'fonts'], callback);
});
