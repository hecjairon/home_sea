import { useState } from 'react';
import { motion } from 'framer-motion';
import { submitContactToCf7 } from '../../services/contactSubmit.js';

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

const EMPTY_FORM = { nombre: '', correo: '', telefono: '', mensaje: '' };

/**
 * @param {{ data: object }} props
 */
export default function Contact({ data }) {
  const [form, setForm] = useState(EMPTY_FORM);
  const [errors, setErrors] = useState({});
  const [success, setSuccess] = useState(false);
  const [submitError, setSubmitError] = useState('');
  const [submitting, setSubmitting] = useState(false);

  const labels = data.form_labels || {};
  const cf7 = data.cf7 || {};

  const validate = () => {
    const next = {};
    if (!form.nombre.trim()) next.nombre = labels.nombre_error || 'El nombre es obligatorio.';
    if (!form.correo.trim()) next.correo = labels.correo_error || 'El correo es obligatorio.';
    else if (!EMAIL_RE.test(form.correo)) next.correo = labels.correo_invalid || 'Introduce un correo válido.';
    if (!form.telefono.trim()) next.telefono = labels.telefono_error || 'El teléfono es obligatorio.';
    setErrors(next);
    return Object.keys(next).length === 0;
  };

  const handleChange = (e) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
    if (errors[name]) setErrors((prev) => ({ ...prev, [name]: undefined }));
    if (success) setSuccess(false);
    if (submitError) setSubmitError('');
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (submitting) return;
    if (!validate()) return;

    setSubmitting(true);
    setSubmitError('');
    setSuccess(false);

    try {
      const result = await submitContactToCf7(form, cf7);

      if (result.ok) {
        setSuccess(true);
        setForm(EMPTY_FORM);
        setErrors({});
        return;
      }

      if (result.fieldErrors && Object.keys(result.fieldErrors).length > 0) {
        setErrors((prev) => ({ ...prev, ...result.fieldErrors }));
      }

      setSubmitError(
        result.message || labels.submit_error || 'No se pudo enviar el mensaje. Inténtalo de nuevo.',
      );
    } catch {
      setSubmitError(labels.submit_error || 'No se pudo enviar el mensaje. Inténtalo de nuevo.');
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <section id="contacto" className="py-24 lg:py-32 bg-cream" aria-labelledby="contact-heading">
      <div className="max-w-7xl mx-auto px-6 lg:px-8">
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          <motion.div
            initial={{ opacity: 0, x: -24 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.7 }}
          >
            <div className="terracotta-line mb-4" />
            <p className="text-terracotta text-sm font-medium tracking-[0.2em] uppercase mb-3">{data.eyebrow}</p>
            <h2 id="contact-heading" className="font-display text-4xl lg:text-5xl font-bold text-navy mb-6">
              {data.title}
            </h2>
            <p className="text-gray-500 leading-relaxed mb-8">{data.body}</p>
            <div className="space-y-4">
              <div className="flex items-center gap-4">
                <div className="w-12 h-12 rounded-2xl bg-terracotta/10 flex items-center justify-center">
                  <svg className="w-5 h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                </div>
                <div>
                  <p className="text-sm text-gray-500">{labels.phone_label || 'Teléfono'}</p>
                  <p className="font-medium text-navy">{data.phone}</p>
                </div>
              </div>
              <div className="flex items-center gap-4">
                <div className="w-12 h-12 rounded-2xl bg-terracotta/10 flex items-center justify-center">
                  <svg className="w-5 h-5 text-terracotta" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>
                  <p className="text-sm text-gray-500">{labels.email_label || 'Correo'}</p>
                  <p className="font-medium text-navy">{data.email}</p>
                </div>
              </div>
            </div>
          </motion.div>

          <motion.form
            className="warm-surface rounded-3xl p-8 lg:p-10"
            onSubmit={handleSubmit}
            noValidate
            initial={{ opacity: 0, x: 24 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.7 }}
          >
            {success ? (
              <div className="rounded-2xl bg-terracotta/10 border border-terracotta/20 p-6 text-center" role="status">
                <p className="font-display text-lg text-navy font-bold mb-2">{labels.success_title}</p>
                <p className="text-sm text-gray-600">{labels.success_message}</p>
              </div>
            ) : null}
            {submitError ? (
              <div className="rounded-2xl bg-red-50 border border-red-200 p-4 text-sm text-red-700 mb-4" role="alert">
                {submitError}
              </div>
            ) : null}
            <div className={`space-y-5 ${success ? 'mt-6' : ''}`}>
              {[
                { id: 'nombre', type: 'text', autoComplete: 'name' },
                { id: 'correo', type: 'email', autoComplete: 'email' },
                { id: 'telefono', type: 'tel', autoComplete: 'tel' },
              ].map((field) => (
                <div key={field.id}>
                  <label htmlFor={field.id} className="block text-sm font-medium text-navy mb-2">
                    {labels[field.id]}
                  </label>
                  <input
                    type={field.type}
                    id={field.id}
                    name={field.id}
                    value={form[field.id]}
                    onChange={handleChange}
                    autoComplete={field.autoComplete}
                    required
                    disabled={submitting}
                    className={`form-input w-full px-4 py-3 rounded-2xl border text-sm bg-white transition-all duration-300 ${errors[field.id] ? 'border-red-400' : 'border-terracotta/20'}`}
                    placeholder={labels[`${field.id}_placeholder`]}
                    aria-invalid={Boolean(errors[field.id])}
                    aria-describedby={errors[field.id] ? `${field.id}-error` : undefined}
                  />
                  {errors[field.id] ? (
                    <p id={`${field.id}-error`} className="mt-1 text-xs text-red-600" role="alert">
                      {errors[field.id]}
                    </p>
                  ) : null}
                </div>
              ))}
              <div>
                <label htmlFor="mensaje" className="block text-sm font-medium text-navy mb-2">
                  {labels.mensaje}
                </label>
                <textarea
                  id="mensaje"
                  name="mensaje"
                  rows={4}
                  value={form.mensaje}
                  onChange={handleChange}
                  disabled={submitting}
                  className="form-input w-full px-4 py-3 rounded-2xl border border-terracotta/20 text-sm bg-white transition-all duration-300 resize-none"
                  placeholder={labels.mensaje_placeholder}
                />
              </div>
              <button
                type="submit"
                disabled={submitting}
                className="btn-terracotta-glow w-full py-4 bg-terracotta text-white font-semibold rounded-2xl hover:bg-terracotta-dark transition-all duration-300 text-sm disabled:opacity-60"
              >
                {submitting ? 'Enviando…' : data.submit_label}
              </button>
            </div>
          </motion.form>
        </div>
      </div>
    </section>
  );
}
