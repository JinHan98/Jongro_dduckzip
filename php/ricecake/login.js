async function login(phone, password) {


    const url = `http://localhost:8888/user.php/login`;

    var details = {
         'Phone_num' : phone,
         'Password' : password
    }

    var formBody = [];
    for (var property in details) {    
         var encodedKey = encodeURIComponent(property);
         var encodedValue = encodeURIComponent(details[property]);
         formBody.push(encodedKey + "=" + encodedValue);
    }
    formBody = formBody.join("&");

    const options = {
         method: 'POST', // *GET, POST, PUT, DELETE 등
         headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
         },
         body: formBody
    }
    console.log(options);

    let res = await fetch(url, options);
    let data = await res.json();

    if (res.ok) {
        if(data.result == "실패") {
            alert("로그인에 실패하였습니다.\n다시 시도해주세요.");
            location.href="./login.html";
        }
        else{
            alert("로그인이 완료되었습니다.");
            console.log(data);
            location.href="./main.html";
        }
    } else {
        throw Error(data);
    }   
}

function check(){
    const id = document.getElementById("userid").value
    const userpassword = document.getElementById("userpassword").value
    console.log(id);
    console.log(userpassword);

    if(id == null || id == "" || userpassword == null || userpassword == ""){
        alert("아이디, 비밀번호를 확인해주세요. ");
    }
    else login(id, userpassword)
}

function Confirm(){
    window.confirm("로그아웃을 하시겠습니까?");
}

function resizeApply() {
    var minWidth = 1500;
    var body = document.getElementsByTagName('body')[0];
    if (window.innerWidth < minWidth) { body.style.zoom = (window.innerWidth / minWidth); }
    else body.style.zoom = 1;
    }
    
    window.onload = function() {
    window.addEventListener('resize', function() {
         resizeApply();
    });
    }