export default function LoadingSkeleton() {
  return (
    <div className="min-h-screen bg-cream" role="status" aria-live="polite" aria-label="Cargando sitio">
      <div className="h-20 border-b border-terracotta/10 bg-cream-dark/80" />
      <div className="mx-auto max-w-7xl px-6 py-20">
        <div className="mb-4 h-4 w-48 animate-pulse rounded bg-terracotta/15" />
        <div className="mb-6 h-14 w-3/4 max-w-2xl animate-pulse rounded bg-navy/10" />
        <div className="mb-10 h-24 w-full max-w-xl animate-pulse rounded-2xl bg-cream-dark" />
        <div className="grid gap-6 md:grid-cols-3">
          {[1, 2, 3].map((i) => (
            <div key={i} className="h-48 animate-pulse rounded-3xl bg-white border border-terracotta/10" />
          ))}
        </div>
        <p className="mt-10 text-center font-display text-sm text-terracotta tracking-widest uppercase">Villa Hermosa</p>
      </div>
    </div>
  );
}
