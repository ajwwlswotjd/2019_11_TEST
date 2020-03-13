const log = console.log;

function swal(type,title,text,footer){
	Swal.fire({
		type: type,
		title: title,
		text: text,
		footer: footer
	})
}

function chkForm(e){
	if($('#name').val()==""){
		swal("error","삐빅!","이름 칸이 비어있습니다.","");
		return false;
	}
	if($('#email').val()==""){
		swal("error","삐빅!","이메일 칸이 비어있습니다.","");
		return false;
	}
	//이제 아작스 날리자~
	$.ajax({
		url: "/fx/find_id_fx.php",
		type: "POST",
		data: $("#form").serialize(),
	})
	.done(function(data){
		let first = data.split("")[0];
		if(first=="s"){
			let id = data.slice(1,data.length);
			id = id.slice(0,data.length-3)+"**";
			swal("success","아이디를 찾았습니다!","아이디 : "+id,`<a style="color : #2196f3;" href="/login.php">아이디를 찾으셨나요? 로그인하기</a>`);
		}else {
			swal("error","실패","해당하는 이름, 혹은 이메일이 존재하지 않습니다.","");
		}
	});
	return false;
}

function chkForm2(e){
	if($('#name').val()==""){
		swal("error","삐빅!","이름 칸이 비어있습니다.","");
		return false;
	}
	if($('#id').val()==""){
		swal("error","삐빅!","아이디 칸이 비어있습니다.","");
		return false;
	}
	if($('#email').val()==""){
		swal("error","삐빅!","이메일 칸이 비어있습니다.","");
		return false;
	}
	// 여기서부터 아작스를 날려본다~

	$.ajax({
		url: "/fx/find_pwd_fx.php",
		type: "POST",
		data: $(".form2").serialize(),
	})
	.done(function(data){
		if(data=="s"){

			async function asdf(){
				const { value: password } = await Swal.fire({
					title: '비밀번호 변경',
					input: 'password',
					inputPlaceholder: '8자 이상,20자이하 영문/숫자/특수문자를 모두 조합',
					inputAttributes: {
						maxlength: 20,
						autocapitalize: 'off',
						autocorrect: 'off'
					}
				})
				if(password){
					let pat = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{8,20}$/;
					let able = pat.test(password);
					if(able){
						
						$("#pwd_hide").val(password);
						$('#id_hide').val($('#id').val());

						$.ajax({
							url: "/fx/change_pwd_fx.php",
							type: "POST",
							data: $("#form2").serialize(),
						})
						.done(function(data){
							if(data=="s"){
								swal("success","성공","성공적으로 비밀번호를 변경하였습니다.",`<a style="color : #2196f3;" href="/login.php">비밀번호를 변경하셨나요? 로그인하기</a>`);
							}else {
								swal("error","실패","알 수 없는 오류로 인해 비밀번호 변경에 실패하였습니다. 다시시도 해주세요.","");
							}
						});


					}else {
						swal("error","조건 불충족","비밀번호가 조건에 맞지 않습니다. 다시 확인해보세요","");	
					}
				}else {
					swal("error","삐빅!","비밀번호는 공백일 수 없습니다!","");
				}
			}

			asdf();

		}else if(data=="f"){
			swal("error","실패","해당하는 이름이나 아이디, 혹은 이메일이 존재하지 않습니다.","");
		}
	});
	return false;
}