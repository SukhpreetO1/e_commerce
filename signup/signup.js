// First Name Validation
var first_name= document.getElementById("first_name");

var first_name_validation=function(){

   first_name_value=first_name.value.trim(); 
   valid_first_name=/^[A-Za-z]+$/;
   first_name_err=document.getElementById('first-name-err');

   if(first_name_value=="")
   {
    first_name_err.innerHTML="First Name is required";

   }else if(!valid_first_name.test(first_name_value)){
    first_name_err.innerHTML="First Name must be only string without white spaces";
   }else{
    first_name_err.innerHTML="";
     return true;
    
   }
}

first_name.oninput=function(){
   
   first_nameValidation();
}

  // Last Name Validation
  var last_name= document.getElementById("last_name");

  var last_nameValidation= function(){

   last_nameValue=last_name.value.trim(); 
   validlast_name=/^[A-Za-z]+$/;
   last_nameErr=document.getElementById('last-name-err');

   if(last_nameValue=="")
   {
    last_nameErr.innerHTML="Last Name is required";

   }else if(!validlast_name.test(last_nameValue)){
     last_nameErr.innerHTML="Last Name must be only string without white spaces";
   }else{
     last_nameErr.innerHTML="";
     return true;
   }
  }

last_name.oninput=function(){

   last_nameValidation();
}

 // email Address Validation
 var emailAddress= document.getElementById("emailAddress");;
 var emailAddressValidation= function(){

  emailAddressValue=emailAddress.value.trim(); 
   validemailAddress=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
   emailAddressErr=document.getElementById('email-err');

   if(emailAddressValue=="")
   {
    emailAddressErr.innerHTML="email Address is required";

   }else if(!validemailAddress.test(emailAddressValue)){
     emailAddressErr.innerHTML="email Addre must be in valid formate with @ symbol";
   }else{
     emailAddressErr.innerHTML="";
     return true;
   }

 }

emailAddress.oninput=function(){

   emailAddressValidation();
}

 // Mobile Number Validation
 var mobileNumber= document.getElementById("mobileNumber");

 var mobileNumberValidation = function(){

   mobileNumberValue=mobileNumber.value.trim(); 
   validMobileNumber=/^[0-9]*$/;
   mobileNumberErr=document.getElementById('mobile-number-err');

   if(mobileNumberValue=="")
   {
    mobileNumberErr.innerHTML="Mobile Number is required";

   }else if(!validMobileNumber.test(mobileNumberValue)){
     mobileNumberErr.innerHTML="Mobile Number must be a number";
   }else if(mobileNumberValue.length!=10){

      mobileNumberErr.innerHTML="Mobile Number must have 10 digits";
   }
   else{
     mobileNumberErr.innerHTML="";
     return true;
   }

 }
mobileNumber.oninput=function(){

   mobileNumberValidation();
}


// password Validation
var password= document.getElementById("password");;

var passwordValidation = function(){

  passwordValue=password.value.trim(); 
   validpassword=/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/
   
   passwordErr=document.getElementById('password-err');

   if(passwordValue=="")
   {
    passwordErr.innerHTML="password is required";
   }else if(!validpassword.test(passwordValue)){
     passwordErr.innerHTML="password must have at least one Uppercase, lowercase, digit, special characters & 8 characters";
   }
   else{
     passwordErr.innerHTML="";
     return true;
   }
}

password.oninput=function(){

   passwordValidation();

 confirmpasswordValidation();
   
}

// Confirm password Validation
var confirmpassword= document.getElementById("confirmpassword");;

var confirmpasswordValidation=function(){
   confirmpasswordValue=confirmpassword.value.trim(); 
   
   confirmpasswordErr=document.getElementById('confirm_password-err');
   if(confirmpasswordValue==""){
       confirmpasswordErr.innerHTML="Confirm password is required";
   }

  else if(confirmpasswordValue!=password.value){
     confirmpasswordErr.innerHTML="Confirm password does not match";
   }
   else{
     confirmpasswordErr.innerHTML="";
     return true;
   }
}

confirmpassword.oninput=function(){

 confirmpasswordValidation();
   
}

// validation on submit


document.getElementById("registrationForm").onsubmit=function(e){

  
  first_nameValidation();
  last_nameValidation();
  emailAddressValidation();
  mobileNumberValidation();
  passwordValidation();
  confirmpasswordValidation();

  if(first_nameValidation()==true && 
    last_nameValidation()==true && 
    emailAddressValidation() == true && 
    mobileNumberValidation()==true && 
    passwordValidation()==true && 
    confirmpasswordValidation()==true){
    return true;
  }else{
    return false;
  }
}
