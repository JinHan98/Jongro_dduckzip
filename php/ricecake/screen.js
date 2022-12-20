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
  
  resizeApply();

  function Confirm(){
    // window.confirm("로그아웃을 하시겠습니까?");
    // $.ajax({
		// 	type: "get",
		// 	url: 'http://localhost:8080/logOut',
		// 	data: {},
		// 	dataType:'text',
		// 	success: function(res) {
		// 		location.reload();
		// 	}
		// });

    if(confirm('로그아웃을 하시겠습니까?')){
      return true;
    }
    else return false;
}

  