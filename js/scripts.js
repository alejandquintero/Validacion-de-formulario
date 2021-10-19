const form = document.getElementById('form')
const submit = document.getElementById('submitButton')
const name_user = document.getElementById('name')
const lastname = document.getElementById('lastname')
const gender = document.getElementById('gender')
const email = document.getElementById('email')
const password = document.getElementById('password')
const confirm_password = document.getElementById('confirm_password')
const terms = document.getElementById('terms')
const message_pass_error = document.getElementById('message_pass_error')
const message_pass_contain = document.getElementById('message_pass_contain')

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
    const 
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
})

email.addEventListener('change', ()=>{
    const validate_email = validateEmail(email.value)
    if(validate_email === true){
        formValid.email = true
    }
})

password.addEventListener('keyup', ()=>{
    const validate_pass = validatePasswordComplex(password.value)
    message_pass_contain.classList.add('data__message--pass')
    if(validate_pass === true){
        formValid.password = true
        message_pass_contain.classList.remove('data__message--pass')
    }
})

confirm_password.addEventListener('keyup', ()=>{
    if (password.value === confirm_password.value){
        formValid.confirm_password = true
        message_pass_error.classList.remove('data__message--error')
    }else{
        message_pass_error.classList.add('data__message--error')
    }
})

terms.addEventListener('change', ()=>{
    if(terms.checked === true){
        formValid.terms = true
    }
})




