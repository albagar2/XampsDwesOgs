# Alquiler Juegos - Proyecto MVC PHP (lista para ejecutar)

## Contenido
Proyecto minimalista en PHP (sin framework) con patrón MVC. Incluye:
- Modelos: Client, Game, Rental
- Controladores: Auth, Game, Rental, Admin
- Vistas completas (home, login, detalle, mis alquileres, admin)
- Estilos modernos (archivo CSS)

## Instalación rápida
1. Copia el contenido del ZIP en tu servidor web (p.e. `htdocs/alquiler_juegos`).
2. Importa la base de datos `alquiler_juegos` usando el SQL que ya tienes (phpMyAdmin o `mysql`).
3. Ajusta `config/config.php` con tus credenciales de BD.
4. Accede a `http://localhost/alquiler_juegos/public/index.php`.

Usuarios por defecto del volcado SQL:
- Admin: DNI `12121212A` contraseña `admin` (md5 = 21232f...)
- Cliente: DNI `11111111A` contraseña `4a1816...` (usa md5 en el volcado)

**Nota**: El proyecto usa md5 en el ejemplo porque así está en tu volcado. En producción usa password_hash/password_verify.
