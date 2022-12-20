function check(form){
    if(form.userid.value=="pengsoo"){
        if(form.userpassword.value=="1234"){
            window.open('main.html')
        }
    else alert("비밀번호를 다시 확인해주세요. ");
}
else alert("아이디를 다시 확인해주세요. ");
}