const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})

document.getElementById('signInButton').addEventListener('click', function() {
    // limpar campos ao alternar para o login
    document.getElementById('email-signin').value = '';
    document.getElementById('password-signin').value = '';

    document.getElementById('signup').style.display = 'none';
    document.getElementById('signIn').style.display = 'block';
});

document.getElementById('signUpButton').addEventListener('click', function() {
    // limpar campos ao alternar para o cadastro
    document.getElementById('fName').value = '';
    document.getElementById('lName').value = '';
    document.getElementById('email-signup').value = '';
    document.getElementById('password-signup').value = '';

    document.getElementById('signup').style.display = 'block';
    document.getElementById('signIn').style.display = 'none';
});
