'use strict';

// modules
var del = require('del');
var gulp = require('gulp-param')(require('gulp'), process.argv);
var less = require('gulp-less');
var sass = require('gulp-sass');


gulp.task('clean', function () {
    del(['html/*'], {force: true});
});

gulp.task('build', ['clean'], function (primary, secondary) {
    // Chris, do your gulp-less/gulp-sass magic here :)
    console.log('Primary Color: %s', primary);
    console.log('Secondary Color: %s', secondary);
});

gulp.task('default', ['build'], function(){
    return gulp.src(['./*-script.js', './*-style.css'])
        .pipe(gulp.dest('./html'));
});