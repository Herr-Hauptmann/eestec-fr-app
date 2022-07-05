let notifikacija  = document.getElementById("zatvori");
if (notifikacija!=null){
    notifikacija.addEventListener('click', ()=>
    { 
        document.getElementById("notifikacija").innerHTML="";
    });
}

let uspjeh = document.getElementById("zatvoriUspjeh");
if (uspjeh != null){
    uspjeh.addEventListener('click', ()=>{
        document.getElementById("uspjeh").innerHTML="";
    });
}
    