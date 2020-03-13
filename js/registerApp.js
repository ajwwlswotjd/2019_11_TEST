class App {
	constructor(){
		document.querySelector(".bhs_btn").addEventListener("click",this.execPostcode.bind(this));
		document.querySelector(".agree_btn").addEventListener("click",e=>$("#agree_popup").fadeIn());
		document.querySelector(".popup-box > button").addEventListener("click",e=>$("#agree_popup").fadeOut());
		this.agreeInput = document.querySelector("#inp_check");
		this.inputList =  document.querySelectorAll(".form_background input");
		this.btn = document.querySelector(".btn_submit");
		this.btn.addEventListener("click",e=>this.submit());
		this.id_ptn = /^[A-Za-z0-9+]{6,16}$/;
		this.pwd_ptn = /^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{8,20}$/;
		this.call_ptn = /^[0-9]{10,11}$/;

		this.id_ok = false;
		this.pwd_ok = false;
		this.pwd2_ok = false;
		this.call_ok = false;

		$('#id').on("input",(e)=>{
			let value = e.target.value;
			this.id_ok = this.id_ptn.test(value);
			e.target.parentNode.querySelector("p > span").style.color = this.id_ok ? "#0f851a" : "#b3130b";
		});

		$("#pwd1").on("input",(e)=>{
			$('#pwd2').val("");
			document.querySelector('#pwd2').parentNode.querySelector("p > span").style.color = "#b3130b";
			this.pwd2_ok = false;
			let value = e.target.value;
			this.pwd_ok = this.pwd_ptn.test(value);
			e.target.parentNode.querySelector("p > span").style.color = this.pwd_ok ? "#0f851a" : "#b3130b";
		});

		$('#pwd2').on("input",(e)=>{
			let value = e.target.value;
			this.pwd2_ok = value==$('#pwd1').val();
			e.target.parentNode.querySelector("p > span").style.color = this.pwd2_ok ? "#0f851a" : "#b3130b";
		});

		$("#call").on("input",(e)=>{
			let value = e.target.value;
			this.call_ok = this.call_ptn.test(value);
			e.target.parentNode.querySelector("p > span").style.color = this.call_ok ? "#0f851a" : "#b3130b";
		});
	}

	submit(){
		if(this.isEmpty()){
			swal("error","실패","비어있는 값이 있습니다. 확인해주세요.","");
			return;
		}
		if(!this.id_ok){
			swal("error","실패","아이디의 값이 조건에 맞지 않습니다.","");
			document.querySelector("#id").focus();
			return;
		}
		if(!this.pwd_ok){
			swal("error","실패","비밀번호의 값이 조건에 맞지 않습니다.","");
			document.queerySelector("#pwd1").focus();
			return;
		}
		if(!this.pwd2_ok){
			swal("error","실패","아이디와 아이디확인의 값의 다릅니다.","");
			document.queerySelector("#pwd2").focus();
			return;
		}
		if(!this.call_ok){
			swal("error","실패","휴대폰 번호의 값이 조건에 맞지 않습니다.","");
			document.querySelector("#call").focus();
			return;
		}
		if(!document.querySelector("#inp_check").checked){
			swal("error","실패","이용약관동의에 동의해주세요.","");
			return;
		}
		// 여기서부터는 회원가입의 조건이 충족된것이다.
		$("#fid").val($("#id").val());
		$("#fpwd").val($("#pwd1").val());
		$("#fname").val($("#name").val());
		$("#femail").val($("#email").val());
		$("#fcall").val($('#call').val());
		$("#faddress").val($("#address1").val()+" "+$("#address2").val());
		$.ajax({
			url: "/fx/register_fx.php",
			type: "post",
			data: $("#register_form").serialize(),
		}).done(function(data) {
			if(data=="s"){
				Swal.fire({
					title: '성공',
					text: "회원가입이 완료되었습니다. 감사합니다.",
					type: 'success',
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '확인'
				}).then((result) => {
					if (result.value) location.href = "/login.php";
				})
				return;
			} else if(data=="f") {
				swal("error","실패","알수없는 오류로 회원가입에 실패하였습니다. 다시 시도해주세요.","");
				return;
			} else {
				let txt = "이미 존재하는 ";
				txt+= data=="i" ? "아이디" : data=="p" ? "전화번호" : "이메일";
				txt+="입니다. 확인 부탁드립니다.";
				swal("error","실패",txt,"");
				return;
			}
		});
	}

	isEmpty(){
		let isEmpty = false;
		this.inputList.forEach(x=> isEmpty = x.value=="" ? true : isEmpty);
		return isEmpty;
	}

	execPostcode(){
		new daum.Postcode({
			oncomplete: function(data) {
				let address = data.roadAddress;
				document.querySelector("#address1").value = address;
			}
		}).open();
	}
}

window.onload = function(){
	let app = new App();
}

function log(c){
	console.log(c);
}

function swal(type,title,text,footer){
	Swal.fire({
		type: type,
		title: title,
		text: text,
		footer: footer
	})
}