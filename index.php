<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form>
        <fieldset>
            <legend>Clone-Wetransfer</legend>
            <div class="mb-3">
                <label for="file_name" class="form-label">File</label>
                <input type="file" id="file_name" name="file_name" />

                <div class="mb-3">
                    <label for="recipient-email" class="form-label">Email destinataire</label>
                    <input type="email" id="recipient-email" name="recipient_email" />

                    <div class="mb-3">
                        <label for="disabledSelect" class="form-label">Email</label>
                        <input type="email" id="mail" name="user_email" />
                    </div>
                    <button type="submit" class="btn btn-primary" value="Send">Send</button>
        </fieldset>
    </form>
</body>

</html>