topbar.config({
    barThickness: 6,
    barColors: {
        0: "rgba(100, 115, 244)",
        ".25": "rgba(100, 115, 244)",
        ".50": "rgba(100, 115, 244)",
        ".75": "rgba(100, 115, 244)",
        "1.0": "rgba(100, 115, 244)",
    },
});
topbar.show();
document.addEventListener("DOMContentLoaded", function () {
    topbar.hide();

    var formSelectList = [].slice.call(
        document.querySelectorAll(".form-select")
    );
    formSelectList.map(function (formSelectElement) {
        formSelectElement.addEventListener("change", function (event) {
            this.classList.remove("is-invalid");
        });
    });
    var forms = document.getElementsByTagName("form");
    for (const form of forms) {
        form.addEventListener("submit", function (event) {
            var formBtn = this.querySelector('button[type="submit"]');
            formBtn.disabled = true;
            topbar.show();
        });
    }
    var formControlList = [].slice.call(
        document.querySelectorAll(".form-control")
    );
    formControlList.map(function (formControlElement) {
        formControlElement.addEventListener("input", function (event) {
            this.classList.remove("is-invalid");
        });
    });

    function previewImage(input, image) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (event) {
                image.classList.remove("d-none");
                image.src = event.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.onkeydown = function (event) {
        event = event || window.event;
        if (event.key === "Enter") {
            var modalList = [].slice.call(document.querySelectorAll(".modal"));
            modalList.map(function (modalElement) {
                var modalInstance = Bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
            });
        }
    };

    var menuToggle = document.querySelector("#menu-toggle");
    if (menuToggle) {
        menuToggle.addEventListener("click", function (event) {
            event.preventDefault();
            console.log("clicked");
            document.querySelector("#wrapper").classList.toggle("toggled");
        });
    }

    window.previewImage = previewImage;
});
