# Práctica 2: Herencia y Reutilización de Código en PHP

## Datos de la práctica

**Asignatura:** Desarrollo Web Avanzado  
**Docente:** Dr. José Alfonso Aguilar Calderón  
**Unidad:** I – Programación Orientada a Objetos en PHP  
**Alumno:** Josue Antonio Rodriguez Cebreros  
**Correo:** josuerodriguezv86@gmail.com  

## Objetivo

Implementar herencia mediante la extensión de clases, reutilizando atributos y métodos de una clase base.

## Explicación de la herencia aplicada

En esta práctica se aplicó el concepto de herencia en PHP mediante una clase base llamada `Usuario` y una clase hija llamada `Admin`.

La clase `Usuario` contiene los atributos principales de un usuario, como el nombre y el correo. También contiene métodos para obtener y modificar esos datos.

La clase `Admin` extiende la clase `Usuario` utilizando la palabra reservada `extends`. Esto permite que `Admin` reutilice los atributos y métodos de `Usuario`, sin necesidad de volver a escribir el mismo código.

Además, la clase `Admin` agrega un método propio llamado `getRol()`, el cual retorna el valor `"Administrador"`.

## Diferencias entre Usuario y Admin

La clase `Usuario` representa a un usuario general del sistema. Contiene el nombre, correo y métodos para consultar o modificar esa información.

La clase `Admin` representa a un usuario con rol de administrador. Esta clase hereda todo lo que tiene `Usuario`, pero además incluye el método `getRol()` para indicar que su rol es `"Administrador"`.

## Evidencia de ejecución

Al ejecutar el archivo `index.php` en el navegador mediante XAMPP, se muestra la siguiente información:

- Nombre: Josue Antonio Rodriguez Cebreros
- Correo: josuerodriguezv86@gmail.com
- Rol: Administrador

Esto demuestra que la clase `Admin` reutiliza correctamente los métodos heredados de la clase `Usuario` y también utiliza su propio método `getRol()`.

## Archivos utilizados

- `Usuario.php`
- `Admin.php`
- `index.php`
- `README.md`

## Conclusión

En esta práctica se comprendió cómo funciona la herencia en PHP. La clase `Admin` pudo reutilizar el código de la clase `Usuario`, evitando duplicar atributos y métodos. Esto permite crear programas más organizados, reutilizables y fáciles de mantener.
