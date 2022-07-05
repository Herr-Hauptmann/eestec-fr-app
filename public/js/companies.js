let addButton = document.getElementById("addCompany");
if (addButton != null)
{
    addButton.addEventListener("click", addCompanyRow);
}
let counter = 1;
function addCompanyRow()
{
    let contacts = document.getElementById("contacts");
    if (contacts!=null)
    {
        let contactInput = document.createElement("div");
        contactInput.classList.add("row");
        contactInput.classList.add("pb-2");
        
        let title = document.createElement("p");
        title.innerHTML =`Contact no.${counter}`;
        title.classList.add('title');
        
        let name = document.createElement("div");
        name.classList.add("col-4");
        let nameInput = document.createElement("input");
        nameInput.type="text";
        nameInput.name=`contactName-${counter}`;
        nameInput.classList.add("form-control");
        nameInput.classList.add("name");
        nameInput.placeholder="Contact name";
        name.appendChild(nameInput);
        
        let email = document.createElement("div");
        email.classList.add("col-4");
        let emailInput = document.createElement("input");
        emailInput.type="text";
        emailInput.name=`contactEmail-${counter}`;
        emailInput.classList.add("form-control");
        emailInput.classList.add("email");
        emailInput.placeholder="Email address";
        email.appendChild(emailInput);
        
        let number = document.createElement("div");
        number.classList.add("col-3");
        let numberInput = document.createElement("input");
        numberInput.type="text";
        numberInput.name=`contactPhoneNumber-${counter}`;
        numberInput.classList.add("form-control");
        numberInput.classList.add("phone");
        numberInput.placeholder="Telephone number";
        number.appendChild(numberInput);

        let xDiv = document.createElement("div");
        xDiv.classList.add("col-1");
        xDiv.classList.add("my-auto");
        let xButton = document.createElement("button");
        xButton.type="button";
        xButton.classList.add("ml-auto");
        xButton.classList.add("close");
        let xSpan = document.createElement("span");
        xSpan.ariaHidden="true";
        xSpan.innerHTML="&times;";
        xButton.appendChild(xSpan);
        xDiv.appendChild(xButton);

        xDiv.addEventListener('click', ()=>{
            izbrisiKontakt(xDiv);
        });

        contactInput.appendChild(title);
        contactInput.appendChild(name);
        contactInput.appendChild(email);
        contactInput.appendChild(number);
        contactInput.appendChild(xDiv);
        contacts.appendChild(contactInput);
        counter++;

    }
}

function izbrisiKontakt(node){
    node.parentNode.parentNode.removeChild(node.parentNode);
    counter--;
    //Buduci da ne znamo koji smo node po redu izbrisali, buduci da se moze izbrisati neki u sredni sto nam kvari koncept
    //Ponovno numeriramo id-eve ovih input polja
    restartujIdeve();
}

function restartujIdeve(){
    let titles = document.getElementsByClassName('title');
    let names = document.getElementsByClassName('name');
    let emails = document.getElementsByClassName('email');
    let phones = document.getElementsByClassName('phone');

    for(let i = 0; i < titles.length; i++){
        titles[i].innerHTML = `Contact no.${i+1}`;
        names[i].name = `contactName-${i+1}`;
        emails[i].name=`contactEmail-${i+1}`;
        phones[i].name=`contactPhoneNumber-${i+1}`;
    }
}