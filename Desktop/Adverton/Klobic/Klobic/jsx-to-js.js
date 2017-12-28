import http from 'http';
import * as babel from 'babel-core';
import fs from 'fs';

// var code = babel.transform(`var Nav;
// // Input (JS):
// var app = React.createElement(Nav, {color:"blue"});`, {
//     plugins: [
//         "babel-transform-js-to-jsx",
//         "babel-transform-js-to-jsx/es6/modules",
//         "babel-transform-js-to-jsx/es6/arrow-functions",
//         "babel-transform-js-to-jsx/es6/remove-dom-shim",
//         "babel-transform-js-to-jsx/es6/unhoist-variables",
//         "transform-react-createelement-to-jsx",
//         "syntax-jsx"
//     ]
// }).code
// console.log(code);

babel.transformFile("js/editor.gz.js", {
    plugins: [
        "babel-transform-js-to-jsx",
        "babel-transform-js-to-jsx/es6/modules",
        "babel-transform-js-to-jsx/es6/arrow-functions",
        "babel-transform-js-to-jsx/es6/remove-dom-shim",
        // "babel-transform-js-to-jsx/es6/unhoist-variables",
        "transform-react-createelement-to-jsx",
        "syntax-jsx"
    ]
}, function(err, result) {
	// console.log(err);
    fs.writeFile("js/editor.js", result.code, function(err) {
        if(err) {
            return console.log(err);
        }

        console.log("The file was saved!");
    });
    // console.log(err, result); // => { code, map, ast }
});

http.createServer((req, res) => {
    res.writeHead(200, {'Content-Type': 'text/plain'});
    res.end('Hello World\n');
}).listen(1337, '127.0.0.1');

console.log('Server running at http://127.0.0.1:1337/');
