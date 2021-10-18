const form = document.getElementById('form')
const submit = document.getElementById('submitButton')
const name_user = document.getElementById('name')
const lastname = document.getElementById('lastname')
const gender = document.getElementById('gender')
const email = document.getElementById('email')
const password = document.getElementById('password')
const confirm_password = document.getElementById('confirm_password')
const terms = document.getElementById('terms')
const message = document.getElementById('message')

const formValid = {
    name: false,
    lastname: false,
    gender: false,
    email: false,
    password: false,
    confirm_password: false,
    terms: false
}

form.addEventListener('submit', (e)=>{
    e.preventDefault()
})

name_user.addEventListener('change', ()=>{
    if(name_user.value.trim().length > 0){
        formValid.name = true
    }
})

lastname.addEventListener('change', ()=>{
    if(lastname.value.trim().length > 0){
        formValid.lastname = true
    }
})

gender.addEventListener('change', (e)=>{
    formValid.gender = e.target.checked
    console.log(e)
})

email.addEventListener('change', ()=>{
    const validate_email = validateEmail(email.value)
    if(validate_email === true){
        formValid.email = true
    }
})

password.addEventListener('change', ()=>{
    const validate_pass = validatePasswordComplex(password.value)
    if(validate_pass === true){
        formValid.password = true
    }
})

confirm_password.addEventListener('keyup', ()=>{
    if (password.value === confirm_password.value){
        formValid.confirm_password = true
        message.classList.remove('message-show')
    }else{
        message.classList.add('message-show')
    }
})





