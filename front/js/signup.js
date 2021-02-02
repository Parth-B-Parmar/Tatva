function myFunction() {
    var x = document.getElementById("password");
    
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function myFunction1() {
    var y = document.getElementById("confirm-password");
    
    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }
}