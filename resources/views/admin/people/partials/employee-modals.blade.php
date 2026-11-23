<dialog id="employeeDetailDialog"
    class="m-auto w-[calc(100%-2rem)] max-w-2xl rounded-2xl border-0 bg-transparent p-0 backdrop:bg-gray-900/50">
    <div class="max-h-[90vh] overflow-y-auto rounded-xl border border-gray-200 bg-white shadow-2xl">
        <div class="sticky top-0 z-10 flex items-start justify-between border-b border-gray-100 bg-white px-5 py-4">
            <div>
                <p id="employeeDetailId" class="text-xs font-semibold uppercase tracking-wider text-[#b87d49]"></p>
                <h2 id="employeeDetailName" class="mt-1 text-xl font-bold text-gray-900"></h2>
                <p id="employeeDetailKhmerName" class="mt-1 text-sm text-gray-500"></p>
            </div>
            <button type="button" id="closeEmployeeDetail"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50"
                aria-label="Close employee details">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
        <div class="grid gap-3 p-5 sm:grid-cols-2">
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Gender</p>
                <p id="employeeDetailGender" class="mt-1 text-sm font-medium text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Date of Birth</p>
                <p id="employeeDetailDob" class="mt-1 text-sm font-medium text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Branch Employee ID</p>
                <p id="employeeDetailCode" class="mt-1 font-mono text-sm font-medium text-[#b87d49]"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Current Position</p>
                <p id="employeeDetailPosition" class="mt-1 text-sm font-medium text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Branch Code</p>
                <p id="employeeDetailBranchCode" class="mt-1 text-sm font-medium text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Status</p>
                <p id="employeeDetailStatus" class="mt-1 text-sm font-medium text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Primary Phone</p>
                <p id="employeeDetailPhone1" class="mt-1 break-words text-sm text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Alternate Phone</p>
                <p id="employeeDetailPhone2" class="mt-1 break-words text-sm text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3 sm:col-span-2">
                <p class="text-xs text-gray-400">Email</p>
                <p id="employeeDetailEmail" class="mt-1 break-words text-sm text-gray-700"></p>
            </div>
            <div class="rounded-lg bg-gray-50 p-3">
                <p class="text-xs text-gray-400">Hired At</p>
                <p id="employeeDetailHiredAt" class="mt-1 text-sm text-gray-700"></p>
            </div>
            <section class="rounded-lg border border-gray-200 bg-gray-50 p-4 sm:col-span-2">
                <div class="mb-3">
                    <h3 class="text-sm font-semibold text-gray-800">Position History</h3>
                    <p class="mt-1 text-xs text-gray-500">Current and previous position assignments.</p>
                </div>
                <div id="employeeDetailPositionHistory" class="space-y-2"></div>
            </section>
            <section class="rounded-lg border border-gray-200 bg-gray-50 p-4 sm:col-span-2">
                <div class="mb-3">
                    <h3 class="text-sm font-semibold text-gray-800">Branch History</h3>
                    <p class="mt-1 text-xs text-gray-500">Current and previous branch assignments.</p>
                </div>
                <div id="employeeDetailBranchHistory" class="space-y-2"></div>
            </section>
        </div>
    </div>
</dialog>

<dialog id="employeeEditDialog"
    class="m-auto w-[calc(100%-2rem)] max-w-3xl rounded-2xl border-0 bg-transparent p-0 backdrop:bg-gray-900/50">
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl">
        <div class="flex items-start justify-between border-b border-gray-100 px-5 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-[#b87d49]">Employee Management</p>
                <h2 id="employeeEditTitle" class="mt-1 text-xl font-bold text-gray-900">Edit Employee</h2>
            </div>
            <button type="button" id="closeEmployeeEdit"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50"
                aria-label="Close employee form">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
        <form id="employeeEditForm" class="space-y-4 p-5">
            <p id="employeeEditMessage" class="hidden rounded-lg p-3 text-sm" role="status" aria-live="polite"></p>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="block text-sm font-medium text-gray-700">
                    First Name (English)
                    <input id="editFirstNameEn" required maxlength="100"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Last Name (English)
                    <input id="editLastNameEn" required maxlength="100"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    First Name (Khmer)
                    <input id="editFirstNameKh" required maxlength="100"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Last Name (Khmer)
                    <input id="editLastNameKh" required maxlength="100"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Gender
                    <select id="editEmployeeGender" required
                        class="mt-1.5 w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Date of Birth
                    <input id="editEmployeeDob" type="date" required
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Primary Phone
                    <input id="editEmployeePhone1" type="tel" required maxlength="20"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Alternate Phone
                    <input id="editEmployeePhone2" type="tel" maxlength="20"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Email
                    <input id="editEmployeeEmail" type="email" maxlength="150"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Position
                    <select id="editEmployeePosition"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                        <option value="">Not assigned</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Branch
                    <select id="editEmployeeBranch"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                        <option value="">Not assigned</option>
                    </select>
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Hired At
                    <input id="editEmployeeHiredAt" type="date" required
                        class="mt-1.5 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                </label>
                <label class="block text-sm font-medium text-gray-700">
                    Status
                    <select id="editEmployeeStatus"
                        class="mt-1.5 w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-orange-100">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </label>
            </div>
            <div class="border-t border-gray-100 pt-4">
                <label for="editEmployeeSignatureImage" class="block text-sm font-medium text-gray-700">
                    Employee signature image
                </label>
                <div class="mt-2 flex items-center gap-3">
                    <img id="editEmployeeSignaturePreview"
                        data-storage-base="{{ asset('storage') }}"
                        class="hidden h-14 max-w-48 object-contain"
                        alt="Current employee signature">
                    <span id="editEmployeeSignatureEmpty" class="text-sm text-gray-500">No signature uploaded</span>
                </div>
                <input id="editEmployeeSignatureImage"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    class="mt-2 block w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-orange-50 file:px-3 file:py-2 file:font-semibold file:text-[#b87d49]">
                <p class="mt-1 text-xs text-gray-500">Upload a separate handwritten signature image. PNG is recommended.</p>
            </div>
            <div class="flex justify-end gap-3 border-t border-gray-100 pt-4">
                <button type="button" id="cancelEmployeeEdit"
                    class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" id="saveEmployeeEdit"
                    class="rounded-lg bg-[#d1935c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#b87d49] disabled:cursor-not-allowed disabled:opacity-60">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</dialog>
