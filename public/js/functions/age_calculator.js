function getAge(birth_day, death_day) {
	if(death_day == null){
		var today = new Date();
	}else{
		console.log(birth_day, death_day)
		var today = new Date(death_day);
	}
	var birthDate = new Date(birth_day);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
		age--;
	}
	return age;
}