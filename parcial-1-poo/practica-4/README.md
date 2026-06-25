# Práctica 4: Integración POO + Herencia + Validaciones + Excepciones

## Datos de la práctica

**Asignatura:** Desarrollo Web Avanzado  
**Docente:** Dr. José Alfonso Aguilar Calderón  
**Unidad:** I – Programación Orientada a Objetos en PHP  
**Alumno:** Josue Antonio Rodriguez Cebreros  
**Correo:** josuerodriguezv86@gmail.com  

## Objetivo de la práctica

Construir un mini-sistema orientado a objetos en PHP que simula el examen parcial, integrando encapsulamiento, herencia, polimorfismo básico, validación de datos, manejo de excepciones y salida en HTML mediante una tabla.

## Requisitos

- PHP 8 o superior
- XAMPP
- Servidor Apache activo
- Git
- GitHub o GitLab

## Descripción del sistema

El sistema está formado por una clase base llamada `Usuario` y tres clases hijas: `Admin`, `Alumno` e `Invitado`.

La clase `Usuario` contiene los atributos principales `nombre` y `correo`. En el constructor se valida que el correo tenga un formato correcto usando `filter_var` con `FILTER_VALIDATE_EMAIL`. Si el correo no es válido, se lanza una excepción.

Las clases hijas reutilizan los atributos y métodos de la clase `Usuario` mediante herencia. Cada clase implementa el método `getRol()`, lo que permite aplicar polimorfismo básico.

## Flujo de clases

La clase `Admin` extiende de `Usuario` y retorna el rol `Administrador`.

La clase `Alumno` extiende de `Usuario`, agrega el atributo `matricula` y retorna el rol `Alumno`.

La clase `Invitado` extiende de `Usuario`, agrega el atributo `empresa` y retorna el rol `Invitado`.

En `index.php` se crean objetos válidos de tipo `Admin`, `Alumno` e `Invitado`. También se crea un usuario con correo inválido para comprobar el manejo de excepciones.

## Ruta de ejecución en navegador

```text
http://localhost/desarrollo-web-avanzado-fimaz-uas/parcial-1-poo/practica-4/index.php
