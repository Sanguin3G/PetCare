const THEME_STORAGE_KEY = "petcare-theme";
const themeLabels = { system: "Hệ thống", light: "Sáng", dark: "Tối" };

const getStoredTheme = () => {
    try { return localStorage.getItem(THEME_STORAGE_KEY) || "system"; }
    catch (error) { return "system"; }
};

const resolveTheme = (preference) => preference === "system"
    ? (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light")
    : preference;

const setTheme = (preference, persist = true) => {
    const safePreference = ["system", "light", "dark"].includes(preference) ? preference : "system";
    const root = document.documentElement;
    root.dataset.themePreference = safePreference;
    root.dataset.theme = resolveTheme(safePreference);

    if (persist) {
        try { localStorage.setItem(THEME_STORAGE_KEY, safePreference); }
        catch (error) { /* Storage can be unavailable in private browsing. */ }
    }

    document.querySelectorAll("[data-theme-choice]").forEach((button) => {
        const isActive = button.dataset.themeChoice === safePreference;
        button.classList.toggle("active", isActive);
        button.setAttribute("aria-checked", String(isActive));
    });
    document.querySelectorAll("[data-theme-label]").forEach((label) => {
        label.textContent = themeLabels[safePreference];
    });
};

setTheme(getStoredTheme(), false);

document.addEventListener("click", (event) => {
    const choice = event.target.closest("[data-theme-choice]");
    if (choice) setTheme(choice.dataset.themeChoice);
});

const systemTheme = window.matchMedia("(prefers-color-scheme: dark)");
systemTheme.addEventListener?.("change", () => {
    if (document.documentElement.dataset.themePreference === "system") setTheme("system", false);
});

window.PetCareTheme = { setTheme };
