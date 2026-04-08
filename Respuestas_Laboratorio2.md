# Laboratorio 2 – Segundo Cómputo
David Alfonso Alvarenga Bonilla SMSS016424

**Análisis y Respuestas:**

### 1. ¿De qué forma manejaste el login de usuarios? Explica con tus palabras porque en tu página funciona de esa forma.
Para este proyecto decidí implementar un sistema de acceso simplificado y "sin contraseñas" que requiera únicamente el **nombre de usuario**. 
El sistema funciona enviando el nombre ingresado en el formulario visual mediante el método `POST` por seguridad al archivo backend, donde utilizo una consulta preparada de SQL (Prepared Statements) para buscar el nombre en la base de datos de manera segura y evitar ataques de inyección SQL. 
Funciona de esta forma porque para este sistema de registro de datos interno no necesitaba la complejidad de un nivel alto de encriptamiento, optando por una validación ágil que le da prioridad a la rapidez del registro de la información. Una vez comprobado que el usuario registrado existe, se inicia una sesión usando `session_start()` y se guarda esa validación, lo cual permite recordar en el servidor que el usuario tiene acceso al panel de registro (`dashboard.php`) sin pedirle validación en cada clic.

### 2. ¿Por qué es necesario para las aplicaciones web utilizar bases de datos en lugar de variables?
Es necesario porque las variables tienen un ciclo de vida muy corto y local; solo existen en la memoria RAM del servidor mientras se procesa la petición de la página (unos pocos milisegundos o segundos). Una vez la página termina de cargar, las variables se destruyen. Por el contrario, una base de datos almacena la información de manera persistente en un disco en el servidor. Esto permite que los registros (como los usuarios, productos, logs) sobreviven a reinicios del servidor, recargas de página y permiten compartirse entre cientos o miles de usuarios concurrentes de manera organizada y eficiente.

### 3. ¿En qué casos sería mejor utilizar bases de datos para su solución y en cuáles utilizar otro tipo de datos temporales como cookies o sesiones?
- **Base de Datos:** Se debe utilizar cuando la información debe persistir en el tiempo, ser compartida entre diferentes usuarios, o requiere ser consultada y estructurada masivamente; ejemplos: perfiles de usuario, inventario de productos, historial de compras, publicaciones.
- **Sesiones:** Se utilizan para guardar datos confidenciales o de estado temporal que pertenecen a un solo usuario mientras navega en el sitio, pero que se pueden perder al cerrar el navegador; ejemplos: estado de "logueado" (auth token/ID), carrito de compras temporal.
- **Cookies:** Se utilizan para guardar información de pequeñas preferencias del lado del cliente (navegador del usuario) que no son críticas por seguridad; ejemplos: preferencias de idioma, temas oscuros/claros, recordar un usuario durante semanas (botón de "recordarme").

### 4. Describa brevemente sus tablas y los tipos de datos utilizados en cada campo; justifique la elección del tipo de dato para cada uno.

Para esta aplicación se crearon dos tablas en la base de datos `lab2_computo2`:

**1. Tabla `users` (Para controlar el acceso):**
- `id` (INT): Tipo entero, clave primaria, auto-incremental. Se usa para identificar de manera única cada usuario sin consumir mucho espacio en disco.
- `username` (VARCHAR): Cadena de texto de longitud variable, ajustado a 50 caracteres para ser eficiente y lo suficientemente largo para el nombre de usuario.
- `password` (VARCHAR): Cadena de texto. En la versión actual se ha prescindido de este campo visualmente, pero se mantiene en la estructura para compatibilidad y escalabilidad a futuro si se desea implementar hashes.

**2. Tabla `products` (Para ingresar la información solicitada en el lab - El "registro de algo"):**
- `id` (INT): Clave primaria auto-incremental.
- `name` (VARCHAR):  Almacena el nombre del producto o item a registrar. VARCHAR(100) es ideal para no exceder consumo de espacio innecesario sin quedar cortos.
- `description` (TEXT): Para poder guardar un texto de múltiples párrafos en caso el ítem requiera mucha especificación.
- `quantity` (INT): El registro siempre se maneja en objetos discretos sin fracciones, por ende un entero es ideal.
- `price` (DECIMAL(10,2)): Decimal; esto es vital para evitar problemas de precisión en las conversiones de costos/datos numéricos con fracciones. El parámetro 10,2 garantiza números muy grandes pero fijos a 2 decimales para evitar el redondeo de los tipos FLOAT.
- `created_at` (TIMESTAMP): Utilizado para registrar el momento exacto en tiempo real en que se creó el registro para llevar un mejor orden lógico.
