function Validation() {
   
    var email = document.getElementById("emailid").value;
    var checkmark = document.getElementById("checkmark");
    var pattern = /\S+@\S+\.\S+/;
    var colombia =/\S+@\S+\.co$/;

    if (email == "") {
        alert("E-mail address is required");
        return false;
    }
    else if (!email.match(pattern)){
        alert("Please provide a valid e-mail address")
        return false;
    }
    else if(email.match(colombia)){
        alert("We are not accepting subscriptions from Colombia e-mails")
        return false;
    }
    else if (!(checkmark.checked)){
        alert("You must accept the terms and conditions")
        return false;
    }
    else if (checkmark.checked && email.match(pattern)){
        var v1 = document.getElementById("v1") 
        var v2 = document.getElementById("v2") 
        v1.style.display = 'none';
        v2.style.display = 'block'; 
        return true;
    } 
   
}