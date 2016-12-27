const gulp = require('gulp'),
      sass = require('gulp-sass'),
      autoprefixer = require('gulp-autoprefixer'),
      csso = require('gulp-csso');

gulp.task('sass', () => {
    return gulp.src('./resources/sass/style.scss')
               .pipe(sass().on('error', sass.logError))
               .pipe(autoprefixer())
               .pipe(csso())
               .pipe(gulp.dest('./public/assets'));
});

gulp.task('sass:watch', () => {
    gulp.watch('./resources/sass/**/*.scss', ['sass']);
});