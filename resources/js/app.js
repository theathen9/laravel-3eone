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
    flatpickr("#dob", {
        altFormat: "d-m-Y", // ✅ what user sees
        dateFormat: "Y-m-d", // ✅ value sent to backend
        altInput: true, // ✅ show separate input
        maxDate: "today",
        allowInput: true,
        monthSelectorType: "dropdown",
        yearSelectorType: "dropdown",
    });
    flatpickr("#register_at", {
        altInput: true,
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        maxDate: "today",
        allowInput: true,
        monthSelectorType: "dropdown",
        yearSelectorType: "dropdown",

        onReady: function (selectedDates, dateStr, instance) {
            instance.altInput.setAttribute("placeholder", "Register Date");
        },
    });

    flatpickr("#hired_at", {
        altFormat: "d-m-Y",
        dateFormat: "Y-m-d",
        altInput: true,
        maxDate: "today",
        allowInput: true,
        monthSelectorType: "dropdown",
        yearSelectorType: "dropdown",

        onReady: function (selectedDates, dateStr, instance) {
            instance.altInput.setAttribute("placeholder", "Hired at");
        },
    });
});

// testApi();
