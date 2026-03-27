<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ICT TV Display</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background-color: black;
            height: 100%;
            overflow: hidden;
        }
        img {
            display: block;
            margin: auto;
            max-width: 100vw;
            max-height: 100vh;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <img id="mainImage" src="closed.jpg" alt="Loading..." />
    <script>
        const img = document.getElementById("mainImage");

        async function updateImage() {
            try {
                const response = await fetch("api.php");
                const name = (await response.text()).trim();
                const imageName = name ? `${name}.jpg` : "closed.jpg";

                const tempImg = new Image();
                tempImg.src = imageName;
                tempImg.onload = () => {
                    img.src = imageName;
                };
            } catch (e) {
                console.error("API fetch failed, showing closed.jpg");
                img.src = "closed.jpg";
            }
        }

        updateImage();
        setInterval(updateImage, 30000); // every ~30 seconds
    </script>
</body>
</html>
