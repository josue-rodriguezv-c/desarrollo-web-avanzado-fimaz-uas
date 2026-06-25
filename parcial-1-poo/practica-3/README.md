# Práctica 3: Sistema de Usuarios con Validaciones y Excepciones

## Datos de la práctica

**Asignatura:** Desarrollo Web Avanzado  
**Docente:** Dr. José Alfonso Aguilar Calderón  
**Unidad:** I – Programación Orientada a Objetos en PHP  
**Alumno:** Josue Antonio Rodriguez Cebreros  
**Correo:** josuerodriguezv86@gmail.com  

## Descripción del sistema

En esta práctica se desarrolló un sistema básico de usuarios utilizando programación orientada a objetos en PHP.

El sistema cuenta con una clase base llamada `Usuario`, la cual contiene los atributos `nombre` y `correo`. Además, se implementó una validación para verificar que el correo tenga un formato válido.

También se crearon dos clases derivadas: `Admin` y `Alumno`. Ambas heredan de la clase `Usuario`, reutilizando sus atributos y métodos.

## Explicación del flujo de clases

La clase `Usuario` funciona como clase principal o clase base. En ella se definen los datos generales que comparten todos los usuarios.

La clase `Admin` extiende la clase `Usuario` utilizando la palabra reservada `extends`. Esta clase reutiliza el nombre y correo del usuario, y agrega el método `getRol()`, el cual retorna el texto `Administrador`.

La clase `Alumno` también extiende la clase `Usuario`. Además de reutilizar nombre y correo, agrega un nuevo atributo llamado `matricula`. También incluye el método `getRol()`, el cual retorna el texto `Alumno`.

El archivo `index.php` se encarga de crear objetos de tipo `Admin` y `Alumno`, mostrar sus datos en pantalla y probar el manejo de errores mediante bloques `try/catch`.

## Evidencia del manejo de errores

Para validar el manejo de excepciones, se creó un usuario con un correo incorrecto:

```php
$alumnoInvalido = new Alumno(
    "Alumno Incorrecto",
    "correo-invalido",
    "20260002"
);
