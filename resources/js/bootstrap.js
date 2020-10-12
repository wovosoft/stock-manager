// _ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// try {
//     // Popper = require('popper.js').default;
//     // $ = jQuery = require('jquery');

//     // require('bootstrap');
// } catch (e) {
// }

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.interceptors.request.use(function (config) {
    // Do something before request is sent
    // console.log("request sending");
    if (document.getElementById('main-loader'))
        document.getElementById('main-loader').classList.remove('d-none');
    return config;
}, function (error) {
    // Do something with request error
    // console.log("error in sending request");
    if (document.getElementById('main-loader'))
        document.getElementById('main-loader').classList.add('d-none')
    return Promise.reject(error);
});

// Add a response interceptor
window.axios.interceptors.response.use(function (response) {
    // Do something with response data
    // console.log("received response");
    if (document.getElementById('main-loader'))
        document.getElementById('main-loader').classList.add('d-none')
    return response;
}, function (error) {
    // Do something with response error
    // console.log("error in response");
    if (document.getElementById('main-loader'))
        document.getElementById('main-loader').classList.add('d-none');
    //code to use for for unauthenticated requests
    //419 : Unknown Status
    //401 : Unauthenticated Status
    if (error.response.status === 401 || error.response.status === 419) {
        console.log("Not Logged in")
        location.href = location.origin;
    }
    return Promise.reject(error);
});


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from "laravel-echo"
// import Pusher from "pusher-js";

// Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
// Pusher.logToConsole = true;


