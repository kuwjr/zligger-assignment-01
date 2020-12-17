function formValidations1(){

    fname = document.getElementById('fname');
    lname = document.getElementById('lname');
    mobile = document.getElementById('mobile');
    telephone = document.getElementById('telephone');
    homeAddress = document.getElementById('homeAddress');
    officeAddress = document.getElementById('officeAddress');
    email = document.getElementById('email');
    description = document.getElementById('description');
    code = document.getElementById('code');
    age = document.getElementById('age');
    nic = document.getElementById('nic');

    //check for empty values
    if(fname.value == ''){
        window.alert("Please fill FIRST NAME")
        return false;
    }

    if(lname.value == ''){
        window.alert("Please fill LAST NAME")
        return false;
    }

    if(mobile.value == ''){
        window.alert("Please fill MOBILE NUMBER")
        return false;
    }else{
        //validate mobile number
        validateMobile(mobile.value);
    }

    if(homeAddress.value == ''){
        window.alert("Please fill HOME ADDRESS")
        return false;
    }

    if(email.value == ''){
        window.alert("Please fill EMAIL")
        return false;
    }

    if(code.value == ''){
        window.alert("Please fill CODE")
        return false;
    }

    if(nic.value != ''){
        //validate nic
        validateNic(nic.value);
    }
}

function validateMobile(inputtxt){
  let phoneno = /^\d{10}$/;
  if((inputtxt.match(phoneno))){
  }else{
    window.alert("Please insert a VALID MOBILE NUMBER");
    return false;
  }
}

function validateNic(nic){
  let regex = /^([0-9]{9}[x|X|v|V]|[0-9]{12})$/;
  if((nic.match(regex))){
  }else{
    window.alert("Please insert a VALID NIC NUMBER");
    return false;
  }   
}

function formValidations2(){

    fname = document.getElementById('fname');
    email = document.getElementById('email');
    password = document.getElementById('password');
    confirmPassword = document.getElementById('confirm-password');

    //check for empty values
    if(fname.value != ''){
        if(email.value != ''){
            if(password.value != ''){
                if(password.value == confirmPassword.value){
                    return true;
                }else{
                    window.alert("Passwords are not same!")
                    return false;
                }
            }else{
                window.alert("Please fill Password!")
                return false;
            }
        }else{
            window.alert("Please fill Last Name!")
            return false;
        }
    }else{
        window.alert("Please fill First Name!")
        return false;
    }
}

function loginValidations(){
    email = document.getElementById('email');
    pword = document.getElementById('password');

    if(email.value != ''){
        if(pword.value != ''){
            return true;
        }else{
            window.alert("Wrong Password")
            return false;
        }
    }else{
        window.alert("Wrong Email");
        return false;
    }
}
   
// Function to create the cookie 
function createCookie(name, value, days) { 
    var expires; 
      
    if (days) { 
        var date = new Date(); 
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); 
        expires = "; expires=" + date.toGMTString(); 
    } 
    else { 
        expires = ""; 
    } 
      
    document.cookie = escape(name) + "=" +  
        escape(value) + expires + "; path=/"; 
}