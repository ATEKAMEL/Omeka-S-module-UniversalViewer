'use strict';

const gulp = require('gulp');
const del = require('del');
const fs = require('fs');
const glob = require("glob");
const rename = require("gulp-rename");
const replace = require('gulp-string-replace');

const bundle = [
    {
        'source': 'node_modules/universalviewer/dist/uv-*/**',
        'dest': 'asset/vendor/uv',
    },
];

gulp.task('clean', function(done) {
    bundle.forEach(function (module) {
        return del.sync(module.dest);
    });
    done();
});

gulp.task('sync', function (done) {
    bundle.forEach(function (module) {
        gulp.src(module.source)
            .pipe(gulp.dest(module.dest))
            .on('end', done);
    });
});

// The dist is unknown, so it should be renamed.
const rename_uv = function(done) {
    var file = glob.sync('asset/vendor/uv/uv-*/');
    fs.renameSync(file[0], 'asset/vendor/uv_dist/');
    del.sync('asset/vendor/uv/');
    fs.renameSync('asset/vendor/uv_dist/', 'asset/vendor/uv/');
    done();
};

// Avoid a warning for unknown charset in a iframe.
const hack_uv = function (done) {
    gulp.src(['asset/vendor/uv/app.html'])
        .pipe(replace(
            /^<head>$/gm,
            '<head>' + "\n" + '    <meta charset="UTF-8">'
        ))
        .pipe(gulp.dest('asset/vendor/uv/'))
        .on('end', done);
};

gulp.task('default', gulp.series('clean', 'sync', rename_uv, hack_uv));

gulp.task('install', gulp.task('default'));

gulp.task('update', gulp.task('default'));
