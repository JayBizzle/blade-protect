document.addEventListener("DOMContentLoaded", function() {
    var protections = document.querySelectorAll('.__blade_protect');
    if (protections.length > 0) {
        protections.forEach((protect) => {
            send(protect.value);
            setInterval(function() {
                send(protect.value)
            }, 20000);
        });
    }
});

function send(value) {
    fetch("/__blade-protect", {
        method: "POST", 
        body: JSON.stringify(value),
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector("[name=csrf-token]").content,
        },
    })
}