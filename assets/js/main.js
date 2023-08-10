axios.defaults.baseURL = 'http://127.0.0.1:8080/fitssru_virtualexhibitions/service/api'
const TOKEN = localStorage.getItem('auth_token') || false
const AUTH_DATA = isObject(localStorage.getItem('auth_data'));
function isObject(obj) {
    try {
        const auth = JSON.parse(obj)
        return auth.constructor == Object ? auth : false
    } catch (e) {
        return false
    }
}

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}
