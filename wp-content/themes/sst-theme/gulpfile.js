var gulp = require('gulp');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var rename = require("gulp-rename");
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var cleanCSS = require('gulp-clean-css');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
const jshint = require('gulp-jshint');
var cache = require('gulp-cached');
var sassLint = require('gulp-sass-lint');
var gcmq = require('gulp-group-css-media-queries');

gulp.task('scss-lint', function () {
    return gulp.src('assets/scss/**/*.s+(a|c)ss')
        .pipe(sassLint({
            options: {
                formatter: 'stylish',
                'merge-default-rules': false
            }
        }))
        .pipe(sassLint.format())
        .pipe(sassLint.failOnError())
});

gulp.task('sass', function () {
    gulp.src('assets/scss/sst-theme.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(autoprefixer({browsers: ['last 5 versions']}))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('assets/css'));
});

gulp.task('sass-prod', function () {
    gulp.src('assets/scss/sst-theme.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({browsers: ['last 5 versions']}))
        .pipe(gcmq())
        .pipe(rename({suffix: '.min'}))
        .pipe(cleanCSS({keepSpecialComments: 0, debug: true}, function (details) {
            console.log(details.name + ': ' + details.stats.originalSize);
            console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('sass-home8', function () {
    gulp.src('assets/scss/pages/sst-home8.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({browsers: ['last 5 versions']}))
        .pipe(gcmq())
        .pipe(rename({suffix: '.min'}))
        .pipe(cleanCSS({keepSpecialComments: 0, debug: true}, function (details) {
            console.log(details.name + ': ' + details.stats.originalSize);
            console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('sass-home9', function () {
    gulp.src('assets/scss/pages/sst-home9.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({browsers: ['last 5 versions']}))
        .pipe(gcmq())
        .pipe(rename({suffix: '.min'}))
        .pipe(cleanCSS({keepSpecialComments: 0, debug: true}, function (details) {
            console.log(details.name + ': ' + details.stats.originalSize);
            console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('sst-showcase-home', function () {
    gulp.src('assets/scss/pages/sst-showcase-home.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({browsers: ['last 5 versions']}))
        .pipe(gcmq())
        .pipe(rename({suffix: '.min'}))
        .pipe(cleanCSS({keepSpecialComments: 0, debug: true}, function (details) {
            console.log(details.name + ': ' + details.stats.originalSize);
            console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('sass-location2', function () {
    gulp.src('assets/scss/pages/sst-location2.scss')
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(autoprefixer({browsers: ['last 5 versions']}))
        .pipe(gcmq())
        .pipe(rename({suffix: '.min'}))
        .pipe(cleanCSS({keepSpecialComments: 0, debug: true}, function (details) {
            console.log(details.name + ': ' + details.stats.originalSize);
            console.log(details.name + ': ' + details.stats.minifiedSize);
        }))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('images', function () {
    return gulp.src('assets/images/*')
        .pipe(imagemin({
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            use: [pngquant()]
        }))
        .pipe(gulp.dest('assets/images'));
});

gulp.task('scripts', function () {
    return gulp.src([
        'assets/js/slick.js',
        'assets/js/jquery.slimmenu.js',
        'assets/js/jquery.matchHeight.js',
        'assets/js/jquery.fancybox.js',
        'assets/js/simplecalendar.js',
        'assets/js/easy-responsive-tabs.js'
    ])
        .pipe(concat('plugins.js'))
        .pipe(gulp.dest('assets/js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(function (file) {
            return file.base;
        }));
});

gulp.task('custom-scripts', function () {
    return gulp.src([
        'assets/js/scripts.js',
        'assets/js/landing-page.js',
        'assets/js/showcase.js'
    ])
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(function (file) {
            return file.base;
        }));
});

gulp.task('lint', function () {
    return gulp.src('assets/js/scripts.js')
        .pipe(jshint())
        .pipe(jshint.reporter('jshint-stylish', {verbose: true}));
});

gulp.task('watch', function () {
    return gulp
        .watch('assets/scss/**/*.scss', ['sass'])
});

gulp.task('default', ['scss-lint', 'sass', 'images', 'scripts', 'watch']);
gulp.task('prod', ['sass', 'sass-prod', 'sass-home8', 'sass-home9', 'sst-showcase-home', 'sass-location2', 'scripts', 'custom-scripts']);