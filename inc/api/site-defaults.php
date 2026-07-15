<?php
/**
 * Casa Noble default site payload (mirrors src/services/mockData.js).
 * Used when CMB2 options are empty (not yet saved).
 *
 * @package HomeSeaTheme
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default site data matching React mockData shape.
 *
 * @return array<string, mixed>
 */
function homesea_theme_site_defaults(): array {
	return array(
		'header' => array(
			'logo_text_parts' => array(
				'first'  => 'Casa',
				'second' => 'Noble',
			),
			'nav'       => array(
				array( 'label' => 'Inicio', 'url' => '#inicio' ),
				array( 'label' => 'Propiedades', 'url' => '#propiedades' ),
				array( 'label' => 'Proyectos', 'url' => '#proyectos' ),
				array( 'label' => 'Nosotros', 'url' => '#nosotros' ),
				array( 'label' => 'Blog', 'url' => '#blog' ),
				array( 'label' => 'Contacto', 'url' => '#contacto' ),
			),
			'cta_label' => 'Reserva una visita',
			'cta_url'   => '#contacto',
		),
		'hero' => array(
			'image_url'       => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1920&q=80&auto=format&fit=crop',
			'image_alt'       => 'Villa mediterránea de lujo con piscina y jardín al atardecer',
			'eyebrow'         => 'Inmobiliaria mediterránea desde 2008',
			'title'           => 'Hogares con alma bajo el sol mediterráneo',
			'subtitle'        => 'Villas, fincas y residencias seleccionadas con criterio en la Costa del Sol, Baleares y la Riviera. Te acompañamos con calidez en cada paso.',
			'primary_label'   => 'Explorar propiedades',
			'primary_url'     => '#propiedades',
			'secondary_label' => 'Hablar con un asesor',
			'secondary_url'   => '#contacto',
			'search'          => array(
				'title'         => 'Encuentra tu refugio',
				'description'   => 'Busca entre nuestra colección curada de propiedades mediterráneas',
				'types'         => array(
					array( 'value' => 'villa', 'label' => 'Villa' ),
					array( 'value' => 'finca', 'label' => 'Finca' ),
					array( 'value' => 'apartamento', 'label' => 'Apartamento' ),
					array( 'value' => 'terreno', 'label' => 'Terreno' ),
				),
				'submit_label'  => 'Buscar propiedades',
			),
		),
		'stats' => array(
			'items' => array(
				array(
					'id'    => 'properties',
					'label' => 'Propiedades exclusivas',
					'value' => '+850',
					'icon'  => 'home',
				),
				array(
					'id'    => 'families',
					'label' => 'Familias acompañadas',
					'value' => '+620',
					'icon'  => 'users',
				),
				array(
					'id'    => 'years',
					'label' => 'Años de experiencia',
					'value' => '18',
					'icon'  => 'clock',
				),
				array(
					'id'    => 'satisfaction',
					'label' => 'Clientes satisfechos',
					'value' => '97%',
					'icon'  => 'star',
				),
			),
		),
		'properties' => array(
			'eyebrow'       => 'Colección curada',
			'title'         => 'Propiedades destacadas',
			'catalog_label' => 'Ver catálogo completo',
			'catalog_url'   => '#',
			'items'         => array(
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Villa mediterránea con terraza y vistas al mar en Marbella',
					'badge'         => 'En venta',
					'badge_variant' => 'terracotta',
					'price'         => '€ 1.850.000',
					'location'      => 'Golden Mile, Marbella — Málaga',
					'beds'          => 5,
					'baths'         => 4,
					'area'          => '480 m²',
					'details_url'   => '#',
				),
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1600047509806-ba53f78459ca?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Finca rústica de lujo con olivos en Mallorca',
					'badge'         => 'Exclusiva',
					'badge_variant' => 'gold',
					'price'         => '€ 2.400.000',
					'location'      => 'Deià, Mallorca — Baleares',
					'beds'          => 6,
					'baths'         => 5,
					'area'          => '620 m²',
					'details_url'   => '#',
				),
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1600565893085-3571767115e6?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Villa contemporánea con piscina en la Costa Brava',
					'badge'         => 'En venta',
					'badge_variant' => 'terracotta',
					'price'         => '€ 975.000',
					'location'      => 'Begur, Costa Brava — Girona',
					'beds'          => 4,
					'baths'         => 3,
					'area'          => '340 m²',
					'details_url'   => '#',
				),
			),
		),
		'about' => array(
			'eyebrow' => 'Nuestra esencia',
			'title'   => '¿Por qué Casa Noble?',
			'body'    => 'No vendemos metros cuadrados: acompañamos decisiones de vida con la calidez de quien conoce cada rincón del Mediterráneo.',
			'items'   => array(
				array(
					'title'       => 'Trato cercano',
					'description' => 'Un asesor dedicado que te escucha, entiende tu estilo de vida y te guía sin presiones.',
					'icon'        => 'heart',
				),
				array(
					'title'       => 'Conocimiento local',
					'description' => '18 años en la Costa del Sol, Baleares y la Riviera. Conocemos cada barrio, cada calle y cada oportunidad.',
					'icon'        => 'globe',
				),
				array(
					'title'       => 'Transparencia total',
					'description' => 'Due diligence completa, informes claros y acompañamiento legal en cada transacción internacional.',
					'icon'        => 'shield',
				),
				array(
					'title'       => 'Red de confianza',
					'description' => 'Arquitectos, abogados, gestores y artesanos de confianza para reformar y personalizar tu hogar.',
					'icon'        => 'building',
				),
			),
		),
		'projects' => array(
			'eyebrow' => 'Desarrollos selectos',
			'title'   => 'Proyectos recientes',
			'items'   => array(
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Residencial Vista del Mar en Estepona',
					'badge'         => 'En construcción',
					'badge_variant' => 'terracotta',
					'title'         => 'Residencial Vista del Mar',
					'location'      => 'Estepona, Málaga',
					'url'           => '#',
				),
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Fincas del Olivar en Sóller',
					'badge'         => 'Pre-venta',
					'badge_variant' => 'gold',
					'title'         => 'Fincas del Olivar',
					'location'      => 'Sóller, Mallorca',
					'url'           => '#',
				),
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Villas Mediterráneo en Calpe',
					'badge'         => 'Entrega 2027',
					'badge_variant' => 'navy',
					'title'         => 'Villas Mediterráneo',
					'location'      => 'Calpe, Alicante',
					'url'           => '#',
				),
				array(
					'image_url'     => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800&q=80&auto=format&fit=crop',
					'image_alt'     => 'Cortijo Blanco en Ronda',
					'badge'         => 'En construcción',
					'badge_variant' => 'terracotta',
					'title'         => 'Cortijo Blanco',
					'location'      => 'Ronda, Málaga',
					'url'           => '#',
				),
			),
		),
		'testimonials' => array(
			'eyebrow' => 'Testimonios',
			'title'   => 'Historias de familias que confiaron en nosotros',
			'items'   => array(
				array(
					'quote'      => 'Compramos nuestra villa en Marbella con Casa Noble. Elena nos acompañó durante ocho meses con paciencia infinita. Sentimos que teníamos a alguien de confianza, no a un vendedor.',
					'name'       => 'Isabel Moreno',
					'location'   => 'Marbella, Málaga',
					'avatar_url' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&q=80&auto=format&fit=crop',
					'rating'     => 5,
				),
				array(
					'quote'      => 'Desde Suiza buscábamos una finca en Mallorca. Casa Noble coordinó visitas virtuales, traducciones y toda la parte legal. Hoy disfrutamos de nuestra casa de verano sin haber tenido que viajar diez veces.',
					'name'       => 'Thomas Weber',
					'location'   => 'Deià, Mallorca',
					'avatar_url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80&auto=format&fit=crop',
					'rating'     => 5,
				),
				array(
					'quote'      => 'Vendimos nuestro apartamento en Estepona en tres semanas. El equipo supo valorar la propiedad correctamente y encontró compradores serios. Profesionales y humanos a la vez.',
					'name'       => 'Carmen Ruiz',
					'location'   => 'Estepona, Málaga',
					'avatar_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&q=80&auto=format&fit=crop',
					'rating'     => 5,
				),
			),
		),
		'process' => array(
			'eyebrow' => 'Simple y transparente',
			'title'   => 'Tu camino hacia el hogar ideal',
			'steps'   => array(
				array(
					'number'      => '01',
					'title'       => 'Explorar',
					'description' => 'Descubre nuestra selección mediterránea curada',
					'icon'        => 'search',
				),
				array(
					'number'      => '02',
					'title'       => 'Visitar',
					'description' => 'Recorridos presenciales o virtuales a tu medida',
					'icon'        => 'eye',
				),
				array(
					'number'      => '03',
					'title'       => 'Financiar',
					'description' => 'Opciones hipotecarias locales e internacionales',
					'icon'        => 'card',
				),
				array(
					'number'      => '04',
					'title'       => 'Firmar',
					'description' => 'Documentación verificada con total transparencia',
					'icon'        => 'document',
				),
				array(
					'number'      => '05',
					'title'       => 'Disfrutar',
					'description' => 'Bienvenido a tu refugio mediterráneo',
					'icon'        => 'smile',
				),
			),
		),
		'location' => array(
			'title'     => 'Oficina Marbella — Costa del Sol',
			'address'   => 'Paseo Marítimo 42, Planta 2 · 29600 Marbella, Málaga',
			'maps_url'  => 'https://maps.google.com/?q=Paseo+Maritimo+42+Marbella',
			'cta_label' => 'Cómo llegar',
		),
		'contact' => array(
			'eyebrow'      => 'Contacto',
			'title'        => 'Cuéntanos qué buscas',
			'body'         => 'Completa el formulario y un asesor de Casa Noble te contactará en menos de 24 horas. Sin compromiso, con la calidez que nos caracteriza.',
			'phone'        => '+34 952 123 456',
			'email'        => 'hola@casanoble.es',
			'submit_label' => 'Quiero que me contacten',
			'cf7'          => array(
				'enabled'  => false,
				'form_id'  => 0,
				'rest_url' => '',
				'unit_tag' => '',
				'locale'   => '',
				'version'  => '',
				'fields'   => array(
					'nombre'   => 'your-name',
					'correo'   => 'your-email',
					'telefono' => 'your-phone',
					'mensaje'  => 'your-message',
				),
				'flamingo' => false,
			),
			'form_labels'  => array(
				'nombre'              => 'Nombre',
				'nombre_placeholder'  => 'Tu nombre completo',
				'nombre_error'        => 'El nombre es obligatorio.',
				'correo'              => 'Correo',
				'correo_placeholder'  => 'tu@email.com',
				'correo_error'        => 'El correo es obligatorio.',
				'correo_invalid'      => 'Introduce un correo válido.',
				'telefono'            => 'Teléfono',
				'telefono_placeholder'=> '+34 600 000 000',
				'telefono_error'      => 'El teléfono es obligatorio.',
				'mensaje'             => 'Mensaje',
				'mensaje_placeholder' => 'Cuéntanos qué tipo de propiedad mediterránea buscas...',
				'phone_label'         => 'Teléfono',
				'email_label'         => 'Correo',
				'success_title'       => '¡Mensaje enviado!',
				'success_message'     => 'Un asesor de Casa Noble te contactará en menos de 24 horas.',
				'submit_error'        => 'No se pudo enviar el mensaje. Inténtalo de nuevo.',
			),
		),
		'footer' => array(
			'brand'         => 'Casa Noble',
			'brand_parts'   => array(
				'first'  => 'Casa',
				'second' => 'Noble',
			),
			'tagline'       => 'Tu aliado de confianza en el mercado inmobiliario mediterráneo. Desde 2008 conectando familias con hogares que tienen alma.',
			'socials'       => array(
				array( 'label' => 'Instagram', 'url' => '#', 'icon' => 'instagram' ),
				array( 'label' => 'LinkedIn', 'url' => '#', 'icon' => 'linkedin' ),
				array( 'label' => 'Facebook', 'url' => '#', 'icon' => 'facebook' ),
			),
			'quick_links'   => array(
				array( 'label' => 'Propiedades', 'url' => '#propiedades' ),
				array( 'label' => 'Proyectos', 'url' => '#proyectos' ),
				array( 'label' => 'Nosotros', 'url' => '#nosotros' ),
				array( 'label' => 'Contacto', 'url' => '#contacto' ),
			),
			'contact_lines' => array(
				'+34 952 123 456',
				'hola@casanoble.es',
				'Paseo Marítimo 42, Planta 2',
				'29600 Marbella, Málaga',
			),
			'legal_links'   => array(
				array( 'label' => 'Política de privacidad', 'url' => '#' ),
				array( 'label' => 'Términos y condiciones', 'url' => '#' ),
			),
			'copyright'     => '© 2026 Casa Noble Inmobiliaria. Todos los derechos reservados.',
		),
		'seo' => array(
			'title'       => 'Casa Noble | Inmobiliaria Premium Mediterránea — Tu hogar con alma',
			'description' => 'Casa Noble: propiedades mediterráneas de lujo en la Costa del Sol, Mallorca y la Riviera. Más de 18 años conectando familias con villas, fincas y residencias con carácter y calidez.',
		),
	);
}
