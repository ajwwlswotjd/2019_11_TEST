const log = console.log;

window.onload = function(){
	let app = new App();
}

class App {
	constructor(){

	}
}

function swal(type,title,text,footer){
	Swal.fire({
		type: type,
		title: title,
		text: text,
		footer: footer
	})
}

function go(){
	if($('#id').val()==""){
		swal("error","삐빅!","아이디 값이 비어있습니다.","");
		return false;
	}
	if($('#pwd').val()==""){
		swal("error","삐빅!","비밀번호 값이 비어있습니다.","");
		return false;
	}
	// 여기서부터 에이잭스 날려서 진행한다
	$.ajax({
		url: "/fx/login_fx.php",
		type: "POST",
		data: $("#form_login").serialize(),
	}).done(function(data){
		let first = data.split("")[0];
		if(first=="s"){
			let name = data.slice(1,data.length);
			Swal.fire({
				title: '로그인 성공',
				text: "어서오세요. "+name+"님",
				type: 'success',
				showCancelButton: false,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '확인'
			}).then((result) => {
				if (result.value) {
					location.href="/";
				}
			})
		}else if(data=="f"){
			swal("error","실패","아이디 혹은 비밀번호가 잘못되었거나, 없는 아이디 입니다.","");
		}
	});
	return false;
}