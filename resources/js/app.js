import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { initMorhenaDashboard } from './components/morhena/dashboard';

initMorhenaDashboard();

// Theme Toggle
(function initThemeToggle() {
  const THEME_KEY = 'morhena-theme';
  const html = document.documentElement;

  // Load saved theme or check system preference
  const savedTheme = localStorage.getItem(THEME_KEY);
  if (savedTheme === 'light') {
    html.classList.add('light-theme');
  } else if (savedTheme === 'dark') {
    html.classList.remove('light-theme');
  } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
    html.classList.add('light-theme');
  }

  // Setup toggle button
  document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('theme-toggle');
    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', () => {
      html.classList.toggle('light-theme');
      const isLight = html.classList.contains('light-theme');
      localStorage.setItem(THEME_KEY, isLight ? 'light' : 'dark');
    });
  });
})();
