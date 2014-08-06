var gulp = require('gulp'),
    compass = require('gulp-compass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    svgmin = require('gulp-svgmin');
    rename = require('gulp-rename'),
    clean = require('gulp-clean'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    cheerio = require('gulp-cheerio'),
    livereload = require('gulp-livereload'),
    lr = require('tiny-lr'),
    server = lr(),
    jsonlint = require("gulp-jsonlint");

    require('gulp-grunt')(gulp);

gulp.task('styles', function() {
  return gulp.src('sass/*.scss')
    .pipe(compass({ style: 'expanded', font: 'fonts', sourcemaps: true }))
    .pipe(autoprefixer('last 3 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('css'))
    .pipe(livereload(server))
    ;//.pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('icomoon', function() {
  return gulp.src('icomoon/**/*')
    .pipe(gulp.dest('css/icomoon'))
    .pipe(livereload(server))
    ;//.pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('scripts-clean', function() {
  return gulp.src(['javascript/facetedsearch.js', 'javascript/script.js'])
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'))
    ;//.pipe(notify({ message: 'Scripts task complete' }));
});


gulp.task('json', function() {
  return gulp.src("js/*.json")
    .pipe(jsonlint())
    .pipe(jsonlint.reporter());
});

gulp.task('scripts', function() {
  return gulp.src(['javascript/jquery.js', 'javascript/underscore.js', 'javascript/details.js', 'javascript/facetedsearch.js', 'javascript/script.js'])
    .pipe(concat('js/main.js'))
    .pipe(gulp.dest(''))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest(''))
    .pipe(livereload(server))
    ;//.pipe(notify({ message: 'Scripts task complete' }));
});

gulp.task('fonts', function() {
  return gulp.src('src/fonts/**/*')
    .pipe(gulp.dest('fonts'))
    ;//.pipe(notify({ message: 'Fonts task complete' }));
});

gulp.task('modernizr', function() {
  return gulp.src(['javascript/modernizr.js'])
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('js'))
    .pipe(livereload(server))
    ;//.pipe(notify({ message: 'Modernizr task complete' }));
});

gulp.task('images', function() {
  return gulp.src('images/**/*.png')
    .pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
    .pipe(gulp.dest('dist/assets/img'))
    .pipe(livereload(server))
    ;//.pipe(notify({ message: 'Images task complete' }));
});

gulp.task('svg', function() {
    gulp.src('images/*.svg')
        .pipe(cache(svgmin()))
        .pipe(gulp.dest('img'))
        ;//.pipe(notify({ message: 'SVG task complete' }));
});

gulp.task('addlivereloadscript', function () {
  return gulp
    .src(['src/*.html'])
    //.pipe(gulp.dest('dist/'))
    .pipe(cheerio({
      run: function ($) {
        // Each file will be run through cheerio and each corresponding `$` will be passed here.
        /*$('body').each(function () {
          $(this).append("<script>document.write('<script src=\"http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1\"></' + 'script>')</script>");
        });*/
      }
    }))
    .pipe(gulp.dest(''));
});

gulp.task('clean', function() {
  return gulp.src(['css', 'js', 'img'], {read: false})
    .pipe(clean());
});

gulp.task('default', ['clean'], function() {
    gulp.run('grunt-modernizr');
    gulp.run('addlivereloadscript', 'styles', 'icomoon', 'scripts-clean', 'scripts', 'modernizr', 'images', 'svg', 'fonts');
});

gulp.task('watch', function() {
    // Listen on port 35729
      server.listen(35729, function (err) {
        if (err) {
          return console.log(err)
        };

  gulp.watch('src/*.html', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('addlivereloadscript');
  });

  gulp.watch('src/fonts/*', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('fonts');
  });

  // Watch .scss files
  gulp.watch('sass/**/*.scss', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('styles');
  });

  // Watch .js files
  gulp.watch('javascript/**/*.js', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('modernizr');
    gulp.run('scripts-clean');
    gulp.run('scripts');
  });

  gulp.watch('js/*.json', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('json');
  });

  // Watch image files
  gulp.watch('images/**/*', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('svg');
    gulp.run('images');
  });

  // Watch icomoon files
  gulp.watch('icomoon/**/*', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.run('icomoon');
  });

});

});
