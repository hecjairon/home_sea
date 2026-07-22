import logoUrl from '../../assets/logo.svg';
import { SocialIcon } from '../../icons/registry.jsx';

/**
 * @param {{ data: object }} props
 */
export default function Footer({ data }) {
  const brandParts = data.brand_parts || { first: 'villa', second: 'HERMOSA' };
  const brandLabel = data.brand || `${brandParts.first} ${brandParts.second}`;

  return (
    <footer id="blog" className="bg-navy-dark text-white pt-20 pb-8" aria-label="Pie de página">
      <div className="max-w-7xl mx-auto px-6 lg:px-8">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
          <div>
            <a href="#inicio" className="inline-flex items-center mb-6" aria-label={brandLabel}>
              <img
                src={logoUrl}
                alt={brandLabel}
                className="logo-mark logo-mark--footer brightness-0 invert"
                width="160"
                height="68"
              />
            </a>
            <p className="text-white/60 text-sm leading-relaxed mb-6">{data.tagline}</p>
            <div className="flex gap-4" aria-label="Redes sociales">
              {data.socials.map((social) => (
                <a
                  key={social.label}
                  href={social.url}
                  className="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-terracotta transition-all duration-300"
                  aria-label={social.label}
                >
                  <SocialIcon name={social.icon} />
                </a>
              ))}
            </div>
          </div>

          <div>
            <h3 className="font-semibold text-sm uppercase tracking-wider mb-6">Enlaces rápidos</h3>
            <ul className="space-y-3" role="list">
              {data.quick_links.map((link) => (
                <li key={link.url}>
                  <a href={link.url} className="text-white/60 text-sm hover:text-gold transition-colors">
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          </div>

          <div>
            <h3 className="font-semibold text-sm uppercase tracking-wider mb-6">Contacto</h3>
            <ul className="space-y-3 text-white/60 text-sm" role="list">
              {data.contact_lines.map((line) => (
                <li key={line}>{line}</li>
              ))}
            </ul>
          </div>

          <div>
            <h3 className="font-semibold text-sm uppercase tracking-wider mb-6">Legal</h3>
            <ul className="space-y-3" role="list">
              {data.legal_links.map((link) => (
                <li key={link.label}>
                  <a href={link.url} className="text-white/60 text-sm hover:text-gold transition-colors">
                    {link.label}
                  </a>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="section-divider mb-8" />
        <p className="text-center text-white/40 text-sm">{data.copyright}</p>
      </div>
    </footer>
  );
}
