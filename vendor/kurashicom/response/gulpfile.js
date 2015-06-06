var gulp = require('gulp');
var exec = require('child_process').exec;
var sys  = require('sys');
var phpunit = require('gulp-phpunit');
var argv = require('yargs').argv;
var running = false;

gulp.task('rsync', function () {
    exec('app sync_push response-module-laravel', function(error, stdout) {
        console.log(stdout);
    });
});

gulp.task('phplint', function (done) {
    exec('find ./src ./tests -type f -name "*.php" | xargs -n 1 php -d display_errors=1 -l | grep -v "No syntax errors"', function(error, stdout) {
        console.log(stdout);
        done();
    });
});

gulp.task('exec-phpcsfixer', ['phplint'], function (done) {
    exec('php vendor/fabpot/php-cs-fixer/php-cs-fixer fix --verbose', function(error, stdout) {
        console.log(stdout);
        done();
    });
});

gulp.task('phpcsfixer', ['exec-phpcsfixer'], function (done) {
    exec('curl http://'+argv.ip+':'+argv.port, function(error, stdout) {
        console.log(stdout);
        done();
    });
});

gulp.task('phpunit', ['phpcsfixer'], function() {
    gulp.src('phpunit.xml')
    .pipe(phpunit('./vendor/phpunit/phpunit/phpunit'))
    .on('end', function() {
        running = false;
     })
    .on('error', function(error){
        running = false;
    });
});

// watch tasks
gulp.task('watch-rsync', function () {
    gulp.watch(['src/**/*.php', 'tests/**/*.php'], ['rsync']);
});

gulp.task('watch-phpunit', function () {
    gulp.watch(['src/**/*.php', 'tests/**/*.php'], { interval: 500 }, function () {
        if (! running) {
            running = true;
            gulp.start('phpunit');
        }
    });
});

// main tasks
gulp.task('sync', ['rsync', 'watch-rsync']);
gulp.task('test', ['watch-phpunit']);
