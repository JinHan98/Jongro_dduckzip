
function check(){
     const id = document.getElementById("ID").value;
 
     if(id == null || id == ""){
         alert("아이디를 확인해주세요. ");
     }
     else fpass(id)
 }

 async function fpass(phone) {


     const url = `http://localhost:8888/user.php/password`;
 
     var details = {
          'Phone_num' : phone
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
             alert("비밀번호 찾기에 실패하였습니다.\n잠시 후 다시 시도해주세요.");
             location.href="./fpass.html";
         }
         else{
             alert("회원님의 비밀번호는 "+data.result + "입니다.");
             location.href="./main.html";
         }
     } else {
          alert("비밀번호 찾기에 실패하였습니다.\n잠시 후 다시 시도해주세요.");
          throw Error(data);
     }   
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
   
       

       