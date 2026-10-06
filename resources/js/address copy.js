// ============================================================
// ADDRESS API
// ============================================================
export function setupAddressAPI(prefix) {
    document
        .getElementById("profile_image")
        .addEventListener("change", function () {
            const file = this.files[0];

            if (file) {
                const preview = document.getElementById(
                    "preview_profile_image",
                );
                preview.src = URL.createObjectURL(file);
            }
        });

    // --------------------------------------------------------
    // API URL
    // --------------------------------------------------------
    const APP_API_URL = import.meta.env.VITE_APP_API_URL;

    console.log("Address API:", APP_API_URL);
    console.log("Address prefix:", prefix);

    // --------------------------------------------------------
    // ELEMENTS
    // --------------------------------------------------------

    const province = document.getElementById(`${prefix}_province`);
    const district = document.getElementById(`${prefix}_district`);
    const commune = document.getElementById(`${prefix}_commune`);
    const village = document.getElementById(`${prefix}_village`);
    // const guardian = document.getElementById("guardian_curr_addr");

    const otherDistrict = document.getElementById(`other_${prefix}_district`);
    const otherCommune = document.getElementById(`other_${prefix}_commune`);
    const otherVillage = document.getElementById(`other_${prefix}_village`);

    // --------------------------------------------------------
    // CHECK ELEMENTS
    // --------------------------------------------------------

    if (!province || !district || !commune || !village) {
        console.warn(`Address elements not found for: ${prefix}`);
        return;
    }

    // --------------------------------------------------------
    // RESET SELECT
    // --------------------------------------------------------

    function resetSelect(select, label, allowOther = true) {
        select.innerHTML = `<option value="">-- ${label} --</option>`;

        if (allowOther) {
            select.add(new Option("-- Other --", "other"));
        }

        select.disabled = true;
        select.style.display = "block";
    }

    // --------------------------------------------------------
    // ADD OPTIONS
    // --------------------------------------------------------

    function addOptions(select, data, label, allowOther = true) {
        select.innerHTML = `<option value="">-- ${label} --</option>`;

        if (Array.isArray(data)) {
            data.forEach((item) => {
                select.add(new Option(item, item));
            });
        }

        if (allowOther) {
            select.add(new Option("-- Other --", "other"));
        }

        select.disabled = false;
        select.style.display = "block";
    }

    // --------------------------------------------------------
    // SHOW OTHER INPUT
    // --------------------------------------------------------

    // function showOther(input, select) {

    //     if (!input) return;

    //     input.style.display = "block";
    //     input.disabled = false;
    //     input.required = true;

    //     // Disable select because the text input is now used
    //     if (select) {
    //         select.disabled = true;

    //     }
    // }

    // --------------------------------------------------------
    // HIDE OTHER INPUT
    // --------------------------------------------------------

    // function hideOther(input, select) {

    //     if (!input) return;

    //     input.style.display = "none";
    //     input.disabled = true;
    //     input.required = false;
    //     input.value = "";

    //     // Enable select again
    //     if (select) {
    //         select.disabled = false;
    //     }
    // }

    // --------------------------------------------------------
    // NEW SHOW AND HLIDE OTHER INPUT
    // --------------------------------------------------------

    function toggleOther(show, hide, fieldName) {
        if (!show || !hide) return;

        // Hide old field
        hide.name = "";
        hide.disabled = true;
        hide.required = false;
        hide.style.display = "none";

        // Show new field
        show.name = fieldName;
        show.disabled = false;
        show.required = true;
        show.style.display = "block";
    }

    // ========================================================
    // INITIAL STATE
    // ========================================================

    if (district) {
        toggleOther(district, otherDistrict, `${prefix}_district`);
        toggleOther(district, otherDistrict, `curr_${prefix}_district`);
        toggleOther(
            district,
            otherDistrict,
            `guardian_curr_${prefix}_district`,
        );
    }

    if (commune) {
        toggleOther(commune, otherCommune, `${prefix}_commune`);
        toggleOther(commune, otherCommune, `curr_${prefix}_commune`);
        toggleOther(commune, otherCommune, `guardian_curr_${prefix}_commune`);
    }

    if (village) {
        toggleOther(village, otherVillage, `${prefix}_village`);
        toggleOther(village, otherVillage, `curr_${prefix}_village`);
        toggleOther(village, otherVillage, `guardian_curr_${prefix}_village`);
    }

    resetSelect(district, "District", true);
    resetSelect(commune, "Commune", true);
    resetSelect(village, "Village", true);

    // ========================================================
    // LOAD PROVINCES
    // ========================================================

    fetch(`${APP_API_URL}/v1/address?type=provinces`)
        .then((response) => {
            if (!response.ok) {
                throw new Error("Failed to load provinces");
            }

            return response.json();
        })
        .then((data) => {
            addOptions(province, data, "Province", false);
        })
        .catch((error) => {
            console.error(`${prefix} province error:`, error);
        });

    // ========================================================
    // PROVINCE CHANGE
    // ========================================================

    province.addEventListener("change", async function () {
        const provinceValue = this.value;

        // Reset district
        resetSelect(district, "District", true);

        // Reset commune
        resetSelect(commune, "Commune", true);

        // Reset village
        resetSelect(village, "Village", true);

        if (district) {
            toggleOther(district, otherDistrict, `${prefix}_district`);
            toggleOther(district, otherDistrict, `curr_${prefix}_district`);
            toggleOther(
                district,
                otherDistrict,
                `guardian_curr_${prefix}_district`,
            );
        }

        if (commune) {
            toggleOther(commune, otherCommune, `${prefix}_commune`);
            toggleOther(commune, otherCommune, `curr_${prefix}_commune`);
            toggleOther(
                commune,
                otherCommune,
                `guardian_curr_curr_${prefix}_commune`,
            );
        }

        if (village) {
            toggleOther(village, otherVillage, `${prefix}_village`);
            toggleOther(village, otherVillage, `curr_${prefix}_village`);
            toggleOther(
                village,
                otherVillage,
                `guardian_curr_${prefix}_village`,
            );
        }

        commune.disabled = true;
        village.disabled = true;

        if (!provinceValue) {
            return;
        }

        try {
            const response = await fetch(
                `${APP_API_URL}/v1/address` +
                    `?type=districts` +
                    `&province=${encodeURIComponent(provinceValue)}`,
            );

            if (!response.ok) {
                throw new Error("Failed to load districts");
            }

            const data = await response.json();

            addOptions(district, data, "District", true);
        } catch (error) {
            console.error(`${prefix} district error:`, error);
        }
    });

    // ========================================================
    // DISTRICT CHANGE
    // ========================================================

    district.addEventListener("change", async function () {
        const districtValue = this.value;
        const provinceValue = province.value;

        // Reset lower levels
        resetSelect(commune, "Commune", true);

        resetSelect(village, "Village", true);

        // ============================================
        // DISTRICT = OTHER
        // ============================================

        if (this.value === "other") {
            toggleOther(otherDistrict, district, `${prefix}_district`);
            toggleOther(otherCommune, commune, `${prefix}_commune`);
            toggleOther(otherVillage, village, `${prefix}_village`);
            // current address
            toggleOther(otherDistrict, district, `curr_${prefix}_district`);
            toggleOther(otherCommune, commune, `curr_${prefix}_commune`);
            toggleOther(otherVillage, village, `curr_${prefix}_village`);
            // current address guardian
            toggleOther(
                otherDistrict,
                district,
                `guardian_curr_${prefix}_district`,
            );
            toggleOther(
                otherCommune,
                commune,
                `guardian_curr_${prefix}_commune`,
            );
            toggleOther(
                otherVillage,
                village,
                `guardian_curr_${prefix}_village`,
            );

            return;
        }

        // ============================================
        // NORMAL DISTRICT
        // ============================================

        toggleOther(district, otherDistrict, `${prefix}_district`);
        toggleOther(district, otherDistrict, `curr_${prefix}_district`);
        toggleOther(
            district,
            otherDistrict,
            `guardian_curr_${prefix}_district`,
        );

        if (!districtValue) {
            return;
        }

        village.disabled = true;

        // ------------------------------------------------
        // LOAD COMMUNES
        // ------------------------------------------------

        try {
            const response = await fetch(
                `${APP_API_URL}/v1/address` +
                    `?type=communes` +
                    `&province=${encodeURIComponent(provinceValue)}` +
                    `&district=${encodeURIComponent(districtValue)}`,
            );

            if (!response.ok) {
                throw new Error("Failed to load communes");
            }

            const data = await response.json();

            addOptions(commune, data, "Commune", true);
        } catch (error) {
            console.error(`${prefix} commune error:`, error);
        }
    });

    // ========================================================
    // COMMUNE CHANGE
    // ========================================================

    commune.addEventListener("change", async function () {
        const communeValue = this.value;

        const provinceValue = province.value;

        const districtValue = district.value;

        // Reset village
        resetSelect(village, "Village", true);

        // ============================================
        // DISTRICT = OTHER
        // ============================================

        if (this.value === "other") {
            toggleOther(otherCommune, commune, `${prefix}_commune`);
            toggleOther(otherVillage, village, `${prefix}_village`);
            // current address
            toggleOther(otherCommune, commune, `curr_${prefix}_commune`);
            toggleOther(otherVillage, village, `curr_${prefix}_village`);
            // current address guardian
            toggleOther(
                otherCommune,
                commune,
                `guardian_curr_${prefix}_commune`,
            );
            toggleOther(
                otherVillage,
                village,
                `guardian_curr_${prefix}_village`,
            );
            return;
        }

        // ============================================
        // NORMAL COMMUNE
        // ============================================

        toggleOther(commune, otherCommune, `${prefix}_commune`);
        toggleOther(commune, otherCommune, `curr_${prefix}_commune`);
        toggleOther(commune, otherCommune, `guardian_curr_${prefix}_commune`);

        if (!communeValue) {
            return;
        }

        // ------------------------------------------------
        // LOAD VILLAGES
        // ------------------------------------------------

        try {
            const response = await fetch(
                `${APP_API_URL}/v1/address` +
                    `?type=villages` +
                    `&province=${encodeURIComponent(provinceValue)}` +
                    `&district=${encodeURIComponent(districtValue)}` +
                    `&commune=${encodeURIComponent(communeValue)}`,
            );

            if (!response.ok) {
                throw new Error("Failed to load villages");
            }

            const data = await response.json();

            addOptions(village, data, "Village", true);
        } catch (error) {
            console.error(`${prefix} village error:`, error);
        }
    });

    // ========================================================
    // VILLAGE CHANGE
    // ========================================================

    village.addEventListener("change", function () {
        if (this.value === "other") {
            toggleOther(otherVillage, village, `${prefix}_village`);
            toggleOther(otherVillage, village, `curr_${prefix}_village`);
            toggleOther(
                otherVillage,
                village,
                `guardian_curr_${prefix}_village`,
            );
        } else {
            toggleOther(village, otherVillage, `${prefix}_village`);
            toggleOther(village, otherVillage, `curr_${prefix}_village`);
            toggleOther(
                village,
                otherVillage,
                `guardian_curr_${prefix}_village`,
            );
        }
    });
    // ============================================================
    // INITIALIZE ADDRESS
    // ============================================================

    // document.addEventListener("DOMContentLoaded", function () {
    //     setupAddressAPI("birth_addr");

    //     setupAddressAPI("curr_addr");
    // });
}
