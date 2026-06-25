# Práctica 2: Manejo de errores y transacciones en PDO

## Datos

**Asignatura:** Desarrollo Web Avanzado  
**Docente:** Dr. José Alfonso Aguilar Calderón  
**Alumno:** Josue Antonio Rodriguez Cebreros  
**Correo:** josuerodriguezv86@gmail.com  

## Descripción

Esta práctica demuestra el uso de manejo de errores y transacciones en PDO con PHP y MySQL.

El sistema registra un alumno en la tabla `alumnos` y también registra una acción en la tabla `logs_alumnos`.

Si todo sale bien, se ejecuta `commit()` y los datos se guardan.  
Si ocurre un error, se ejecuta `rollBack()` y no se guarda ningún dato.

## Ruta de ejecución

```text
http://localhost/desarrollo-web-avanzado-fimaz-uas/parcial-2-pdo/practica-2/
