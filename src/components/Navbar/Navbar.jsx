import { useEffect, useState } from 'react';

function HouseIcon({ className = 'w-8 h-8 text-gold' }) {
  return (
    <svg className={className} viewBox="0 0 32 32" fill="currentColor" aria-hidden="true">
      <path d="M16 3L3 14h3v13h7v-8h6v8h7V14h3L16 3zm0 4.5l7 6.2V25h-3v-8h-8v8H9v-11.3l7-6.2z" />
    </svg>
  );
}

/**
 * @param {{ data: { logo_text_parts?: { first: string, second: string }, brand?: { first: string, second: string }, nav: Array<{label: string, url: string}>, cta_label: string, cta_url: string } }} props
 */
export default function Navbar({ data }) {
  const [scrolled, setScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);

  const brand = data.logo_text_parts || data.brand || { first: 'Casa', second: 'Noble' };

  useEffect(() => {
    const onScroll = () => setScrolled(window.scrollY > 40);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    return () => window.removeEventListener('scroll', onScroll);
  }, []);

  useEffect(() => {
    document.body.style.overflow = menuOpen ? 'hidden' : '';
    return () => {
      document.body.style.overflow = '';
    };
  }, [menuOpen]);

  const closeMenu = () => setMenuOpen(false);

  return (
    <header>
      <nav
        className={`fixed top-0 left-0 right-0 z-50 transition-all duration-500 ${scrolled ? 'navbar-scrolled' : ''}`}
        aria-label="Navegación principal"
      >
        <div className="max-w-7xl mx-auto px-6 lg:px-8">
          <div className="flex items-center justify-between h-20">
            <a href="#inicio" className="flex items-center gap-2.5 group" aria-label="Casa Noble — Inicio">
              <HouseIcon />
              <span
                className={`logo-text font-display text-xl font-bold tracking-wide transition-colors duration-300 ${scrolled ? 'text-navy' : 'text-white'}`}
              >
                {brand.first}{' '}
                <span className="text-gold italic">{brand.second}</span>
              </span>
            </a>

            <ul className="hidden lg:flex items-center gap-8" role="list">
              {data.nav.map((item) => (
                <li key={item.url}>
                  <a
                    href={item.url}
                    className={`nav-link text-sm font-medium transition-colors duration-300 ${scrolled ? 'text-navy hover:text-terracotta' : 'text-white/90 hover:text-gold'}`}
                  >
                    {item.label}
                  </a>
                </li>
              ))}
            </ul>

            <div className="hidden lg:block">
              <a
                href={data.cta_url}
                className="btn-terracotta-glow inline-flex items-center px-6 py-2.5 bg-terracotta text-white text-sm font-semibold rounded-full hover:bg-terracotta-dark transition-all duration-300"
              >
                {data.cta_label}
              </a>
            </div>

            <button
              type="button"
              className={`hamburger lg:hidden flex flex-col gap-1.5 p-2 ${menuOpen ? 'active' : ''}`}
              aria-label={menuOpen ? 'Cerrar menú' : 'Abrir menú'}
              aria-expanded={menuOpen}
              aria-controls="mobile-menu"
              onClick={() => setMenuOpen((open) => !open)}
            >
              <span className={`hamburger-line block w-6 h-0.5 ${scrolled ? 'bg-navy' : 'bg-white'}`} />
              <span className={`hamburger-line block w-6 h-0.5 ${scrolled ? 'bg-navy' : 'bg-white'}`} />
              <span className={`hamburger-line block w-6 h-0.5 ${scrolled ? 'bg-navy' : 'bg-white'}`} />
            </button>
          </div>
        </div>
      </nav>

      <div
        id="mobile-menu"
        className={`mobile-menu fixed inset-0 z-40 lg:hidden ${menuOpen ? 'open' : ''}`}
        aria-hidden={!menuOpen}
      >
        <button
          type="button"
          className="absolute inset-0 bg-navy-dark/40"
          aria-label="Cerrar menú"
          onClick={closeMenu}
        />
        <div className="absolute right-0 top-0 bottom-0 w-80 max-w-full bg-cream shadow-2xl p-8 pt-24">
          <nav aria-label="Menú móvil">
            <ul className="flex flex-col gap-6" role="list">
              {data.nav.map((item) => (
                <li key={item.url}>
                  <a
                    href={item.url}
                    className="text-lg font-medium text-navy hover:text-terracotta transition-colors"
                    onClick={closeMenu}
                  >
                    {item.label}
                  </a>
                </li>
              ))}
            </ul>
            <a
              href={data.cta_url}
              className="mt-8 inline-flex w-full justify-center px-6 py-3 bg-terracotta text-white text-sm font-semibold rounded-full hover:bg-terracotta-dark transition-all duration-300"
              onClick={closeMenu}
            >
              {data.cta_label}
            </a>
          </nav>
        </div>
      </div>
    </header>
  );
}
