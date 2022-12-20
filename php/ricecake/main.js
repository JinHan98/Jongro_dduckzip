

function slideShow() {
    var i;
    var x = document.getElementsByClassName("slide1");  //slide1에 대한 dom 참조
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";   //처음에 전부 display를 none으로 한다.
    }
    index++;
    if (index > x.length) {
        index = 1;  //인덱스가 초과되면 1로 변경
    }   
    x[index-1].style.display = "block";  //해당 인덱스는 block으로
    setTimeout(slideShow, 3000);   //함수를 4초마다 호출 
    
}

var index = 0;   //이미지에 접근하는 인덱스
    window.onload = function(){
        slideShow();
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

