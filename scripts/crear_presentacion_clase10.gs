/**
 * Crea una presentación de 30 diapositivas para la clase 10 de Desarrollo
 * Backend I, usando el proyecto Animals & Species como caso de estudio.
 *
 * Ejecución: pegar el archivo en un proyecto de Google Apps Script y ejecutar
 * crearPresentacionClase10Animals. La URL se registra en el registro de
 * ejecución y también se devuelve como resultado.
 */
function crearPresentacionClase10Animals() {
  const slides = obtenerContenidoClase10Animals_();
  validarContenidoClase10Animals_(slides);

  const presentation = SlidesApp.create(
    'Desarrollo Backend I - Clase 10 - Animals & Species'
  );
  const existingSlides = presentation.getSlides();
  const firstSlide = existingSlides[0];

  for (let index = existingSlides.length - 1; index > 0; index -= 1) {
    existingSlides[index].remove();
  }
  firstSlide.getPageElements().forEach(function (element) {
    element.remove();
  });

  slides.forEach(function (slideData, index) {
    const slide = index === 0
      ? firstSlide
      : presentation.appendSlide(SlidesApp.PredefinedLayout.BLANK);
    dibujarDiapositivaClase10_(
      slide,
      slideData,
      index + 1,
      slides.length,
      presentation
    );
  });

  const createdSlides = presentation.getSlides();
  if (createdSlides.length !== 30) {
    throw new Error(
      'Se crearon ' + createdSlides.length +
      ' diapositivas; el requisito es exactamente 30.'
    );
  }

  Logger.log('Presentación creada: ' + presentation.getUrl());
  return presentation.getUrl();
}

function validarContenidoClase10Animals_(slides) {
  if (!Array.isArray(slides) || slides.length !== 30) {
    throw new Error('El contenido debe definir exactamente 30 diapositivas.');
  }

  slides.forEach(function (slide, index) {
    if (!slide.title || !slide.lead || !slide.takeaway) {
      throw new Error(
        'La diapositiva ' + (index + 1) +
        ' necesita título, explicación y síntesis.'
      );
    }
    if (slide.layout === 'code' || slide.layout === 'wideCode') {
      if (!slide.code || !slide.codeTitle) {
        throw new Error(
          'La diapositiva ' + (index + 1) +
          ' necesita un fragmento y su contexto.'
        );
      }
    }
  });
}

function dibujarDiapositivaClase10_(slide, data, slideNumber, totalSlides, presentation) {
  const width = presentation.getPageWidth();
  const height = presentation.getPageHeight();
  const colors = {
    background: '#1E293B',
    code: '#0F172A',
    white: '#F8FAFC',
    muted: '#CBD5E1',
    secondary: '#94A3B8',
    emerald: '#10B981',
    cyan: '#06B6D4',
    codeGreen: '#4ADE80',
    codeCyan: '#67E8F9',
    panel: '#263449'
  };
  const accent = data.accent === 'cyan' ? colors.cyan : colors.emerald;

  slide.getBackground().setSolidFill(colors.background);
  if (data.layout === 'cover') {
    dibujarPortadaClase10_(slide, data, width, height, colors);
    return;
  }

  insertarTextoClase10_(
    slide,
    data.section.toUpperCase(),
    34,
    17,
    width - 68,
    16,
    10,
    accent,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    data.title,
    34,
    37,
    width - 68,
    43,
    data.title.length > 49 ? 23 : 27,
    colors.white,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    data.lead,
    34,
    84,
    width - 68,
    39,
    14,
    colors.muted,
    false,
    'Cambria'
  );

  if (data.layout === 'flow') {
    dibujarFlujoClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'code') {
    dibujarCodigoClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'wideCode') {
    dibujarCodigoAnchoClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'compare') {
    dibujarComparacionClase10_(slide, data, width, colors, accent);
  } else if (data.layout === 'quiz') {
    dibujarPreguntaClase10_(slide, data, width, colors, accent);
  } else {
    dibujarDosPanelesClase10_(slide, data, width, colors, accent);
  }

  dibujarCierreClase10_(
    slide,
    data.takeaway,
    slideNumber,
    totalSlides,
    width,
    height,
    colors,
    accent
  );
}

function dibujarPortadaClase10_(slide, data, width, height, colors) {
  slide.getBackground().setSolidFill(colors.background);
  dibujarRectanguloClase10_(slide, 36, 35, 8, 282, colors.emerald);
  insertarTextoClase10_(
    slide,
    'DESARROLLO BACKEND I  /  TUPW',
    66,
    40,
    width - 110,
    22,
    13,
    colors.cyan,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    data.title,
    66,
    82,
    width - 130,
    105,
    38,
    colors.white,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    data.lead,
    68,
    194,
    width - 145,
    60,
    18,
    colors.muted,
    false,
    'Cambria'
  );

  const cardY = 278;
  const cardWidth = (width - 116) / data.cards.length;
  data.cards.forEach(function (card, index) {
    const x = 36 + index * (cardWidth + 22);
    dibujarTarjetaClase10_(slide, x, cardY, cardWidth, 74, colors.panel);
    insertarTextoClase10_(
      slide,
      card,
      x + 14,
      cardY + 13,
      cardWidth - 28,
      52,
      13,
      colors.white,
      true,
      'Cambria'
    );
  });
  insertarTextoClase10_(
    slide,
    data.takeaway,
    38,
    height - 27,
    width - 76,
    15,
    9,
    colors.secondary,
    false,
    'Cambria'
  );
}

function dibujarDosPanelesClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const gap = 18;
  const panelWidth = (width - margin * 2 - gap) / 2;
  const top = 130;
  const panelHeight = 213;

  dibujarTarjetaClase10_(slide, margin, top, panelWidth, panelHeight, colors.panel);
  dibujarTarjetaClase10_(
    slide,
    margin + panelWidth + gap,
    top,
    panelWidth,
    panelHeight,
    colors.panel
  );
  insertarTextoClase10_(
    slide,
    data.leftTitle || 'ENFOQUE',
    margin + 14,
    top + 12,
    panelWidth - 28,
    20,
    12,
    accent,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.left || []),
    margin + 14,
    top + 40,
    panelWidth - 28,
    panelHeight - 50,
    14,
    colors.muted,
    false,
    'Cambria'
  );

  const rightX = margin + panelWidth + gap;
  insertarTextoClase10_(
    slide,
    data.rightTitle || 'PARA COMPROBAR',
    rightX + 14,
    top + 12,
    panelWidth - 28,
    20,
    12,
    colors.cyan,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.right || []),
    rightX + 14,
    top + 40,
    panelWidth - 28,
    panelHeight - 50,
    14,
    colors.muted,
    false,
    'Cambria'
  );
}

function dibujarCodigoClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const codeWidth = width * 0.62;
  const rightX = margin + codeWidth + 16;
  const rightWidth = width - rightX - margin;
  const top = 130;
  const panelHeight = 213;

  dibujarTarjetaClase10_(slide, margin, top, codeWidth, panelHeight, colors.code);
  insertarTextoClase10_(
    slide,
    data.codeTitle,
    margin + 14,
    top + 10,
    codeWidth - 28,
    17,
    10,
    accent,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    data.code,
    margin + 14,
    top + 34,
    codeWidth - 28,
    panelHeight - 43,
    data.codeSize || 11,
    data.codeColor === 'cyan' ? colors.codeCyan : colors.codeGreen,
    false,
    'Consolas'
  );

  dibujarTarjetaClase10_(slide, rightX, top, rightWidth, panelHeight, colors.panel);
  insertarTextoClase10_(
    slide,
    data.rightTitle || 'LECTURA GUIADA',
    rightX + 13,
    top + 12,
    rightWidth - 26,
    20,
    11,
    colors.cyan,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.right || []),
    rightX + 13,
    top + 40,
    rightWidth - 26,
    panelHeight - 50,
    13,
    colors.muted,
    false,
    'Cambria'
  );
}

function dibujarCodigoAnchoClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const panelWidth = width - margin * 2;
  dibujarTarjetaClase10_(slide, margin, 130, panelWidth, 185, colors.code);
  insertarTextoClase10_(
    slide,
    data.codeTitle,
    margin + 14,
    140,
    panelWidth - 28,
    18,
    10,
    accent,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    data.code,
    margin + 14,
    163,
    panelWidth - 28,
    150,
    data.codeSize || 11,
    data.codeColor === 'cyan' ? colors.codeCyan : colors.codeGreen,
    false,
    'Consolas'
  );
  dibujarTarjetaClase10_(slide, margin, 320, panelWidth, 23, colors.panel);
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.right || []),
    margin + 13,
    322,
    panelWidth - 26,
    19,
    10,
    colors.muted,
    false,
    'Cambria'
  );
}

function dibujarComparacionClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const gap = 18;
  const cardWidth = (width - margin * 2 - gap) / 2;
  const top = 130;
  const cardHeight = 213;

  dibujarTarjetaClase10_(slide, margin, top, cardWidth, cardHeight, colors.panel);
  dibujarTarjetaClase10_(
    slide,
    margin + cardWidth + gap,
    top,
    cardWidth,
    cardHeight,
    colors.panel
  );
  insertarTextoClase10_(
    slide,
    data.leftTitle,
    margin + 14,
    top + 12,
    cardWidth - 28,
    22,
    13,
    accent,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.left || []),
    margin + 14,
    top + 44,
    cardWidth - 28,
    cardHeight - 55,
    14,
    colors.muted,
    false,
    'Cambria'
  );
  const rightX = margin + cardWidth + gap;
  insertarTextoClase10_(
    slide,
    data.rightTitle,
    rightX + 14,
    top + 12,
    cardWidth - 28,
    22,
    13,
    colors.cyan,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.right || []),
    rightX + 14,
    top + 44,
    cardWidth - 28,
    cardHeight - 55,
    14,
    colors.muted,
    false,
    'Cambria'
  );
}

function dibujarFlujoClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  const gap = 10;
  const cardWidth =
    (width - margin * 2 - gap * (data.steps.length - 1)) / data.steps.length;
  const top = 157;

  data.steps.forEach(function (step, index) {
    const x = margin + index * (cardWidth + gap);
    dibujarTarjetaClase10_(slide, x, top, cardWidth, 119, colors.panel);
    insertarTextoClase10_(
      slide,
      '0' + (index + 1),
      x + 12,
      top + 11,
      cardWidth - 24,
      17,
      11,
      accent,
      true,
      'Cambria'
    );
    insertarTextoClase10_(
      slide,
      step,
      x + 12,
      top + 37,
      cardWidth - 24,
      72,
      13,
      colors.white,
      true,
      'Cambria'
    );
  });
  insertarTextoClase10_(
    slide,
    data.flowNote || '',
    margin,
    292,
    width - margin * 2,
    43,
    14,
    colors.muted,
    false,
    'Cambria'
  );
}

function dibujarPreguntaClase10_(slide, data, width, colors, accent) {
  const margin = 34;
  dibujarTarjetaClase10_(slide, margin, 132, width - margin * 2, 205, colors.panel);
  insertarTextoClase10_(
    slide,
    data.prompt,
    margin + 22,
    150,
    width - margin * 2 - 44,
    61,
    21,
    colors.white,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    convertirListaClase10_(data.options || []),
    margin + 24,
    225,
    width - margin * 2 - 48,
    85,
    15,
    colors.muted,
    false,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    'PREDICE  →  PRUEBA  →  EXPLICA',
    margin + 22,
    311,
    width - margin * 2 - 44,
    17,
    10,
    accent,
    true,
    'Cambria'
  );
}

function dibujarCierreClase10_(slide, takeaway, slideNumber, totalSlides, width, height, colors, accent) {
  dibujarRectanguloClase10_(slide, 34, height - 43, width - 68, 1.5, accent);
  insertarTextoClase10_(
    slide,
    takeaway,
    34,
    height - 39,
    width - 170,
    19,
    10,
    colors.white,
    true,
    'Cambria'
  );
  insertarTextoClase10_(
    slide,
    slideNumber + ' / ' + totalSlides,
    width - 90,
    height - 39,
    56,
    19,
    10,
    colors.secondary,
    false,
    'Cambria'
  );
}

function dibujarTarjetaClase10_(slide, x, y, width, height, fill) {
  const shape = slide.insertShape(
    SlidesApp.ShapeType.ROUND_RECTANGLE,
    x,
    y,
    width,
    height
  );
  shape.getFill().setSolidFill(fill);
}

function dibujarRectanguloClase10_(slide, x, y, width, height, fill) {
  const shape = slide.insertShape(
    SlidesApp.ShapeType.RECTANGLE,
    x,
    y,
    width,
    height
  );
  shape.getFill().setSolidFill(fill);
}

function insertarTextoClase10_(slide, text, x, y, width, height, size, color, bold, fontFamily) {
  const box = slide.insertTextBox(text, x, y, width, height);
  box.setContentAlignment(SlidesApp.ContentAlignment.TOP);
  const textRange = box.getText();
  textRange.getTextStyle()
    .setFontFamily(fontFamily)
    .setFontSize(size)
    .setForegroundColor(color)
    .setBold(bold);
  textRange.getParagraphStyle().setLineSpacing(115);
  return box;
}

function convertirListaClase10_(items) {
  return items.map(function (item) {
    return '• ' + item;
  }).join('\n');
}

function obtenerContenidoClase10Animals_() {
  return [
    {
      layout: 'cover',
      title: 'De texto libre a relación íntegra',
      lead: 'Refactorizamos Animals & Species: migración segura, SQL con JOIN y formularios Blade por ID.',
      cards: [
        'CLASE 10  |  DESARROLLO BACKEND I',
        'PROYECTO  |  ANIMALS & SPECIES',
        '120 MIN  |  LIVE CODING GUIADO'
      ],
      takeaway: 'La clase recorre el dato desde el esquema relacional hasta la interfaz.'
    },
    {
      section: 'Apertura y propósito',
      title: 'Resultados de aprendizaje',
      lead: 'Al terminar, podrás explicar el cambio completo y justificar cómo se verifica.',
      leftTitle: 'PODRÁS',
      left: [
        'Migrar datos legados sin descartar asociaciones.',
        'Guardar species_id y consultar la etiqueta con JOIN.',
        'Mantener el contrato que consumen las vistas.',
        'Validar el ID y sostener la experiencia del formulario.'
      ],
      rightTitle: 'RITMO DE 120 MINUTOS',
      right: [
        'Desafío y contrato: 8 min.',
        'Migración con datos: 22 min.',
        'Servicio SQL: 22 min.',
        'Controller y Blade: 20 min.',
        'Request y pruebas: 16 min.',
        'Verificación y cierre: 32 min.'
      ],
      takeaway: 'Cada fragmento se predice, se codifica y se verifica.',
      accent: 'cyan'
    },
    {
      section: 'Apertura y propósito',
      title: 'El problema: el nombre no es una identidad',
      lead: 'Si cada animal guarda la especie como texto, una corrección puede quedar inconsistente.',
      layout: 'compare',
      leftTitle: 'ANTES',
      left: [
        'animals.species = "Gato"',
        'El mismo concepto se repite por fila.',
        'Errores de escritura crean variantes.',
        'Renombrar implica actualizar muchos animales.'
      ],
      rightTitle: 'PREGUNTA DE ACTIVACIÓN',
      right: [
        '¿Qué pasa si "Gato" cambia a "Gato doméstico"?',
        '¿Cómo identificamos la misma especie?',
        '¿Qué dato debería viajar desde el formulario?',
        'Predice qué archivos habrá que modificar.'
      ],
      takeaway: 'La etiqueta es para mostrar; la clave estable identifica.'
    },
    {
      section: 'Apertura y propósito',
      title: 'La relación cambia; el contrato de lectura se cuida',
      lead: 'La vista puede seguir recibiendo las mismas claves aunque cambie el almacenamiento.',
      layout: 'flow',
      steps: [
        'animals.species es texto legado.',
        'species.id identifica el catálogo.',
        'animals.species_id guarda la FK.',
        'JOIN devuelve species.name a Blade.'
      ],
      flowNote: 'Contrato esperado para listado: id, name, species, age. Editar también necesita species_id.',
      takeaway: 'Refactorizar internamente no obliga a renombrar cada consumidor.',
      accent: 'cyan'
    },
    {
      section: 'Migración y modelo',
      title: 'Modelo destino: una especie, muchos animales',
      lead: 'La tabla de catálogo concentra nombres; cada animal conserva una referencia.',
      layout: 'compare',
      leftTitle: 'species',
      left: [
        'id: clave primaria.',
        'name: nombre visible del catálogo.',
        'Un registro representa una especie.'
      ],
      rightTitle: 'animals',
      right: [
        'id, name, age.',
        'species_id referencia species.id.',
        'Cada animal pertenece a una especie.'
      ],
      takeaway: 'La FK evita que animals apunte a una especie inexistente.'
    },
    {
      section: 'Migración y modelo',
      title: 'Antes de migrar: inventariar los datos reales',
      lead: 'Un backfill depende de que cada texto legado pueda asociarse a una fila del catálogo.',
      leftTitle: 'CONSULTAR Y COMPARAR',
      left: [
        'Listar valores distintos de animals.species.',
        'Compararlos con species.name.',
        'Buscar espacios, mayúsculas y acentos distintos.',
        'Detectar nombres duplicados en el catálogo.'
      ],
      rightTitle: 'NO AUTOMATIZAR A CIEGAS',
      right: [
        'Resolver valores sin correspondencia.',
        'Definir qué hacer con duplicados ambiguos.',
        'Respaldar datos y probar en una copia.',
        'Anotar conteos antes de cambiar el esquema.'
      ],
      takeaway: 'Primero sabemos qué hay; después escribimos la migración.',
      accent: 'cyan'
    },
    {
      section: 'Migración y modelo',
      title: 'Etapa 1: añadir la clave sin borrar el origen',
      lead: 'La columna nullable permite completar las filas existentes antes de exigir la relación.',
      layout: 'code',
      codeTitle: 'PRIMERA ETAPA DE SCHEMA',
      code: `Schema::table('animals', function (Blueprint $table) {
    $table->foreignId('species_id')
        ->nullable()
        ->constrained('species')
        ->restrictOnDelete();
});`,
      rightTitle: 'LIVE CODING · PREDICE',
      right: [
        'La columna vieja species todavía existe.',
        'Las filas antiguas pueden esperar el backfill.',
        'species_id referencia species.id.',
        'RESTRICT expresa la política de dominio elegida.'
      ],
      takeaway: 'Evolucionamos el esquema por etapas para preservar datos.'
    },
    {
      section: 'Migración y modelo',
      title: 'Etapa 2: backfill con correspondencias explícitas',
      lead: 'El ejemplo busca el ID por nombre y aborta si un texto no se puede mapear.',
      layout: 'wideCode',
      codeTitle: 'PATRÓN PHP PARA COMPLETAR LAS FILAS EXISTENTES',
      codeSize: 9.5,
      code: `DB::transaction(function () {
    $idsByName = DB::table('species')->pluck('id', 'name');
    DB::table('animals')->orderBy('id')->chunkById(100, function ($rows) use ($idsByName) {
        foreach ($rows as $animal) {
            if (!$idsByName->has($animal->species)) {
                throw new RuntimeException('Especie sin correspondencia: ' . $animal->species);
            }
            DB::table('animals')->where('id', $animal->id)
                ->update(['species_id' => $idsByName[$animal->species]]);
        }
    });
});`,
      right: [
        'La transacción evita dejar un backfill parcial si una asociación falla.'
      ],
      takeaway: 'No se elimina el dato legado hasta confirmar el mapeo.',
      accent: 'cyan'
    },
    {
      section: 'Migración y modelo',
      title: 'Etapa 3: verificar, restringir y retirar el texto',
      lead: 'La transición termina sólo cuando conteos y referencias confirman consistencia.',
      layout: 'compare',
      leftTitle: 'COMPROBACIONES',
      left: [
        'No quedan species_id nulos antes de exigir NOT NULL.',
        'No hay IDs sin especie asociada.',
        'El número de animales se conserva.',
        'La FK impide referencias huérfanas.'
      ],
      rightTitle: 'CONTRASTE CON EL CAMBIO ACTUAL',
      right: [
        'La migración del repositorio elimina species al inicio.',
        'Eso descarta el valor necesario para el backfill.',
        'down() agrega un string vacío, no restaura el original.',
        'Probar DDL y rollback específicamente con SQLite.'
      ],
      takeaway: 'Esquema reversible no significa automáticamente datos recuperables.',
      accent: 'cyan'
    },
    {
      section: 'SQLAnimalService',
      title: 'El servicio adapta el esquema a las operaciones CRUD',
      lead: 'La capa SQL deja de persistir etiquetas y escribe la clave foránea.',
      layout: 'flow',
      steps: [
        'create recibe species_id validado.',
        'INSERT guarda name, species_id y age.',
        'update cambia la referencia del animal.',
        'find vuelve a leer la etiqueta para la respuesta.'
      ],
      flowNote: 'El formulario envía un ID; la consulta puede devolver el nombre humano.',
      takeaway: 'La escritura y la lectura tienen necesidades distintas.',
      accent: 'cyan'
    },
    {
      section: 'SQLAnimalService',
      title: 'INSERT y UPDATE reciben la clave',
      lead: 'El SQL parametrizado mantiene los valores separados de la sentencia.',
      layout: 'code',
      codeTitle: 'app/Services/SQLAnimalService.php',
      code: `DB::insert(
    'INSERT INTO animals (name, species_id, age) VALUES (?, ?, ?)',
    [$data['name'], $data['species_id'], $data['age']]
);

DB::update(
    'UPDATE animals SET name = ?, species_id = ?, age = ? WHERE id = ?',
    [$data['name'], $data['species_id'], (int) $data['age'], $id]
);`,
      rightTitle: 'LECTURA GUIADA',
      right: [
        'El nombre no se almacena como FK.',
        'El ID proviene de los datos validados.',
        'Los ? son parámetros, no interpolación.',
        'La misma clave se usa al actualizar.'
      ],
      takeaway: 'Persistimos la identidad de la especie, no su texto visible.'
    },
    {
      section: 'SQLAnimalService',
      title: 'JOIN: combinar claves relacionadas',
      lead: 'La unión recupera la etiqueta del catálogo usando la relación entre IDs.',
      layout: 'code',
      codeTitle: 'CONSULTA DE LISTADO',
      code: `SELECT animals.id,
       animals.name,
       species.name,
       animals.age
FROM animals
JOIN species
  ON animals.species_id = species.id;`,
      rightTitle: '¿QUÉ HACE EL JOIN?',
      right: [
        'Compara la FK de animals con la PK de species.',
        'Combina las columnas de filas relacionadas.',
        'INNER JOIN omite filas sin coincidencia.',
        'La FK debería impedir esos huérfanos.'
      ],
      takeaway: 'La relación almacenada por ID recupera la especie legible.',
      accent: 'cyan'
    },
    {
      section: 'SQLAnimalService',
      title: 'Los alias preservan el contrato de la vista',
      lead: 'La consulta puede presentar los mismos nombres que el arreglo anterior.',
      layout: 'wideCode',
      codeTitle: 'SELECT CON NOMBRES EXPLÍCITOS',
      codeSize: 11,
      codeColor: 'cyan',
      code: `SELECT animals.id AS id,
       animals.name AS name,
       species.name AS species,
       animals.age AS age
FROM animals
JOIN species ON animals.species_id = species.id;`,
      right: [
        'Antes, species era animals.species; ahora es species.name.'
      ],
      takeaway: 'Los alias desacoplan el esquema de los nombres que esperan consumidores.'
    },
    {
      section: 'SQLAnimalService',
      title: 'all() para mostrar; find() también prepara edición',
      lead: 'El listado necesita una etiqueta; el formulario requiere además el ID actual.',
      layout: 'compare',
      leftTitle: 'all()',
      left: [
        'id, name, species, age.',
        'species viene de species.name.',
        'La vista puede seguir leyendo $item[species].',
        'No necesita la FK para presentar la fila.'
      ],
      rightTitle: 'find($id)',
      right: [
        'Devuelve las mismas claves de lectura.',
        'Incluye species.id AS species_id.',
        'La edición selecciona la especie asociada.',
        'No confundir etiqueta con valor del select.'
      ],
      takeaway: 'Cada consulta devuelve exactamente los datos que requiere su consumidor.',
      accent: 'cyan'
    },
    {
      section: 'Controller y Blade',
      title: 'Controller prepara el catálogo para los formularios',
      lead: 'Las acciones create y edit cargan especies desde el servicio de catálogo.',
      layout: 'code',
      codeTitle: 'app/Http/Controllers/AnimalController.php',
      code: `public function create()
{
    $species = $this->speciesService->all();
    return view('animals.create', ['species' => $species]);
}

public function edit(string $id)
{
    $animal = $this->animalService->find($id);
    $species = $this->speciesService->all();
    return view('animals.edit', compact('animal', 'species'));
}`,
      rightTitle: 'RESPONSABILIDADES',
      right: [
        'El controlador obtiene la lista actual.',
        'La vista recibe datos; no consulta la DB.',
        'edit también necesita species_id del animal.',
        'La interfaz no define opciones codificadas.'
      ],
      takeaway: 'Controller compone los datos necesarios para renderizar Blade.'
    },
    {
      section: 'Controller y Blade',
      title: 'Cada opción separa el valor de la etiqueta',
      lead: 'El navegador muestra el nombre, pero envía el ID de la especie.',
      layout: 'code',
      codeTitle: 'animals/create.blade.php',
      code: `<label for="species_id">Especie</label>
<select name="species_id" id="species_id">
    <option value="">Selecciona una especie</option>
    @foreach ($species as $speciesOption)
        <option value="{{ $speciesOption['id'] }}">
            {{ $speciesOption['name'] }}
        </option>
    @endforeach
</select>`,
      rightTitle: 'CONTRATO DEL CONTROL',
      right: [
        'name coincide con la clave del request.',
        'value transporta la FK.',
        'El texto visible sigue siendo comprensible.',
        'El listado se actualiza desde el catálogo.'
      ],
      takeaway: 'El ID viaja; la persona elige por el nombre.',
      accent: 'cyan'
    },
    {
      section: 'Controller y Blade',
      title: 'Create: conservar la selección y mostrar el error correcto',
      lead: 'Tras un error, old() repone el ID enviado y la clave de error es species_id.',
      layout: 'code',
      codeTitle: 'PATRÓN CORREGIDO PARA create.blade.php',
      code: `@class([
    'border-rose-500' => $errors->has('species_id'),
    'border-slate-600' => !$errors->has('species_id'),
])

<option value="{{ $speciesOption['id'] }}"
    @selected(old('species_id') == $speciesOption['id'])>
    {{ $speciesOption['name'] }}
</option>

@error('species_id')
    <p>{{ $message }}</p>
@enderror`,
      rightTitle: 'BUGS EN EL CAMBIO REAL',
      right: [
        'Se compara old() contra el arreglo completo, no su id.',
        'El estilo y @error consultan species, no species_id.',
        'Así se pierde la selección y el feedback por campo.',
        'edit ya compara old() con el ID de cada opción.'
      ],
      takeaway: 'name, validación, old() y error bag deben usar la misma clave.'
    },
    {
      section: 'Controller y Blade',
      title: 'Edit: prioridad a old(), luego al valor persistido',
      lead: 'La edición permite corregir errores sin perder la selección recién enviada.',
      layout: 'code',
      codeTitle: 'animals/edit.blade.php',
      code: `<select name="species_id" id="species_id">
    @foreach ($species as $speciesItem)
        <option value="{{ $speciesItem['id'] }}"
            @selected(old(
                'species_id',
                $animal['species_id']
            ) == $speciesItem['id'])>
            {{ $speciesItem['name'] }}
        </option>
    @endforeach
</select>`,
      rightTitle: 'ORDEN DE RESOLUCIÓN',
      right: [
        '1. Intento más reciente del formulario.',
        '2. Si no existe old(), usar species_id guardado.',
        '3. Comparar IDs con IDs.',
        '4. Mostrar species.name como etiqueta.'
      ],
      takeaway: 'El dato inicial de edición es la clave foránea, no la etiqueta.',
      accent: 'cyan'
    },
    {
      section: 'Controller y Blade',
      title: 'El recorrido MVC en una sola vista',
      lead: 'Cada capa transforma el mismo concepto sin cambiar la responsabilidad de la siguiente.',
      layout: 'flow',
      steps: [
        'Controller obtiene catálogo y animal.',
        'Blade pinta ID y nombre.',
        'Persona elige y envía species_id.',
        'Request valida antes de store/update.'
      ],
      flowNote: 'Pregunta antes de ejecutar: ¿qué variable contiene la etiqueta y cuál contiene la clave?',
      takeaway: 'El live coding explicita datos de entrada y salida por capa.',
      accent: 'cyan'
    },
    {
      section: 'Validación de entrada',
      title: 'AnimalFormRequest valida la clave recibida',
      lead: 'La especie deja de validarse por nombre fijo y pasa a validarse por ID.',
      layout: 'compare',
      leftTitle: 'YA NO VALIDAMOS',
      left: [
        'species como string enviado por el usuario.',
        'Una lista fija con nombres permitidos.',
        'Opciones repetidas en código y base de datos.',
        'Cambios manuales cuando crece el catálogo.'
      ],
      rightTitle: 'VALIDAMOS species_id',
      right: [
        'El campo es obligatorio.',
        'Debe tener formato entero.',
        'Debe existir en species.id.',
        'La FK refuerza la integridad en DB.'
      ],
      takeaway: 'La validación refiere a una entidad existente, no a una etiqueta codificada.'
    },
    {
      section: 'Validación de entrada',
      title: 'La regla required|integer|exists',
      lead: 'exists consulta el catálogo y rechaza una clave que no tiene fila relacionada.',
      layout: 'code',
      codeTitle: 'app/Http/Requests/AnimalDataRequest.php',
      code: `public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'species_id' => 'required|integer|exists:species,id',
        'age' => 'required|integer|min:3|max:30',
    ];
}`,
      rightTitle: 'CADA REGLA APORTA',
      right: [
        'required: no aceptar campo vacío.',
        'integer: validar forma numérica entera.',
        'exists: la fila referida está en species.',
        'No codificamos valores concretos de especie.'
      ],
      takeaway: 'La lista dinámica puede cambiar sin reescribir las reglas.',
      accent: 'cyan'
    },
    {
      section: 'Validación de entrada',
      title: 'El select no es una frontera de confianza',
      lead: 'Una petición puede fabricarse fuera del formulario visible.',
      layout: 'quiz',
      prompt: '¿Qué debe ocurrir si el cliente envía species_id = 999 aunque no figure en el select?',
      options: [
        'El navegador debería impedir siempre ese envío.',
        'FormRequest rechaza la clave con exists.',
        'SQL guarda la etiqueta "999" en species.'
      ],
      takeaway: 'Validamos en servidor; la FK ofrece una segunda garantía.',
      accent: 'cyan'
    },
    {
      section: 'Validación de entrada',
      title: 'Validación y FK protegen en capas distintas',
      lead: 'La regla mejora el feedback HTTP; la base de datos protege integridad en cualquier escritura.',
      layout: 'compare',
      leftTitle: 'FORM REQUEST',
      left: [
        'Contexto de una petición web.',
        'Mensajes útiles por campo.',
        'exists:species,id comprueba la referencia.',
        'Evita llegar a la escritura con entrada inválida.'
      ],
      rightTitle: 'FOREIGN KEY',
      right: [
        'Regla persistente del esquema.',
        'Protege escrituras de otros caminos.',
        'Impide referencias a filas inexistentes.',
        'RESTRICT define el borrado relacionado.'
      ],
      takeaway: 'Defensa en profundidad: UX y consistencia no son sustitutos.',
      accent: 'cyan'
    },
    {
      section: 'Live coding guiado',
      title: 'Ritmo de la demostración: predecir, codificar, probar',
      lead: 'La presentación guía el recorrido; el editor y la terminal son el centro de la clase.',
      layout: 'flow',
      steps: [
        'Nombrar el objetivo del cambio.',
        'Predecir el efecto de la línea.',
        'Codificar el fragmento mínimo.',
        'Ejecutar y leer evidencia.'
      ],
      flowNote: 'Tras cada ejecución: ¿qué contrato cambió?, ¿cuál se preservó?, ¿qué dato falta comprobar?',
      takeaway: 'La explicación acompaña decisiones observables, no lectura de diapositivas.',
      accent: 'cyan'
    },
    {
      section: 'Live coding guiado',
      title: 'Verificación de migración: conteos y referencias',
      lead: 'La migración no se considera terminada sólo porque el comando finalice sin error.',
      layout: 'code',
      codeTitle: 'COMPROBACIONES SQL DE CONCEPTO',
      code: `SELECT COUNT(*) FROM animals;

SELECT COUNT(*)
FROM animals
WHERE species_id IS NULL;

SELECT animals.id, animals.species_id
FROM animals
LEFT JOIN species ON species.id = animals.species_id
WHERE species.id IS NULL;`,
      rightTitle: 'EVIDENCIA BUSCADA',
      right: [
        'Cantidad de animales antes y después coincide.',
        'Ninguna FK queda NULL al finalizar.',
        'El LEFT JOIN no encuentra huérfanos.',
        'Probar migrate y rollback en copia con SQLite.'
      ],
      takeaway: 'Medimos conservación e integridad, no sólo éxito del comando.',
      accent: 'cyan'
    },
    {
      section: 'Live coding guiado',
      title: 'Verificación funcional: alta y edición',
      lead: 'Seguir una especie conocida permite contrastar ID, etiqueta y valor persistido.',
      layout: 'compare',
      leftTitle: 'ALTA',
      left: [
        'Abrir create con el catálogo.',
        'Elegir una etiqueta visible.',
        'Comprobar que el payload envía su ID.',
        'Verificar nombre e especie en el listado.'
      ],
      rightTitle: 'EDICIÓN',
      right: [
        'Abrir animal con species_id conocido.',
        'Confirmar opción seleccionada.',
        'Enviar un valor inválido para probar old().',
        'Guardar otra especie y volver a leer.'
      ],
      takeaway: 'Una prueba integra controlador, servicio, SQL y Blade.'
    },
    {
      section: 'Live coding guiado',
      title: 'Laboratorio de errores reales',
      lead: 'Antes de cerrar, el grupo predice cada síntoma y localiza la capa responsable.',
      leftTitle: 'DEFECTOS A CORREGIR',
      left: [
        'create compara el ID antiguo con todo speciesOption.',
        'create consulta errores bajo species.',
        'AnimalDataRequest no comprueba exists.',
        'La migración borra el texto antes de mapearlo.'
      ],
      rightTitle: 'PREGUNTAS DE DEPURACIÓN',
      right: [
        '¿Qué key trae el request validado?',
        '¿Qué key busca el error bag?',
        '¿Qué ocurre con una FK inválida?',
        '¿Cómo demostrar que no se perdieron filas?'
      ],
      takeaway: 'El código real se revisa críticamente, no se asume correcto.',
      accent: 'cyan'
    },
    {
      section: 'Regla de dominio',
      title: 'Borrar especie: política restrictiva',
      lead: 'El dominio acordado impide borrar una especie que todavía clasifica animales.',
      layout: 'code',
      codeTitle: 'RELACIÓN EN EL ESQUEMA',
      code: `$table->foreignId('species_id')
    ->constrained('species')
    ->restrictOnDelete();`,
      rightTitle: 'COMPORTAMIENTO ELEGIDO',
      right: [
        'La DB rechaza el borrado si hay animales asociados.',
        'Primero hay que reasignarlos o eliminarlos deliberadamente.',
        'El código modificado usa onDelete cascade.',
        'Cascade borraría animales: no coincide con la política elegida.'
      ],
      takeaway: 'La estrategia referencial implementa una regla de negocio.',
      accent: 'cyan'
    },
    {
      section: 'Síntesis y evaluación',
      title: 'Checklist de logro observable',
      lead: 'La evaluación revisa evidencias producidas durante la codificación en vivo.',
      leftTitle: 'DATOS Y SQL',
      left: [
        'Backfill conserva las filas y detecta casos no mapeados.',
        'No quedan referencias nulas/huérfanas.',
        'JOIN recupera la etiqueta.',
        'Alias preserva las claves para vistas.'
      ],
      rightTitle: 'MVC Y VALIDACIÓN',
      right: [
        'Controller entrega el catálogo a create/edit.',
        'Select envía ID y muestra nombre.',
        'exists rechaza ID desconocido.',
        'Edición retiene old() y valor inicial.'
      ],
      takeaway: 'El éxito se demuestra de extremo a extremo.',
      accent: 'cyan'
    },
    {
      section: 'Síntesis y evaluación',
      title: 'Ticket de salida y transferencia',
      lead: 'Cada estudiante explica una decisión usando el flujo de datos del proyecto.',
      leftTitle: 'RESPONDE EN UNA FRASE',
      left: [
        '¿Por qué guardamos species_id?',
        '¿Qué problema resuelven los alias del JOIN?',
        '¿Por qué exists no enumera nombres?',
        '¿Qué significa RESTRICT en este dominio?'
      ],
      rightTitle: 'PRÓXIMO PASO',
      right: [
        'Automatizar pruebas de alta y edición.',
        'Probar migración y rollback con base de copia.',
        'Resolver explícitamente valores legados ambiguos.',
        'Revisar mensajes y estilos con species_id.'
      ],
      takeaway: 'Trazar el dato de principio a fin demuestra comprensión backend.',
      accent: 'cyan'
    }
  ];
}
