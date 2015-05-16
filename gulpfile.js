var gulp = require('gulp');
var exec = require('child_process').exec;
var sys  = require('sys');
var phpunit = require('gulp-phpunit');

gulp.task('rsync', function() {
    exec('myapp sync_push feed-app-lumen', function(error, stdout){
        console.log(stdout);
    });
});

gulp.task('phpunit', function() {
    gulp.src('phpunit.xml')
    .pipe(phpunit('./vendor/phpunit/phpunit/phpunit'))
    .on('error', function(error){
        console.log(error);
    });
});

gulp.task('phplint', function () {
    exec('find ./app ./tests -type f -name "*.php" | xargs -n 1 php -d display_errors=1 -l | grep -v "No syntax errors"', function(error, stdout) {
        console.log(stdout);
    });
});

gulp.task('watch-rsync', function () {
    gulp.watch(['app/**/*.php', 'tests/**/*.php'], ['rsync']);
});

gulp.task('watch-phpunit', function () {
    gulp.watch(['tests/**/*.php'], { interval: 500 }, ['phplint', 'phpunit']);
});

gulp.task('sync', ['rsync', 'watch-rsync']);
gulp.task('test', ['phpunit', 'watch-phpunit']);
