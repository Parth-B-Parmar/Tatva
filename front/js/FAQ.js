var acc = document.getElementsByClassName("accordion");
var i;

for(i=0; i < acc.length; i++){
    acc[i].addEventListener("click", function(){
        this.classList.toggle("active");
    });
}

function change() {
    if(document.getElementsByClassName("plus").src == "../images/FAQ/add.png"){
        document.getElementsByClassName("plus").src = "../images/FAQ/add.png";
    } else {
        document.getElementsByClassName("plus").src = "../images/FAQ/minus.png";
    }
}