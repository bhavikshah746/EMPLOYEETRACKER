/*
|----------------------------------------------------
|GULP PACKAGES
|----------------------------------------------------
*/
var gulp  = require('gulp'),
    gutil = require('gulp-util');
    uglify = require('gulp-uglify');
    path = require('path');
    less = require('gulp-less');
    concat = require('gulp-concat');
    minify = require('gulp-minify-css');
    rev = require('gulp-rev');
    watch = require('gulp-watch');
    htmlmin = require('gulp-htmlmin');
/*
|----------------------------------------------------
|DEFAULT TASK
|----------------------------------------------------
*/
gulp.task('default', function() {
  return gutil.log('Gulp is running!')
});
/*
|----------------------------------------------------
|MINIFY JS
|----------------------------------------------------
*/

//array Admin
var jsArrayAdmin=[
    'resources/assets/js/vendor/jquery.min.js',
    'resources/assets/js/vendor/datatable.js',
    'resources/assets/js/vendor/chosen.js',
    'resources/assets/js/vendor/select2.full.js',
    'resources/assets/js/vendor/bootstrap-datetimepicker.min.js',
    'resources/assets/js/admin/master.js',
];
gulp.task('js',function(){
    return gulp.src(jsArrayAdmin)
    .pipe(concat('app.js'))
    .pipe(uglify())
    .pipe(rev())
    .pipe(gulp.dest('public/js/'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('public/js/'))
});
gulp.task('js-dev-admin',['watch-js-admin']);
gulp.task('watch-js-admin',function(){
    gutil.log('JS GENERATED !');
    return gulp.src(jsArrayAdmin)
    .pipe(concat('app.js'))
    .pipe(gulp.dest('public/js/admin/'))
});


/*
|----------------------------------------------------
|MINIFY CSS
|----------------------------------------------------
*/
var cssArrayAdmin = [
    'resources/assets/less/vendor/bootstrap.css',
    'resources/assets/less/vendor/datedropper.css',
    'resources/assets/less/vendor/datatable.css',
    'resources/assets/less/vendor/chosen.css',
    'resources/assets/less/vendor/select2.css',
    'resources/assets/less/vendor/bootstrap-datetimepicker.css',
    'resources/assets/less/admin/config.less',
    'resources/assets/less/admin/sevenspan.less',
    'resources/assets/less/admin/header_half_menu.less',
    'resources/assets/less/admin/footer.less',
    'resources/assets/less/admin/sidebar.less',
    'resources/assets/less/admin/common.less',
    'resources/assets/less/admin/page_kitchen.less',
    'resources/assets/less/admin/page_orders.less',
    'resources/assets/less/admin/page_tables.less',
    'resources/assets/less/admin/popup_items.less',
    'resources/assets/less/admin/popup_takeaways.less',
];
gulp.task('css', function(){
    return gulp.src(cssArrayAdmin)
    .pipe(concat('style.css'))
    .pipe(less())
    .pipe(minify())
    .pipe(rev())
    .pipe(gulp.dest('public/css/'))
    .pipe(rev.manifest())
    .pipe(gulp.dest('public/css/'))
});
gulp.task('css-dev-admin',['watch-css-admin']);
gulp.task('watch-css-admin', function(){ 
    gutil.log('CSS GENERATED !');
    return gulp.src(cssArrayAdmin)
    .pipe(concat('style.css'))
    .pipe(less())
    .pipe(gulp.dest('public/css/admin/'))
});
/*
|----------------------------------------------------
|MINIFY HTML
|----------------------------------------------------
*/
gulp.task('html', function() {
    var opts = {
      collapseWhitespace:true,
      removeAttributeQuotes:false,
      minifyJS:true,
      minifyCSS:true,
      removeComments:true,
    };
    return gulp.src('./storage/framework/views/*')
               .pipe(htmlmin(opts))
               .pipe(gulp.dest('./storage/framework/views/'));
});
/*
|----------------------------------------------------
|WATCH CSS
|----------------------------------------------------
*/
gulp.task('watch', function() {
    gulp.watch('resources/assets/less/**/*.less', ['watch-css-admin']);
    gulp.watch('resources/assets/js/**/*.js', ['watch-js-admin']);
});
