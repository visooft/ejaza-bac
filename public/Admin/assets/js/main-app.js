const showAlert = (msg) => {
    let alertBox = document.querySelector('.alert-box');
    let alertMsg = document.querySelector('.alert-msg');
    let alertImage = document.querySelector('.alert-img')
    alertMsg.innerHTML = msg;
    if (msg== 'your account created ') {
        alertMsg.style.color= "green"
        alertImage.style.display="none"
        alertBox.style.height="80px"
        setTimeout(() => {
            location.href='./login.html'  ;

        }, 3000);

    }
    alertBox.classList.add('show');
    setTimeout(() => {
        alertBox.classList.remove('show');
    }, 3000);



}


const name = document.querySelector('input[type=text]');
const email = document.querySelector('input[type=email]');


const number = document.querySelector('input[type=tel]');

document.querySelector('button[type="submit"]').addEventListener('click' ,
() => {

    if(number){

        if(name.value.length < 4){
            showAlert('الاسم يجب ان  يكون علي الاقل 5 حروف');
         }

        else if(number.value.length < 8){
            showAlert('رقم الموبايل يجب ان يكون 8 ارقام');

         }
    }

    else{
        if(name.value.length < 4){
            showAlert('الاسم يجب ان  يكون علي الاقل 5 حروف');
         }

    }


})
allTextarea = document.querySelectorAll( 'textarea' )
    allTextarea.forEach((element ,i )=> {

        ClassicEditor
        .create(element  , {

        language: {
            ui: 'ar',
            content: 'ar'
        }
    }  )
        .catch( error => {
                    console.error( error );
                } );


    });

    var closeBtn = document.querySelectorAll('.btn-secondary');
    var closeBtnArrow = document.querySelectorAll('.btn-close');


    closeBtn.forEach((element)=>{

        element.addEventListener('click' , load = ()=>{

            location.reload(true)
        } )


    })
    closeBtnArrow.forEach((element)=>{

        element.addEventListener('click' , load = ()=>{

            location.reload(true)
        } )


    })


