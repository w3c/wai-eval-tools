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
    insert = require('gulp-insert'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    cheerio = require('gulp-cheerio'),
    livereload = require('gulp-livereload'),
    jsonlint = require("gulp-jsonlint"),
    modernizr = require('gulp-modernizr');

gulp.task('styles', function() {
  return gulp.src('sass/*.scss')
    .pipe(compass({ style: 'expanded', font: 'fonts', sourcemaps: true }))
    .pipe(autoprefixer('last 3 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(gulp.dest('css'))
    .pipe(rename({suffix: '.min'}))
    .pipe(minifycss())
    .pipe(gulp.dest('css'))
    .pipe(livereload())
    ;//.pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('icomoon', function() {
  return gulp.src('icomoon/**/*')
    .pipe(gulp.dest('css/icomoon'))
    .pipe(livereload())
    ;//.pipe(notify({ message: 'Styles task complete' }));
});

gulp.task('json', function() {
  return gulp.src("data/**/*")
    .pipe(concat('data.json', {newLine: ','}))
    .pipe(insert.wrap('[', ']'))
    .pipe(jsonlint())
    .pipe(jsonlint.reporter())
    .pipe(gulp.dest('js'));
});

var hintscripts = ['javascript/facetedsearch.js', 'javascript/sharebox.js', 'javascript/script.js'];

gulp.task('scripts-clean', function() {
  return gulp.src(hintscripts)
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'))
    ;//.pipe(notify({ message: 'Scripts task complete' }));
});

var javascripts = ['javascript/jquery.js', 'javascript/underscore.js', 'javascript/uri.js', 'javascript/details.js', 'javascript/facetedsearch.js', 'javascript/sharebox.js', 'javascript/script.js'];

gulp.task('scripts', gulp.series('scripts-clean', function() {
  return gulp.src(javascripts)
    .pipe(concat('main.js'))
    .pipe(gulp.dest('js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('js'))
    .pipe(modernizr({
    // Avoid unnecessary builds (see Caching section below)
    "cache" : true,

    // Path to the build you're using for development.
    "devFile" : false,

    // Path to save out the built file
    "dest" : false,

    // Based on default settings on http://modernizr.com/download/
    "options" : [
        "setClasses",
        "addTest",
        "html5printshiv",
        "testProp",
        "fnBind",
        "isSVG"
    ],

    // Define any tests you want to explicitly include
    "tests" : [],

    // Useful for excluding any tests that this tool will match
    // e.g. you use .notification class for notification elements,
    // but don’t want the test for Notification API
    "excludeTests": [],

    // By default, will crawl your project for references to Modernizr tests
    // Set to false to disable
    "crawl" : true,

    // Set to true to pass in buffers via the "files" parameter below
    "useBuffers" : false,

    // By default, this task will crawl all *.js, *.css, *.scss files.
    "files" : {
        "src": [
            "*[^(g|G)(runt|ulp)(file)?].{js,css,scss}",
            "**[^node_modules]/**/*.{js,css,scss}",
            "!lib/**/*"
        ]
    },

    // Have custom Modernizr tests? Add them here.
    "customTests" : []
}))
    .pipe(livereload())
    ;//.pipe(notify({ message: 'Scripts task complete' }));
}));

gulp.task('fonts', function() {
  return gulp.src('src/fonts/**/*')
    .pipe(gulp.dest('fonts'))
    ;//.pipe(notify({ message: 'Fonts task complete' }));
});

gulp.task('images', function() {
  return gulp.src('images/**/*.png')
    .pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
    .pipe(gulp.dest('dist/assets/img'))
    .pipe(livereload())
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

gulp.task('default', function() {
    gulp.series('addlivereloadscript', 'styles', 'icomoon', 'scripts-clean', 'scripts', 'images', 'svg', 'fonts');
});

gulp.task('watch', function() {

  gulp.watch('src/*.html', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.series('addlivereloadscript');
  });

  gulp.watch('src/fonts/*', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.series('fonts');
  });

  // Watch .scss files
  gulp.watch('sass/**/*.scss', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.series('styles');
  });

  // Watch .js files
  gulp.watch('javascript/**/*.js', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.series('scripts');
  });

  gulp.watch(['js/*.json','data/**/*'], function(event, path, stats) {
    console.log('File ' + path + ' was ' + event + ', running tasks...');
    gulp.series('json');
  });

  // Watch image files
  gulp.watch('images/**/*', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.series('svg');
    gulp.series('images');
  });

  // Watch icomoon files
  gulp.watch('icomoon/**/*', function(event) {
    console.log('File ' + event.path + ' was ' + event.type + ', running tasks...');
    gulp.series('icomoon');
  });

});
