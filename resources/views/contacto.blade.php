<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="/contacto">
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="tel" name="telefono" id="telefono" required>
        </div>
        <button type="submit">Enviar</button>
    </form>

</body>

</html>