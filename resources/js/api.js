// resources/js/api.js
let refreshPromise = null;
// const APP_API_URL = window.APP_API_URL;

/**
 * Refresh the access token.
 *
 * Only ONE refresh request can run at a time.
 * Other requests wait for the same Promise.
 */
async function refreshToken() {
    // Refresh already running
    if (refreshPromise) {
        return refreshPromise;
    }

    refreshPromise = (async () => {
        try {
            const APP_API_URL = import.meta.env.VITE_APP_API_URL;
            const response = await fetch(`${APP_API_URL}/v1/auth/refresh`, {
                method: "POST",
                credentials: "include",
                headers: {
                    Accept: "application/json",
                },
            });

            if (!response.ok) {
                return false;
            }

            return true;
        } catch (error) {
            console.error("Token refresh failed:", error);

            return false;
        } finally {
            // Allow a future refresh attempt
            refreshPromise = null;
        }
    })();

    return refreshPromise;
}

/**
 * API request wrapper.
 *
 * Automatically:
 * - sends cookies
 * - detects 401
 * - refreshes the access token
 * - retries the original request once
 * - redirects to login if refresh fails
 */
export async function apiFetch(url, options = {}) {
    const requestOptions = {
        ...options,
        credentials: "include",

        headers: {
            Accept: "application/json",
            ...(options.headers || {}),
        },
    };

    // ---------------------------------------------------------
    // First request
    // ---------------------------------------------------------

    let response = await fetch(url, requestOptions);

    // ---------------------------------------------------------
    // Request succeeded
    // ---------------------------------------------------------

    if (response.status !== 401) {
        return response;
    }

    // ---------------------------------------------------------
    // Access token expired
    // ---------------------------------------------------------

    const refreshed = await refreshToken();

    // // ---------------------------------------------------------
    // // Refresh failed
    // // ---------------------------------------------------------

    if (!refreshed) {
        // Optional: call logout endpoint if your application
        // needs server-side token revocation.
        //
        await fetch("/auth/signout", {
            method: "POST",
            credentials: "include",
        });

        window.location.href = "/auth/signin";

        return response;
    }

    // ---------------------------------------------------------
    // Retry original request ONCE
    // ---------------------------------------------------------

    return fetch(url, requestOptions);
}
