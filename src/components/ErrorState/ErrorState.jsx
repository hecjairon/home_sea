/**
 * @param {{ message: string, onRetry?: () => void }} props
 */
export default function ErrorState({ message, onRetry }) {
  return (
    <div className="flex min-h-[60vh] items-center justify-center px-6 bg-cream" role="alert">
      <div className="max-w-md text-center">
        <div className="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-3xl bg-terracotta/10">
          <svg className="h-7 w-7 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
        <h1 className="font-display text-2xl text-navy">No se pudo cargar el sitio</h1>
        <p className="mt-3 text-gray-500">{message}</p>
        {onRetry ? (
          <button
            type="button"
            onClick={onRetry}
            className="mt-6 inline-flex items-center justify-center rounded-full bg-terracotta px-6 py-2.5 text-sm font-semibold text-white hover:bg-terracotta-dark transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-terracotta"
          >
            Reintentar
          </button>
        ) : null}
      </div>
    </div>
  );
}
