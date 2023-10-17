function previewImage() {
        let reader = new FileReader();

        reader.readAsDataURL(document.getElementById("dp").files[0]);
        reader.onload = (evt)=> {
            document.getElementById("preview").src = evt.target.result;
        }
    };

