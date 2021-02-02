function myFunction() {
    var x = document.getElementById("old-password");
    
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function myFunction1() {
    var y = document.getElementById("new-password");
    
    if (y.type === "password") {
        y.type = "text";
    } else {
        y.type = "password";
    }
}

function myFunction2() {
    var z = document.getElementById("confirm-password");
    
    if (z.type === "password") {
        z.type = "text";
    } else {
        z.type = "password";
    }
}
