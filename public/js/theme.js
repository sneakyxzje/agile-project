class ThemeManager {
  constructor() {
    this.init();
  }

  init() {
    this.loadSavedTheme();

    window.addEventListener("scroll", this.handleScroll.bind(this));
  }

  loadSavedTheme() {
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
      this.enableDarkMode();
    } else {
      this.enableLightMode();
    }
  }

  toggleTheme() {
    const html = document.documentElement;
    const isDark = html.classList.contains("dark");

    if (isDark) {
      this.enableLightMode();
      localStorage.setItem("theme", "light");
    } else {
      this.enableDarkMode();
      localStorage.setItem("theme", "dark");
    }
  }

  enableDarkMode() {
    const html = document.documentElement;
    html.classList.add("dark");

    const sunIcon = document.getElementById("sunIcon");
    const moonIcon = document.getElementById("moonIcon");

    if (sunIcon) sunIcon.classList.add("hidden");
    if (moonIcon) moonIcon.classList.remove("hidden");
  }

  enableLightMode() {
    const html = document.documentElement;
    html.classList.remove("dark");

    const sunIcon = document.getElementById("sunIcon");
    const moonIcon = document.getElementById("moonIcon");

    if (sunIcon) sunIcon.classList.remove("hidden");
    if (moonIcon) moonIcon.classList.add("hidden");
  }

  handleScroll() {
    const navbar = document.getElementById("navbar");
    const navContent = document.getElementById("navContent");

    if (!navbar) return;

    const currentScroll = window.pageYOffset;

    if (currentScroll > 50) {
      navbar.classList.add("shadow-lg");
      if (navContent) navContent.classList.add("!h-12");
    } else {
      navbar.classList.remove("shadow-lg");
      if (navContent) navContent.classList.remove("!h-12");
    }
  }
}

const themeManager = new ThemeManager();

function toggleTheme() {
  themeManager.toggleTheme();
}

function toggleMobileMenu() {
  const menu = document.getElementById("mobileMenu");
  if (!menu) return;

  if (menu.style.maxHeight === "0px" || menu.style.maxHeight === "") {
    menu.style.maxHeight = "500px";
  } else {
    menu.style.maxHeight = "0px";
  }
}

function toggleCategory(categoryId) {
  const content = document.getElementById(`content-${categoryId}`);
  const toggle = document.getElementById(`toggle-${categoryId}`);

  content?.classList.toggle("collapsed");
  toggle?.classList.toggle("collapsed");
}

function togglePassword(inputId, icon) {
  const input = document.getElementById(inputId);
  if (!input) return;

  if (input.type === "password") {
    input.type = "text";
    icon.classList.remove("fa-eye");
    icon.classList.add("fa-eye-slash");
  } else {
    input.type = "password";
    icon.classList.remove("fa-eye-slash");
    icon.classList.add("fa-eye");
  }
}
