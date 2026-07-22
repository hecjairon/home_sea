/**
 * Submit React contact form to Contact Form 7 REST feedback endpoint.
 *
 * @param {{ nombre: string, correo: string, telefono: string, mensaje: string }} values
 * @param {{
 *   enabled?: boolean,
 *   form_id?: number,
 *   rest_url?: string,
 *   unit_tag?: string,
 *   locale?: string,
 *   version?: string,
 *   fields?: Record<string, string>
 * }} cf7
 * @returns {Promise<{ ok: true } | { ok: false, message: string, fieldErrors?: Record<string, string> }>}
 */
export async function submitContactToCf7(values, cf7) {
  if (!cf7?.enabled || !cf7.form_id || !cf7.rest_url) {
    return {
      ok: false,
      message: 'Contact Form 7 no está configurado. Revisa el ID del formulario en Configuración Theme → Contacto.',
    };
  }

  const fields = cf7.fields || {};
  const body = new FormData();

  body.append('_wpcf7', String(cf7.form_id));
  body.append('_wpcf7_version', cf7.version || '');
  body.append('_wpcf7_locale', cf7.locale || '');
  body.append('_wpcf7_unit_tag', cf7.unit_tag || `wpcf7-f${cf7.form_id}-o1`);
  body.append('_wpcf7_container_post', '0');
  body.append('_wpcf7_posted_data_hash', '');

  if (fields.nombre) body.append(fields.nombre, values.nombre.trim());
  if (fields.correo) body.append(fields.correo, values.correo.trim());
  if (fields.telefono) body.append(fields.telefono, values.telefono.trim());
  if (fields.mensaje) body.append(fields.mensaje, values.mensaje.trim());

  // Hidden CF7 subject used by Flamingo listing / mail subject tags.
  body.append('your-subject', 'Solicitud de contacto Villa Hermosa');

  const response = await fetch(cf7.rest_url, {
    method: 'POST',
    body,
    credentials: 'same-origin',
  });

  let payload;
  try {
    payload = await response.json();
  } catch {
    return { ok: false, message: 'Respuesta inválida del servidor.' };
  }

  // mail_sent = ideal. mail_failed = SMTP can fail in Docker while Flamingo still stores the message.
  if (payload?.status === 'mail_sent' || (cf7.flamingo && payload?.status === 'mail_failed')) {
    return { ok: true };
  }

  // Validation errors.
  const fieldErrors = {};
  const invalid = Array.isArray(payload?.invalid_fields) ? payload.invalid_fields : [];
  const reverse = Object.fromEntries(
    Object.entries(fields).map(([logical, name]) => [name, logical]),
  );

  for (const item of invalid) {
    const cf7Name = item?.field;
    const logical = reverse[cf7Name];
    if (logical && item?.message) {
      fieldErrors[logical] = String(item.message);
    }
  }

  return {
    ok: false,
    message: typeof payload?.message === 'string' ? stripHtml(payload.message) : '',
    fieldErrors,
  };
}

/**
 * @param {string} html
 */
function stripHtml(html) {
  return html.replace(/<[^>]*>/g, ' ').replace(/\s+/g, ' ').trim();
}
