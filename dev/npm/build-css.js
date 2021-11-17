const fs = require('fs');
let pkg = JSON.parse(fs.readFileSync('package.json', 'utf8'));

const sass = require('sass');

sass.render({
    file: pkg.theme_src_dir+'/sass/default.scss',
    outFile:pkg.theme_dist_dir+'/css/default.css',
    outputStyle:'compressed',
    precision:10,
}, function(err, result) {
    if(!err){
        // No errors during the compilation, write this result on the disk
        fs.writeFile(pkg.theme_dist_dir+'/css/default.css', result.css, function(err){
            if(!err){
                //file written on disk
            } else console.log(err);
        });
    } else console.log(err);
});
