'use strict';

var gulp = require('gulp');
var livereload = require('gulp-livereload');

gulp.task('css:livereload', function() {
    return gulp.src('./style.css')
    .pipe(livereload());
});
