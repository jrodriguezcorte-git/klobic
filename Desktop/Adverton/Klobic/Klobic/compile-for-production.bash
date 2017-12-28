uglifyjs --compress --mangle -o config/settings.min.js -- config/settings.js

uglifyjs --compress --mangle -o admin/actions.min.js -- admin/actions.js

uglifyjs --compress --mangle -o js/feedback.min.js -- js/app/feedback.js

uglifyjs --compress --mangle -o js/creator.min.js -- js/app/creator.js
minify -o css/creator.min.css -- css/app/creator.css

uglifyjs --compress --mangle -o js/functions.min.js -- js/app/functions.js

uglifyjs --compress --mangle -o js/global.min.js -- js/app/global.js
minify -o css/global.min.css -- css/app/global.css
minify -o css/main.min.css -- css/app/main.css

uglifyjs --compress --mangle -o js/session.min.js -- js/app/session.js
minify -o css/session.min.css -- css/app/session.css

uglifyjs --compress --mangle -o js/vendors.min.js -- js/app/vendors.js
uglifyjs --compress --mangle -o js/lang/en.min.js -- js/app/lang/en.js
uglifyjs --compress --mangle -o js/user/loginSignup.min.js -- js/app/user/loginSignup.js

uglifyjs --compress --mangle -o js/embed/embed.min.js -- js/app/embed/embed.js
minify -o css/embed/embed.min.css css/app/embed/embed.css

uglifyjs --compress --mangle -o js/iframe/embed.min.js -- js/app/iframe/embed.js
uglifyjs --compress --mangle -o js/iframe/embed_float.min.js -- js/app/iframe/embed_float.js
