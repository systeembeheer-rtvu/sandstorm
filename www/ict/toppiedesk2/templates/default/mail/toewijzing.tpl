<html>
    <head>
    </head>
    <body>
        Beste ICT'er,<br />
        <br />
        Er is een call op je naam gezet door {$output.invoerder}.<br />
        <br />
        <table>
            <tr>
                <td>Invoerder:</td>
                <td>{$output.behandelaar}</td>
            </tr>
            <tr>
                <td>Aanmelder:</td>
                <td>{$output.aanmelder}
            </tr>
            <tr>
                <td>Telefoonnummer</td>
                <td>{$output.telefoonnummer}</td>
            </tr>
            <tr>
                <td>Categorie</td>
                <td>{$output.categorie}</td>
            </tr>
            <tr style="vertical-align:top">
                <td>Melding</td>
                <td>{$output.melding}</td>
            </tr>
        </table>
        <br />
        <a href="http://intranet/ict/toppiedesk2/toppiedesk.php?id=callnieuw&searchoid={$output.oid}">Hier de link naar de call</a><br />
        <br />
        Met vriendelijke groet,<br />
        Afdeling ICT<br />
        RTV Utrecht
    </body>
</html>