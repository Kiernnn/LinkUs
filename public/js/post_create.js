document
    .getElementById("file-input")
    .addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document
                    .getElementById("preview")
                    .setAttribute("src", e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            document.getElementById("preview").setAttribute("src", "#");
        }
    });
