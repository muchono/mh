var gulp = require('gulp'),
    watch = require('gulp-watch'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    spritesmith = require("gulp.spritesmith"),
    sourcemaps = require('gulp-sourcemaps'),
    browserSync = require('browser-sync').create();

// Static browser sync server
gulp.task('bs', function() {
    browserSync.init({
        server: {
            baseDir: "./public/"
        }
    });
});

// Compile SCSS
gulp.task('scss', function () {
    gulp.src('./public/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({
            style: 'expanded',
            sourceComments: 'map',
            sourceMap: 'sass',
            includePaths: ['./public/vendor/bourbon/app/assets/stylesheets/', './public/vendor/reset-css/']
        }).on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 15 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./public/css'));
});

// Sprite
gulp.task('sprite', function() {
    var spriteData = gulp.src('./public/img/sprite/*.*')
    .pipe(spritesmith({
        imgName: 'sprite.png',
        imgPath: '../img/sprite.png',
        cssName: '_sprite.scss',
        cssFormat: 'scss',
        algorithm: 'left-right'
    }));

    spriteData.img.pipe(gulp.dest('./public/img/'));
    spriteData.css.pipe(gulp.dest('./public/scss/'));
});

// Watch
gulp.task('watch', function() {
    watch('./public/img/sprite/**/*', function () {
        gulp.start('sprite');
    });
    watch('./public/scss/**/*.scss', function () {
        gulp.start('scss');
    });
    gulp.watch(['public/css/*.*','public/*.html','public/js/*.*']).on('change', browserSync.reload);
});

// Default
gulp.task('default', ['bs', 'watch']);