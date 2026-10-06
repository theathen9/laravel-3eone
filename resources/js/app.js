// resources/js/app.js

import { apiFetch } from "./api";
import "bootstrap";
import { setupAddressAPI } from "./address";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

console.log("Laravel application loaded");

async function testApi() {
    try {
        const response = await apiFetch("/api/v1/auth/token");

        const data = await response.json();

        console.log("API response:", data);
    } catch (error) {
        console.error("API error:", error);
    }
}
document.addEventListener("DOMContentLoaded", () => {
    // Employee / Student birth address
    if (document.getElementById("birth_addr_province")) {
        setupAddressAPI("birth_addr");
    }

    // Employee / Student current address
    if (document.getElementById("curr_addr_province")) {
        setupAddressAPI("curr_addr");
    }

    // Student only: guardian current address
    if (document.getElementById("guardian_curr_addr_province")) {
        setupAddressAPI("guardian_curr_addr");
    }
});

// testApi();
