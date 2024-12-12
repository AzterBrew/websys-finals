let color = "red";

let plink = document.getElementsByClassName("nav-link");

plink.onclick = colorChange();

function colorChange(){
    console.log("yes");

    plink.style.background = color; 
}
