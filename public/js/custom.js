/**
 * Created by Amir Hassan Azimi on 24/02/15.
 */
function checkResetPass() {
	var pass1 = document.getElementById('pass');
	var pass2 = document.getElementById('password_confirm');
	var message = document.getElementById('confirmMessage');
	var goodColor = "#87E696";
	var badColor = "#FF7864";
	if(pass1.value == pass2.value) {
		pass2.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "<span class='glyphicon glyphicon-ok'></span>"
	} else {
		pass2.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "<span class='glyphicon glyphicon-remove'></span>"
	}
}

function checkldlc() {
	var ldlc = document.getElementById('ldl_c');
	var message = document.getElementById('ldlcMessage');
	var goodColor = "#87E696";
	var badColor = "#FF7864";
	if(ldlc.value < 80 || ldlc.value > 200) {
		ldlc.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "<span class='glyphicon glyphicon-remove'></span>"
	} else {
		ldlc.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "<span class='glyphicon glyphicon-ok'></span>"
	}
}

function checkcholesterol() {
	var chol = document.getElementById('cholesterol');
	var message = document.getElementById('cholMessage');
	var goodColor = "#87E696";
	var badColor = "#FF7864";
	if(chol.value < 150 || chol.value > 300) {
		chol.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "<span class='glyphicon glyphicon-remove'></span>"
	} else {
		chol.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "<span class='glyphicon glyphicon-ok'></span>"
	}
}

function checkhdlc() {
	var hdlc = document.getElementById('hdl_c');
	var message = document.getElementById('hdlcMessage');
	var goodColor = "#87E696";
	var badColor = "#FF7864";
	if(hdlc.value < 30 || hdlc.value > 65) {
		hdlc.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "<span class='glyphicon glyphicon-remove'></span>"
	} else {
		hdlc.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "<span class='glyphicon glyphicon-ok'></span>"
	}
}

function checksystolic() {
	var systolic = document.getElementById('systolic');
	var message = document.getElementById('systolicMessage');
	var goodColor = "#87E696";
	var badColor = "#FF7864";
	if(systolic.value < 100 || systolic.value > 180) {
		systolic.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "<span class='glyphicon glyphicon-remove'></span>"
	} else {
		systolic.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "<span class='glyphicon glyphicon-ok'></span>"
	}
}

function checkdiastolic() {
	var systolic = document.getElementById('diastolic');
	var message = document.getElementById('diastolicMessage');
	var goodColor = "#87E696";
	var badColor = "#FF7864";
	if(systolic.value < 70 || systolic.value > 110) {
		systolic.style.backgroundColor = badColor;
		message.style.color = badColor;
		message.innerHTML = "<span class='glyphicon glyphicon-remove'></span>"
	} else {
		systolic.style.backgroundColor = goodColor;
		message.style.color = goodColor;
		message.innerHTML = "<span class='glyphicon glyphicon-ok'></span>"
	}
}