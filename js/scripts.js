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
const message_sign_error = document.getElementById('message_sign_error')


const formValid = {
    name: false,
    lastname: false,
    gender: false,
    email: false,
    password: false,
    confirm_password: false,
    terms: false
}

let formData = {
    name: null,
    lastname: null,
    gender: null,
    email: null,
    password: null,
}

form.addEventListener('submit', (e)=>{
    e.preventDefault()
})

name_user.addEventListener('change', ()=>{
    if(name_user.value.trim().length > 0){
        formValid.name = true
        formData.name  = name_user.value
    }

})

lastname.addEventListener('change', ()=>{
    if(lastname.value.trim().length > 0){
        formValid.lastname = true
        formData.lastname = lastname.value
    }
})

gender.addEventListener('change', (e)=>{
    formValid.gender = e.target.checked
    formData.gender = e.target.value
})

email.addEventListener('change', ()=>{
    const validate_email = validateEmail(email.value)
    if(validate_email === true){
        formValid.email = true
        formData.email = email.value
    }
})

password.addEventListener('keyup', ()=>{
    const validate_pass = validatePasswordComplex(password.value)
    message_pass_contain.classList.add('data__message--pass')
    if(validate_pass === true){
        formValid.password = true
        formData.password = password.value
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
    formValid.terms = terms.checked
})

const sendForm = () =>{
    if (Object.values(formValid).includes(false)){
        return 0
    }else{
        return 1
    }
}

const errorSignIn = () =>{
    message_sign_error.classList.add('data__message--error')
}

submit.addEventListener('click', ()=>{
    axios({
        method:'POST',
        url:'../php/index.php',
        data: {
            name_user: formData.name,
            lastname: formData.lastname,
            gender: formData.gender,
            email: formData.email,
            password: formData.password,
        }
    })
        .then(res=>console.log(res))
        .catch(err => console.log(err))
    
})





