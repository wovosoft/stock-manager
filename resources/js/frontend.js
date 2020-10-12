import axios from "axios";

window.axios = axios;
import 'alpinejs'

function updateState(qs) {
    let params = new URLSearchParams((new URL(window.location.href)).search.slice(1));
    for (let x in qs) params.set(x, encodeURI(qs[x]));
    window.history.replaceState('', '', '?' + params.toString());
}

function wovo(url, method, data, state, rid, cb = null, fb = null) {
    if (state) updateState(state);
    return axios.post(url, {...data, method: method})
        .then(function (res) {
            if (rid) {
                let out = document.querySelector('[x-ref="' + rid + '"]');
                if (out) {
                    out.innerHTML = res.data;
                }
            }
            if (typeof cb === 'function') {
                cb(res);
            }
        })
        .catch(function (err) {
            console.warn(err.response);
            if (typeof fb === 'function') {
                fb(err.response);
            }
        })
}

window.wovo = wovo;
