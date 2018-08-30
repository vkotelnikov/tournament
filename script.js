val = "";

function cancel(button){
	// $(button).parent().parent().html("<span class=\"team\">"+val+"</span>");
	location.reload(true);
}

function matches(){
	var count = 0;
	var round = 1;
	$.post('matches.php', {r: round}, function(data){
		// alert(data);
		var ret = JSON.parse(data);
		// alert(ret.rounds);
		count = ret.rounds;
		var padding = 0;
		for (; round <= ret.rounds; round++) {
			$("body").append('<div id = "'+round+'" style="padding-top:'+padding+'px"><h2>Раунд '+round+'</div>');
			padding+=50;
			for (var j = 0; j < ret[round].length; j++) {
				var id = 'm'+round.toString()+j.toString();
				$("#"+round).append('<canvas id="'+id+'" width="160" height="100" style="display:block;"></canvas></div>')
				draw(id, round, j, ret[round][j], ret.teams);
			}
		}
	})
}

$(document).ready(function(){

	$("span.team").click(function(){
		var id = $(this).parent().parent().attr("id");
			val = $(this).text();
			$(this).parent().html('<form action="change_team_name.php" method="POST"><input type="text" name="change_name" placeholder="'+val+'" autofocus required><input type="hidden" value="'+id+'" name="change_id"> <input type="button" onclick="cancel(this)" value="Отменить"> <input type="submit" value="ok"></form>');
	});

	$('.delete').click(function(){
		var del_id = $(this).parent().attr("id");
			$.post("delete_team.php",
				{
					id: del_id
				}, function(data)
				{
					location.reload(data);
				}
			);
	});


})