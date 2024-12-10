<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        body {
            margin: 0;
        }

        .main {
            background: 
                radial-gradient(
                    circle, 
                    oklch(0.15 0.2 330 / 0), 
                    oklch(0.15 0.2 330 / 1)
                ),
                linear-gradient(
                    344deg in oklch,
                    oklch(0.3 0.37 310),
                    oklch(0.35 0.37 330),
                    oklch(0.3 0.37 310)
                );
            display: grid;
            height: 100svh;
            place-items: center;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }

        .gallery img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 10px;
            transition: all 0.4s ease-in-out;
            cursor: pointer;
        }

        .gallery img:hover {
            transform: scale(1.1);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
            padding-top: 60px;
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .navigate {
            color: white;
            font-size: 30px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            transition: transform 0.2s, color 0.2s;
        }

        .navigate:hover {
            transform: scale(1.2);
            color: #ffcc00;
        }

        .prev {
            left: 10px;
        }

        .next {
            right: 10px;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: green;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
        }

        .back-button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body class="main">
    <h3 style="text-align: center; color: white; font-size: 30px;">Gallery </h3>
    <div class="gallery" id="gallery"></div>
    <div style="position: absolute; top: 10px; left: 10px;">
        <a href="dashboard.php" class="back-button">&larr; Back</a>
    </div>

    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <span class="navigate prev" onclick="changePhoto(-1)">&lt;</span>
        <span class="navigate next" onclick="changePhoto(1)">&gt;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <script>
        let currentIndex = 0;
        const images = [];

        // Fetch images from the server via JSON
        fetch('fetch_images.php')
            .then(response => response.json())
            .then(data => {
                const gallery = document.getElementById('gallery');
                data.forEach((image, index) => {
                    const imgElement = document.createElement('img');
                    imgElement.src = image;
                    imgElement.onclick = () => openModal(index);
                    gallery.appendChild(imgElement);
                    images.push(image);
                });
            })
            .catch(error => console.error('Error fetching images:', error));

        function openModal(index) {
            currentIndex = index;
            const modal = document.getElementById('myModal');
            const modalImage = document.getElementById('modalImage');
            modal.style.display = "block";
            modalImage.src = images[currentIndex];
        }

        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }

        function changePhoto(direction) {
            currentIndex = (currentIndex + direction + images.length) % images.length;
            document.getElementById('modalImage').src = images[currentIndex];
        }
    </script>
</body>
</html>

