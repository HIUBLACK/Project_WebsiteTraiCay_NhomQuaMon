(function (window) {
    'use strict';

    var TOKEN_KEY = 'access_token';
    var USER_KEY = 'auth_user';

    function parseJsonSafely(value) {
        if (!value) {
            return null;
        }

        try {
            return JSON.parse(value);
        } catch (error) {
            return null;
        }
    }

    function getToken() {
        return window.localStorage.getItem(TOKEN_KEY);
    }

    function getUser() {
        return parseJsonSafely(window.localStorage.getItem(USER_KEY));
    }

    function setAuth(data) {
        if (data && data.access_token) {
            window.localStorage.setItem(TOKEN_KEY, data.access_token);
        }

        if (data && data.user) {
            window.localStorage.setItem(USER_KEY, JSON.stringify(data.user));
        }

        return data;
    }

    function clearAuth() {
        window.localStorage.removeItem(TOKEN_KEY);
        window.localStorage.removeItem(USER_KEY);
    }

    function buildHeaders(customHeaders, hasBody) {
        var headers = Object.assign({
            'Accept': 'application/json'
        }, customHeaders || {});

        if (hasBody) {
            headers['Content-Type'] = 'application/json';
        }

        var token = getToken();
        if (token) {
            headers.Authorization = 'Bearer ' + token;
        }

        return headers;
    }

    function request(url, options) {
        var config = options || {};
        var hasBody = typeof config.body !== 'undefined' && config.body !== null;

        return window.fetch(url, {
            method: config.method || 'GET',
            headers: buildHeaders(config.headers, hasBody),
            body: hasBody ? JSON.stringify(config.body) : undefined
        }).then(function (response) {
            return response.json().catch(function () {
                return {};
            }).then(function (data) {
                if (!response.ok) {
                    var error = new Error(data.message || 'Yeu cau API that bai.');
                    error.status = response.status;
                    error.data = data;
                    throw error;
                }

                return data;
            });
        });
    }

    function register(payload) {
        return request('/api/auth/register', {
            method: 'POST',
            body: payload
        }).then(setAuth);
    }

    function login(payload) {
        return request('/api/auth/login', {
            method: 'POST',
            body: payload
        }).then(setAuth);
    }

    function me() {
        return request('/api/auth/me').then(function (data) {
            if (data && data.user) {
                window.localStorage.setItem(USER_KEY, JSON.stringify(data.user));
            }

            return data;
        });
    }

    function refresh() {
        return request('/api/auth/refresh', {
            method: 'POST'
        }).then(setAuth);
    }

    function updateProfile(payload) {
        return request('/api/auth/profile', {
            method: 'PUT',
            body: payload
        }).then(function (data) {
            if (data && data.user) {
                window.localStorage.setItem(USER_KEY, JSON.stringify(data.user));
            }

            return data;
        });
    }

    function logout() {
        return request('/api/auth/logout', {
            method: 'POST'
        }).finally(function () {
            clearAuth();
        });
    }

    function authFetch(url, options) {
        return request(url, options);
    }

    window.ApiAuth = {
        getToken: getToken,
        getUser: getUser,
        setAuth: setAuth,
        clearAuth: clearAuth,
        register: register,
        login: login,
        me: me,
        refresh: refresh,
        updateProfile: updateProfile,
        logout: logout,
        authFetch: authFetch
    };
})(window);
