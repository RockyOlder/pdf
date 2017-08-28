var gulp            = require("gulp"),
    sequence        = require("gulp-sequence"),//顺序执行
    jsHint          = require("gulp-jshint"),//js语法检测
    minImage        = require("gulp-imagemin"),//图片压缩
    minImageForPng  = require("imagemin-pngquant"),//图片压缩（png）
    minCss          = require("gulp-clean-css"),//css压缩
    minJs           = require("gulp-uglify"),//js压缩
    minHtml         = require("gulp-htmlmin"),//html压缩（js、css压缩）
    minHtmlForJT   = require("gulp-minify-html"),//html压缩（js模板压缩）
    rev             = require("gulp-rev"),//MD5版本号
    revappend       = require('gulp-rev-append'),//MD5版本号
    revCollector    = require("gulp-rev-collector"),//版本替换
    cache           = require("gulp-cache"),//缓存
    clean           = require('gulp-clean');
//配置
var config = {
    //资源文件
    source: {
        //源文件
        src: {
          //  font:   "src/fonts/*",
            css:    "Public/Tpl/v78/chocolate/css/*.css",
            js:     "Public/Tpl/v78/chocolate/js/**/*.js",
            images: "Public/Tpl/v78/chocolate/images/**/*.{png,jpg,gif,ico}",
            img:    "Public/Tpl/v78/chocolate/img/*.{png,jpg,gif,ico}",
            html:   "Public/Tpl/v78/chocolate/*.html",
            layout: "Tpl/Home/layout.html"
        },
        //MD5版本号文件
        rev: {
         //   font:   "rev/fonts/*.json",
            css:    "rev/css/*.json",
            js:     "rev/js/*.json"
        },
        //替换版本后的文件
        revCollector: {
            css:    "revCollector/css/*.css",
            html:   "revCollector/html/**/*.html",
            layout: "revCollector/*.html"
        }
    },
    //目录
    dir: {
        //MD5版本号文件目录
        rev: {
          //  font:   "rev/fonts",
            css:    "rev/css",
            js:     "rev/js"
        },
        //替换版本后的文件目录
        revCollector: {
            css: "revCollector/css",
            html: "revCollector/html",
            layout: "revCollector/",
            remove:'./revCollector'
        },
        //正式文件目录
        dist: {
            css:    "Public/Tpl/v78/dist/css",
            js:     "Public/Tpl/v78/dist/js",
            images: "Public/Tpl/v78/dist/images",
            html:   "Public/Tpl/v78/dist/",
            img:    "Public/Tpl/v78/dist/img",
            layout: "Tpl/Home/Dist/"
        }
    }
};

//任务
var task = {
    jsHint: "jsHint",
 //   revFont: "revFont",
    revCss: "revCss",
    revAjaxJs: "revAjaxJs",
    revJs: "revJs",
    revCollectorCss: "revCollectorCss",
    revCollectorHtml: "revCollectorHtml",
    revCollectorlayout: "revCollectorlayout",
    minCss: "minCss",
    minAjaxJs: "minAjaxJs",
    minJs: "minJs",
    minHtml: "minHtml",
    minImage: "minImage",
    minimg: "minimg",
    dirlayout: "dirlayout",
    clean:"clean"
};

//js语法检测
gulp.task(task.jsHint, function () {
    gulp.src([config.source.src.js])
        .pipe(jshint())
        .pipe(jshint.reporter());
});

//MD5版本号
//gulp.task(task.revFont, function () {
//    return gulp.src(config.source.src.font)
//        .pipe(rev())
//        .pipe(rev.manifest())
//        .pipe(gulp.dest(config.dir.rev.font));
//});
gulp.task(task.revCss, function () {
    return gulp.src(config.source.src.css)
        .pipe(rev())   //MD5加密串
        .pipe(rev.manifest()) //生产加密json  对一关系
        .pipe(gulp.dest(config.dir.rev.css));  //输出文件目录
});

gulp.task(task.revJs, function () {
    return gulp.src(config.source.src.js)
        .pipe(rev())
        .pipe(rev.manifest())
        .pipe(gulp.dest(config.dir.rev.js));
});

//版本替换
/**
 *  对插件进行如下修改，使得引用资源文件的url得以如下变换：
 *  "/css/base-f7e3192318.css" >> "/css/base.css?v=f7e3192318"
 *
 *  gulp-rev 1.0.5
 *  node_modules\gulp-rev\index.js
 *  144 manifest[originalFile] = revisionedFile; => manifest[originalFile] = originalFile + '?v=' + file.revHash;
 *
 *  gulp-rev 1.0.5
 *  node_modules\gulp-rev\node_modules\rev-path\index.js
 *  10 return filename + '-' + hash + ext; => return filename + ext;
 *
 *  gulp-rev-collector 7.1.0
 *  node_modules\gulp-rev-collector\index.js
 *  31 if ( !_.isString(json[key]) || path.basename(json[key]).replace(new RegExp( opts.revSuffix ), '' ) !==  path.basename(key) ) { =>
 *  if ( path.basename(json[key]).split('?')[0] !== path.basename(key) ) {
 *
 */
gulp.task(task.clean, function(){
    return gulp.src('./revCollector')
        .pipe(clean());
});
gulp.task(task.revCollectorCss, function () {
    return gulp.src([config.source.src.css])
        .pipe(revCollector({}))
        .pipe(gulp.dest(config.dir.revCollector.css));
});
gulp.task(task.revCollectorHtml, function () {
    return gulp.src([config.source.rev.css, config.source.rev.js, config.source.src.html])
        .pipe(revCollector())
        .pipe(gulp.dest(config.dir.revCollector.html));
});
gulp.task(task.revCollectorlayout, function () {
    return gulp.src([config.source.rev.css, config.source.rev.js, config.source.src.layout])
        .pipe(revCollector())
        .pipe(gulp.dest(config.dir.revCollector.layout));
});
//压缩文件
gulp.task(task.minCss, function () {
    return gulp.src(config.source.revCollector.css)
        .pipe(minCss())   //压缩CSS
        .pipe(gulp.dest(config.dir.dist.css));
});
gulp.task(task.minJs, function () {
    return gulp.src(config.source.src.js)
        .pipe(minJs()) //压缩JS
        .pipe(gulp.dest(config.dir.dist.js));
});
//gulp.task(task.disFont, function () {
//    return gulp.src(config.source.src.font)
//        .pipe(gulp.dest(config.dir.dist.font));
//});
////压缩HTML
gulp.task(task.minHtml, function () {
    return gulp.src([config.source.revCollector.html])
       // .pipe(minHtmlForJT())//附带压缩页面上的js模板
//        .pipe(minHtml({
//            removeComments: true,
//            collapseWhitespace: true,
//            collapseBooleanAttributes: true,
//            removeEmptyAttributes: true,
//            removeScriptTypeAttributes: true,
//            removeStyleLinkTypeAttributes: true,
//            minifyJS: true,
//            minifyCSS: true
//        }))//附带压缩页面上的css、js
        .pipe(gulp.dest(config.dir.dist.html));
});
//压缩图片
gulp.task(task.minImage, function () {
    return gulp.src(config.source.src.images)
        .pipe(cache(minImage({
            progressive: true,
            use: [minImageForPng()]
        })))
        .pipe(gulp.dest(config.dir.dist.images));
});
gulp.task(task.minimg, function () {
    return gulp.src(config.source.src.img)
        .pipe(cache(minImage({
            progressive: true,
            use: [minImageForPng()]
        })))
        .pipe(gulp.dest(config.dir.dist.img));
});
gulp.task(task.dirlayout, function () {
    return gulp.src([config.source.revCollector.layout])
        .pipe(gulp.dest(config.dir.dist.layout));
});
//正式构建
gulp.task("build", sequence(
    //js语法检测
    //[task.jsHint],
    //MD5版本号
    [task.revCss, task.revJs],
    //版本替换
    [task.revCollectorCss, task.revCollectorHtml,task.revCollectorlayout],
    //压缩文件
    [task.minCss, task.minJs, task.minHtml, task.minImage, task.minimg,task.dirlayout]
));


gulp.task("default", ["build"], function () {
    return gulp.src(config.dir.revCollector.remove)
        .pipe(clean());
});