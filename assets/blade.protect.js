document.addEventListener("DOMContentLoaded", function() {
    var protections = document.querySelectorAll('.__blade_protect');

    if (protections.length > 0) {
        protections.forEach((protect) => {
            var protect = protect;

            setInterval(function() {
                fetch("/__blade-protect", {
                    method: "POST", 
                    body: JSON.stringify(protect.value),
                    headers: {
                        'X-CSRF-TOKEN': document.head.querySelector("[name=csrf-token]").content,
                    },
                })
            }, 5000);

        });
    }
});