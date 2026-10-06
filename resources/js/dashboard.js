// resources/js/dashboard.js

import { apiFetch } from "./api";

console.log("Laravel application dashboard loaded");

async function testApi() {
    try {
        const response = await apiFetch(`${APP_API_URL}/v1/auth/token`);
        console.log("api fetch:", apiFetch);

        const data = await response.json();

        console.log("API response:", data);
    } catch (error) {
        console.error("API error:", error);
    }
}

// testApi();
